<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//bug
define('ESC_BUG_STATUS__OPEN',1);
define('ESC_BUG_STATUS__CLOSED',2);

define('ESC_BUG__DISCONNECT',2);  //失去链接
define('ESC_BUG__485_DIE',3);    //485死机
define('ESC_BUG__SENSOR_INDOOR_BROKEN',4);  //室内传感器坏
define('ESC_BUG__SENSOR_OUTDOOR_BROKEN',5);  //室外传感器坏
define('ESC_BUG__SENSOR_BOX_BROKEN',6);  //恒温柜温感坏
define('ESC_BUG__SENSOR_COLDS0_BROKEN',7); //空调1传感坏
define('ESC_BUG__SENSOR_COLDS1_BROKEN',8);//空调2传感坏
define('ESC_BUG__485_LONG_DIE',9);
define('ESC_BUG__CONNECT_WEAK',12);  //弱链接
define('ESC_BUG__SMART_METER_BROKEN',13);  //电表故障
define('ESC_BUG__NO_POWER',14);    //停电
define('ESC_BUG__NO_COLDS_ON',15);    //节能bug
define('ESC_BUG__INDOOR_TMP_HIGH',21); // 室内高温
define('ESC_BUG__BOX_TMP_HIGH',22);    // 恒温柜高温
define('ESC_BUG__SMART_METER_BROKEN_2',23); //电表故障2 
define('ESC_BUG__COLDS_OUT_CTRL',24); //空调不受控 
define('ESC_BUG__HAS_OTHER_EQP',25); //有其他交流设备
define('ESC_BUG__SMART_METER_REVERSE',26); //电表环反接

define('ESC_BUG__AUTOCHECK',30);  //自检
define('ESC_BUG__MAINTAINANCE_BUTTON',31);  //代维按钮
define('ESC_BUG__REMOTE_OFF',33);  //远程关站
define('ESC_BUG__COLDS_0_FAIL',34);  //空调1坏
define('ESC_BUG__COLDS_1_FAIL',35);  //空调2坏

define('ESC_BUG__DC_ENERGY_ABNORMAL',41);    //DC能耗异常
define('ESC_BUG__MAIN_ENERGY_ABNORMAL',42);    //总能耗异常
define('ESC_BUG__SAVING_ABNORMAL',51);  //节能异常

class Bug extends ES_Model {

    public function __construct(){
        parent::__construct();
        $this->load->database();
        $this->table_name = "bugs";
        $this->load->helper('bug');
        $this->load->model('station');
        $this->load->helper('datetime');
    }

    public function paramFormat($_params) {
        $_params['station_id']  = isset($_params['station_id'])  ? $_params['station_id']  : 0;
        $_params['status']      = isset($_params['status'])      ? $_params['status']      : ESC_COMMAND_STATUS__OPEN;
        $_params['start_time']  = isset($_params['start_time'])  ? $_params['start_time']  : h_dt_now();
        $_params['update_time'] = isset($_params['update_time']) ? $_params['update_time'] : h_dt_now();
        $_params['user_id']     = isset($_params['user_id'])     ? $_params['user_id']     : null;
        return $_params;
    }


    public function updateBugsTime($opened,$type){
        if($opened){
            $this->db->where("station_id in (".implode(",",array_keys($opened)).")");
            $this->bug->updateBy(array("update_time"=>h_dt_now()),array("type"=>$type,"status"=>ESC_BUG_STATUS__OPEN));
        }
    }

    public function insertBugs($open_bug_stations,$type){
        $open_insert_array = array();
        foreach($open_bug_stations as $station_id=>$arg){
            $_s = $this->station->find($station_id);
            $open_insert_array[] = array("station_id"=>$station_id,
                "type"=>$type,
                "arg"=>$arg,
                "status"=>ESC_BUG_STATUS__OPEN,
                "project_id"=>$_s['project_id'],
                "city_id"=>$_s['city_id'],
                "user_id"=>$_s['creator_id']);
        }
        $this->bug->insert_array($open_insert_array);
    }

    public function openBugs($bug_stations,$type){
        if($bug_stations){
            $this->db->select("station_id");
            $this->db->where("station_id in (".implode(',',array_keys($bug_stations)).")");
            $bugs = $this->bug->findBy(array("status"=>ESC_BUG_STATUS__OPEN,"type"=>$type));
            $opened = h_array_to_hash($bugs,"station_id");
            $open_bug_stations = array_diff_key($bug_stations, $opened);  //新增加的bug基站
            //open bugs
            $this->bug->insertBugs($open_bug_stations,$type);
            //update bugs
            $this->bug->updateBugsTime($opened,$type);
        }
    }

    public function openAndCloseBugs($station_bugs,$type){
        $old_bugs  = $this->bug->findBy(array("type"=>$type,"status"=>ESC_BUG_STATUS__OPEN));
        $old_station_bugs    = h_array_to_hash($old_bugs,"station_id");
        $open_station_bugs   = array_diff_key($station_bugs,$old_station_bugs);   
        $close_station_bugs  = array_diff_key($old_station_bugs,$station_bugs); 
        $update_station_bugs = array();
        if ($type === ESC_BUG__INDOOR_TMP_HIGH) {   // 只对带arg的类型进行更新
            $update_station_bugs = array_intersect_key($station_bugs,$old_station_bugs); //前者带arg
        }

        //close bugs 
        if($close_station_bugs){
            $this->db->where("station_id in (".implode(',',array_keys($close_station_bugs)).")"); 
            $this->db->where(array("status"=>ESC_BUG_STATUS__OPEN ,"type"=>$type));
            $this->bug->updateBy(array("stop_time"=>h_dt_now(),"status"=>ESC_BUG_STATUS__CLOSED));
        }

        //update bugs
        if ($update_station_bugs) {
            foreach ($update_station_bugs as $station_id => $arg) {
                if ($type === ESC_BUG__INDOOR_TMP_HIGH) {
                    $this->updateBugArg($station_id, ESC_BUG__INDOOR_TMP_HIGH, $arg);
                }
            }
        }

        $this->bug->insertBugs($open_station_bugs,$type);
    }

    public function closeAll($type){
        $this->bug->updateBy(
            array("status"=>ESC_BUG_STATUS__CLOSED),
            array("type"=>$type,"status"=>ESC_BUG_STATUS__OPEN));
    }

    public function findOpenBug($station_id,$type){
        return $this->bug->findOneBy(array("station_id"=>$station_id,"type"=>$type,"status"=>ESC_BUG_STATUS__OPEN));
    }

    public function findNoTempOfflineBugs(){
        $this->db->where("arg is null");
        return $this->bug->findBy(array("type"=>ESC_BUG__DISCONNECT,"status"=>ESC_BUG_STATUS__OPEN));
    }

    public function ClearOtherBugs($station_id){ 
        $this->db->query("update bugs set stop_time=NOW(),status=? where station_id=? and status=? and type<>?",
            array(ESC_BUG_STATUS__CLOSED,$station_id,ESC_BUG_STATUS__OPEN,ESC_BUG__DISCONNECT));
    }


    ///////////// golden function AAAAAAup/////////////////////////////////////////////////////



    public function hasCloseWarning($json,$id){
        $_data = json_decode($json);
        if (!empty($_data)) {
            foreach ($_data as $_time => $_dataitem) {
                foreach ($_dataitem as $_bug_type){
                    if ($id == $_bug_type) {
                         return true;       
                    }
                }
            }
        }
        return false;
    }

    public function closeBugsByJson($station_id,$json){
        $_data = json_decode($json);
        if (empty($_data)) {
            log_message('error', 'json close warn error:' . $json);
        } else {
            foreach ($_data as $_time => $_dataitem) {
                foreach ($_dataitem as $_bug_type){
                    if (17 == $_bug_type) {
                        $this->closeBugs($station_id,ESC_BUG__MAINTAINANCE_BUTTON);
                    }
                    if (19 == $_bug_type) {
                        $this->closeBugs($station_id,ESC_BUG__REMOTE_OFF);
                    }
                    if (20 == $_bug_type) {
                        $this->closeBugs($station_id,ESC_BUG__AUTOCHECK);
                    }
                    if (21 == $_bug_type) {
                        $this->closeBugs($station_id,ESC_BUG__COLDS_0_FAIL);
                    }
                    if (22 == $_bug_type) {
                        $this->closeBugs($station_id,ESC_BUG__COLDS_1_FAIL);
                    }
                }
            }
        }
    }

    public function updateBugsByJson($station_id,$json){
        $_data = json_decode($json);
        if (empty($_data)) {
            log_message('error', 'json warn error:' . $json);
        } else {
            foreach ($_data as $_time => $_dataitem) {
                foreach ($_dataitem as $_bug_type){
                    if (17 == $_bug_type) {
                        $this->updateBugs($station_id,ESC_BUG__MAINTAINANCE_BUTTON);
                    }
                    if (19 == $_bug_type) {
                        $this->updateBugs($station_id,ESC_BUG__REMOTE_OFF);
                    }
                    if (20 == $_bug_type) {
                        $this->updateBugs($station_id,ESC_BUG__AUTOCHECK);
                    }
                    if (21 == $_bug_type) {
                        $this->updateBugs($station_id,ESC_BUG__COLDS_0_FAIL);
                    }
                    if (22 == $_bug_type) {
                        $this->updateBugs($station_id,ESC_BUG__COLDS_1_FAIL);
                    }
                }
            }
        }
    }
    
    public function updateBugArg($station_id, $type, $arg) {
        $bug = $this->bug->findOpenBug($station_id, $type);
        if ($bug) {
            $this->bug->update_sql($bug['id'], array("arg" => $arg));
        }
    }

    public function updateBugs($station_id,$type){
        $bug = $this->bug->findOpenBug($station_id,$type);
        if($bug){
            $this->bug->update_sql($bug['id'],array("update_time"=>h_dt_now_str()));
        }else{
            $station = $this->station->find_sql($station_id);
            if($station){
                $this->db->query("insert into bugs (city_id,project_id,user_id,start_time,update_time,station_id,status,type) values (?,?,?,NOW(),NOW(),?,?,?)",
                    array($station['city_id'],$station['project_id'],$station['creator_id'],$station_id,ESC_BUG_STATUS__OPEN,$type));
            }
        }
    }
    public function closeBugs($station_id,$type){
        $bug = $this->bug->findOpenBug($station_id,$type);
        if($bug){
            $this->bug->update_sql($bug['id'],array("stop_time"=>h_dt_now_str(),"status"=>ESC_BUG_STATUS__CLOSED));
        }
    }

    public function closeOverTimeBugs(){
        $this->db->query("update bugs set stop_time=NOW(),status=? where status=? and type in (?) and update_time < date_sub(now(),interval 20 minute) ",
            array(ESC_BUG_STATUS__CLOSED,ESC_BUG_STATUS__OPEN,implode(',',array(ESC_BUG__MAINTAINANCE_BUTTON,ESC_BUG__REMOTE_OFF))));
    }




    public function closeBugsByStation($station_ids,$type){
        if($station_ids){
            $this->db->query("update bugs set stop_time=NOW(),status=? where station_id in (".implode(',',$station_ids).") and status=? and type=?",array(ESC_BUG_STATUS__CLOSED,ESC_BUG_STATUS__OPEN,$type));
        }
    }


    public function findStationOpenBugs($station_id){
        $bugs = array();
        if($station_id){
            $bugs = $this->findBy_sql(array("status"=>ESC_BUG_STATUS__OPEN,"station_id"=>$station_id));
        }
        return $bugs;
    }

    //VVVVVVVVV 这边往下全部重构！！！！！ =============================================================

    //根据基站号查询所有已打开的故障
    public function find_stationid_sql($station_id){
        $query = $this->db->query("select * from bugs where status=? and station_id=?",array(ESC_BUG_STATUS__OPEN,$station_id));
        return $query->result_array();
    }


    //返回某个基站的故障
    //该故障还存在
    public function findBugByStationId($station_id){
        $results = $this->find_stationid_sql($station_id);
        $bugs = array();
        foreach($results as $result){
            $bugs[]=$result['type'];
        }
        return $bugs;
    }

    //查询某个基站的故障
    //开始时间  -- 到结束时间 可选参数
    //两种形式，一种是在开始一段时间后故障over了 还有一种是故障一直都存在
    //这里的时间是10位的时间搓形式
    public function findBugByStationIdOnTime($station_id,$start_time,$end_time){
        if(!$station_id || !$start_time || !$end_time){
            return ;
        }
        $query = $this->db->query("select * from bugs where station_id =? and start_time <= ? and ((stop_time > ? and stop_time <= ? and status = ?) or (status = ?)) ",
                    array($station_id,$start_time,$start_time,$end_time,ESC_BUG_STATUS__CLOSED,ESC_BUG_STATUS__OPEN));
        $bugs = $query->result_array();
        $bug_type_ids = "";
        foreach($bugs as $bug){
            $bug_type_ids.=$bug['type'].",";
        }
        return trim($bug_type_ids,",");
    }



    public function findBugsBeforeOffline($station_id){
        $disconnect = $this->bug->findOpenBug($station_id,ESC_BUG__DISCONNECT);
        $bugs = array();
        if($disconnect){
            $start_time = $disconnect['start_time'];
            $bugs = $this->bug->findBy(array(
                "station_id"=>$station_id,
                "stop_time >"=>h_dt_sub_min($start_time)));
        }
        return $bugs;
    }





    //查询某个基站到某个时间点之前仍处于开启状态的故障
    //by qianlei,2013.1.22
    //modified by chuanqi, 2014.06.19
    //判断$time必须为10位数字的时间搓
    public function findBugByStationUntilTime($station_id,$time){
        $station_bugs = array();
        if($station_id && $time && h_dt_is_date($time)){
            $query = $this->db->query("select * from bugs where station_id=? and status=? and start_time<=?",
                        array($station_id,ESC_BUG_STATUS__OPEN,h_dt_format($time)));
            return $query->result_array();
        }
        return $station_bugs;
    }
}






















