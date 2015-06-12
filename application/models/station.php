<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/* * ******************************
  [Model Station]
  ./Entities/Station.php
  ./../controllers/station.php

* ****************************** */
define('ESC_STATION_VOLUME_1700', 1);
define('ESC_STATION_VOLUME_3000', 2);
define('ESC_STATION_VOLUME_OTHER', 10);
define('ESC_STATION_VOLUME_NONE', 100);

define('ESC_STATION_FORCE_NORMAL', 1);
define('ESC_STATION_FORCE_ONOFF', 2);

//标杆站（测试站）
define('ESC_STATION_TYPE_SAVING', 1);
//基准站
define('ESC_STATION_TYPE_STANDARD', 2); 
//不用了。。。。
define('ESC_STATION_TYPE_SIXPULSONE', 3);
//普通节能站
define('ESC_STATION_TYPE_COMMON', 4);
//N+1节能站
define('ESC_STATION_TYPE_NPLUSONE', 5);
//标杆站或者基准站
define('ESC_STATION_TYPE_SAVING_OR_STANDARD', 888);


define('ESC_BUILDING_ZHUAN', 1);
define('ESC_BUILDING_BAN', 2);


define('ESC_FAN_TYPE_BOOU', 1);
define('ESC_FAN_TYPE_BANGYANG', 2);

define('ESC_STATION_COLDS_TYPE_MEDIA', 1);
define('ESC_STATION_COLDS_TYPE_DAIKIN', 2);
define('ESC_STATION_COLDS_TYPE_FEIFAN', 3);
define('ESC_STATION_COLDS_TYPE_SANLINGHAIER', 4);

define('ESC_STATION_BOX_TYPE_CHUNLAN', 1);
define('ESC_STATION_BOX_TYPE_BANGYANG', 3);
define('ESC_STATION_BOX_TYPE_LANGJI', 4);
define('ESC_STATION_BOX_TYPE_MAIRONG', 5);
define('ESC_STATION_BOX_TYPE_NUOXI', 6);
define('ESC_STATION_BOX_TYPE_HUAWEI', 7);


define('ESC_STATION_BOX_TYPE_NONE', 2);

//站点负载等级
define('ESC_TOTAL_LOAD_10A20A', 1);
define('ESC_TOTAL_LOAD_20A30A', 2);
define('ESC_TOTAL_LOAD_30A40A', 3);
define('ESC_TOTAL_LOAD_40A50A', 4);
define('ESC_TOTAL_LOAD_50A60A', 5);
define('ESC_TOTAL_LOAD_60A70A', 6);
define('ESC_TOTAL_LOAD_70APLUS', 7);

//FRONTEND VISIBLE
define('ESC_FRONTEND_VISIBLE',1);
define('ESC_FRONTEND_UNVISIBLE', 2);

//是否安装恒温柜
define('ESC_HAVE_BOX_NONE',1);
define('ESC_HAVE_BOX',2);

//空调启动方式 1、继电器 2、脉冲开关 3、接触器485 4、红外 5、无
define('ESC_STATION_COLDS_FUNC_RELAY', 1);
//define('ESC_STATION_COLDS_FUNC_PLUSE', 2);
define('ESC_STATION_COLDS_FUNC_485', 3);
define('ESC_STATION_COLDS_FUNC_INFRARED', 4);
define('ESC_STATION_COLDS_FUNC_NONE', 5);


//基站的状态 ：1、工程安装，建站 2、工程验收 3、内部验收 4、正常运营 
define('ESC_STATION_STATUS_NORMAL', 1);
define('ESC_STATION_STATUS_CREATE', 2);
define('ESC_STATION_STATUS_PASS',   3);
define('ESC_STATION_STATUS_YUNWEI', 4);
define('ESC_STATION_STATUS_REMOVE', 5);

define('ESC_STATION_SETTING_UNLOCK', 1);
define('ESC_STATION_SETTING_LOCK', 2);
define('ESC_STATION_EXTRA_AC',1);
define('ESC_STATION_NO_EXTRA_AC',2);
define('ESC_STATION_SETTING_NO', 1);
define('ESC_STATION_SETTING_YES', 2);


class Station extends ES_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->table_name = "stations";
        $this->load->helper("station");
    }


    public function getNameChn($station_id){
        $station = $this->station->find($station_id);
        return $station?$station['name_chn']:"";
    }


    public function getAndCheckStation($station_id){
        $station = $this->station->find($station_id);
        if (!$station)  show_error("no station " . $station_id . " !"); 
        return $station;
    }



    public function whereAllStations($project_id = null){
        $conditions = array('recycle' => ESC_NORMAL,"status !=" => ESC_STATION_STATUS_REMOVE);
        if ($project_id) {
            $conditions += array("project_id" => $project_id);
        }
        $this->db->where($conditions);
    }

    //返回所有
    public function findAllStations($project_id = null) {
        $this->station->whereAllStations($project_id);
        return $this->findBy();
    }

    //返回某一时间点已经建立的站点
    public function findAllBuiltStations($datetime,$project_id = null) {
        $this->station->whereAllStations($project_id);
        return $this->findby(array("create_time < " => $datetime));
    }

    //检测基站是否正确 并更新在线情况
    //====有单元测试====
    public function check_and_refresh_station($station_id) {
        if (!$station_id){ 
            return null; 
        }
        $station = $this->station->find($station_id);
        if ($station) {
            $this->update($station_id, array("alive"=>ESC_ONLINE,"last_connect_time"=>h_dt_now()));
            $station['alive'] = ESC_ONLINE;
        }
        return $station;
    }

    //根据基站ID返回基站名 
    //参数 $station_id 基站id
    //返回 基站名
    //====有单元测试====
    public function getStationNameChn($station_id) {
        $station = $this->find_sql($station_id);
        return $station ? $station['name_chn'] : "无此站点";
    }

    //根据基站ID返回基站地址 
    //参数 $station_id 基站id
    //返回 基站地址
    public function getStationAddressNameChn($station_id) {
        $station = $this->find_sql($station_id);
        return $station ? $station['address_chn'] : "无此站点";
    }

    public function errorStationsOffline(){
        $this->db->where("last_connect_time < date_sub(now(),interval 11 minute)");
        $this->db->where(array("recycle"=>ESC_NORMAL, 
            "status !=" => ESC_STATION_STATUS_REMOVE));
        $this->station->updateBy(array("alive"=>ESC_OFFLINE));

        $this->station->where(array("alive"=>ESC_OFFLINE));
        $offline_stations = $this->station->findAllStations();

        $bug_stations = array();
        foreach($offline_stations as $station){
            $bug_stations[$station['id']] = "";
        }
        return $bug_stations;
    }


    //给基站加减分的，
    //参数 $station_id 基站id 
    //参数 $point 格式如下 +10 -10
    public function changeStationBugPoint($station_id,$method,$point){
        $this->station->find_sql($station_id);
        //如果是基准站或者标杆站 point x 100  n+1的基站 x 50
        $station = $this->find_sql($station_id);
        $point = $point * h_station_type_modulus($station['station_type']);
        $query = $this->db->query("update stations set bug_point = bug_point ".$method.$point." where id = ".$station_id);
    }

    //返回所有基站id的数组(不包含被删除的)
    //====有单元测试====
    public function getAllStationIds($project_id = null ,$city_id = null) {
        //$query = $this->db->query("select id station_id from stations where recycle=1");
        $conditions = array("recycle"=>ESC_NORMAL);
        if ($project_id) {
            $conditions += array("project_id" => $project_id);
        }
        if ($city_id) {
            $conditions += array("city_id" => $city_id);
        }
        $res = $this->findBy_sql($conditions);
        $ids = array();
        foreach($res as $station){
            array_push($ids,$station['id']);
        }
        return $ids;
    }

    //返回 所有"产品项目"中的基站的 基站id的数组(不包含被删除的)
    //====有单元测试====
    public function getAllProductStationIds() {
        $query = $this->db->query("select stations.id as station_id from stations left join projects on stations.project_id = projects.id 
            where stations.recycle=1 and projects.is_product=1");
        $res = $query->result_array();
        return h_array_to_array($res,"station_id");
    }

    //返回 所有基站类型为"基准站" 基站id的数组(不包含被删除的)
    public function findAllStandardStations() {
        return $this->station->findBy(array(
            "recycle"=>1,
            "status !=" => ESC_STATION_STATUS_REMOVE,
            "station_type"=>ESC_STATION_TYPE_STANDARD));
    }
    
    // 返回 所有需要判断高温远程重启的基站
    public function findAllRebootStations() {
        return $this->station->findBy(array(
            "temp_high_reboot"=>2,
            "recycle"=>1,
            "status !=" => ESC_STATION_STATUS_REMOVE));
    }

    //返回 所有没有安装室外温感的 基站id的数组(不包含被删除的)
    public function findAllNoOutdoorStations() {
        return $this->station->findBy(array(
            "recycle"=>1,
            "status !=" => ESC_STATION_STATUS_REMOVE,
            "equip_with_outdoor_sensor"=>ESC_BEINGLESS));
    }

    //返回 所有没有安装恒温柜的 id的数组(不包含被删除的)
    public function findAllNoBoxStations() {
        return $this->station->findBy(array(
            "recycle"=>1,
            "status !=" => ESC_STATION_STATUS_REMOVE,
            "have_box"=> ESC_HAVE_BOX_NONE));
        //上面一行 have_box 要好好整理
    }

    //返回 所有只装了一台空调的 基站id的数组(不包含被删除的)
    public function findAllOneColdsStations() {
        return $this->station->findBy(array(
            "recycle"=>1,
            "colds_num"=>1));
    }

    //返回 所有正在被强制动作（强制开新风或空调）的 基站id的数组(不包含被删除的)
    public function findAllForceOnStations() {
        return $this->station->findBy(array(
            "recycle"=>1,
            "force_on"=>ESC_STATION_FORCE_ONOFF));
    }

    public function setForceOn($station_id){
        $this->station->update($station_id,array("force_on"=>ESC_STATION_FORCE_ONOFF));
    }

    private function turnStationArraytoIds($stations){
        $ids = array();
        foreach($stations as $station){
            array_push($ids,$station['id']);
        }
        return $ids;
    } 

    //返回某时间点已经建立的基站id数组 
    public function findCreatedStationIds($day_time){
        $query = $this->db->query("select id from stations where recycle = ? and create_time<?",array(ESC_NORMAL,$day_time));
        $stations = $query->result_array();
        return $this->turnStationArraytoIds($stations);
    }

    public function findCreatedStations($day_time){
        return $this->station->findBy(array(
            "recycle"=>ESC_NORMAL, 
            "status !=" => ESC_STATION_STATUS_REMOVE,
            "create_time <"=>$day_time));
    }



    //返回 所有"产品项目"中的基站的 基站id的数组(不包含被删除的)
    //====有单元测试====
    public function findProductNormalStations() {
        $query = $this->db->query("select id from projects where is_product=1"); 
        $p_ids = h_array_to_id_array($query->result_array());
        if(!$p_ids){
            return array();
        }else{
            $this->db->where("project_id in (".implode(",",$p_ids).")");
            return $this->station->findNormalStations();
        }
    }



    //返回所有 基站sql数组（不包括被删除的 和搬迁的）而且按照基站排序了
    public function findNormalStations($project_id = null) {
        $conditions = array('recycle' => ESC_NORMAL,
                        'status !=' => ESC_STATION_STATUS_REMOVE);
        $order = array('project_id asc', 'city_id asc');
        if ($project_id) {
            $conditions += array("project_id" => $project_id);
            $order = array('city_id asc');
        }
        return $this->findby($conditions, $order);
    }


    //返回所有基站类型是n+1的 基站sql数组（不包括被删除的）
    //参数 $project_id  项目id 如果设置只返回一个项目的该类型基站
    public function findAllNp1Stations_sql($project_id = null) {
        $conditions = array('recycle' => ESC_NORMAL, 'station_type' => ESC_STATION_TYPE_NPLUSONE);
        if ($project_id) {
            $conditions += array("project" => $project_id);
        }
        return $this->findby_sql($conditions);
    }



    public function find_single_standard_station_sql($station) {
        if($sid = $station["standard_station_id"]){
            $std_station = $this->find_sql($sid);
            if($std_station["recycle"]==ESC_NORMAL && $std_station["station_type"]==ESC_STATION_TYPE_STANDARD
                && $std_station["project_id"] == $station["project_id"]
                && $std_station["city_id"] == $station["city_id"]
                && $std_station["building"] == $station["building"]
                && $std_station["total_load"] == $station["total_load"]){
                    return $std_station;
                }
        }
        return $this->findOneBy_sql(array("recycle" => ESC_NORMAL, "station_type" => ESC_STATION_TYPE_STANDARD,
            "project_id" => $station["project_id"], "city_id" => $station["city_id"],
            "building" => $station["building"], "total_load" => $station["total_load"]));

    }

    public function find_standard_stations($station_id) {
        $station = $this->station->find_sql($station_id);
        return $this->findBy_sql(array("recycle" => ESC_NORMAL, "station_type" => ESC_STATION_TYPE_STANDARD,
            "project_id" => $station['project_id'], "city_id" => $station['city_id'],
            "building" => $station['building'], "total_load" => $station['total_load']));
    }


    public function findUserNearestNewStation($user) {
        $station = $this->station->findOneBy_sql(array(
            "creator_id"=>$user['id'],
            "recycle" => ESC_NORMAL),array("id desc"));
        return $station;
    }



    public function getCityStationNums($project_id,$city_id){
        $query = $this->db->query("select total_load,building,station_type,count(id) a from stations 
            where recycle=? and frontend_visible=? and status <> ? 
            and project_id = ? and city_id = ? group by total_load,building,station_type",
            array(ESC_NORMAL,ESC_NORMAL,ESC_STATION_STATUS_REMOVE,$project_id,$city_id));
        foreach (h_station_total_load_array() as $load_level => $name){
            foreach (h_station_building_array() as $building => $name){
                foreach (h_station_station_type_array() as $station_type => $name){
                    $result[$load_level][$building][$station_type] = 0;
                }
            }
        }
        foreach ($query->result_array() as $item){
            $result[$item['total_load']][$item['building']][$item['station_type']] = $item['a'];
        }
        return $result;
    }


    public function searchFromProjectByName($name,$project_id,$city_id){
        $stations = array();
        if($name){
            $query = $this->db->query("select * from stations 
                where name_chn like '%".$name."%' 
                and recycle=? and project_id = ? and status <> ?",
                array( ESC_NORMAL, $project_id, ESC_STATION_STATUS_REMOVE));
            $stations = $query->result_array();
        }
        return $stations;
    }


    public function findStationsSql($conditions, $orders, $params) {
        $condition_array = array();
        $order_array = array();
        foreach ($conditions as $k => $v) {
            if ($v) {
                array_push($condition_array, $k . $v);
            }
        }
        foreach ($orders as $k => $v) {
            array_push($order_array, $k . " " . $v);
        }
        $str = "";
        if (count($condition_array)) {
            $str .= " where " . implode(" and ", $condition_array);
        }
        if (count($order_array)) {
            $str .= " order by " . implode(",", $order_array);
        }

        $sql = "select " . $params . " from stations" . $str;
        $query = $this->db->query($sql);
        return $query->result_array();
    }


    public function new_sql($_params) {
        $_params['name_chn'] =        isset($_params['name_chn'])   ?$_params['name_chn']          :'未命名';
        $_params['name_py'] =         isset($_params['name_py'])    ?$_params['name_py']           :null;
        $_params['ip'] =              isset($_params['ip'])         ?$_params['ip']                :null;
        $_params['alive'] =           isset($_params['alive'])      ?$_params['alive']             :ESC_OFFLINE;
        $_params['comment'] =         isset($_params['comment'])    ?$_params['comment']           :'';
        $_params['lng'] =             isset($_params['lng'])        ?$_params['lng']               :null;
        $_params['lat'] =             isset($_params['lat'])        ?$_params['lat']               :null;
        $_params['colds_num'] =       isset($_params['colds_num'])  ?$_params['colds_num']         :2;
        $_params['total_load'] =      isset($_params['total_load']) ?$_params['total_load']        :ESC_TOTAL_LOAD_20A30A;
        $_params['last_connect_time'] = isset($_params['last_connect_time'])?$_params['last_connect_time']:null;
        $_params['station_type'] =    isset($_params['station_type']) ?$_params['station_type']    :ESC_STATION_TYPE_SAVING;
        $_params['fan_type'] =        isset($_params['fan_type'])     ?$_params['fan_type']        :0;
        $_params['building'] =        isset($_params['building'])     ?$_params['building']        :ESC_BUILDING_ZHUAN;
        $_params['colds_0_type'] =    isset($_params['colds_0_type']) ?$_params['colds_0_type']    :0;
        $_params['colds_1_type'] =    isset($_params['colds_1_type']) ?$_params['colds_1_type']    :0;
        $_params['rom_id'] =          isset($_params['rom_id'])       ?$_params['rom_id']          :null;
        $_params['city_id'] =         isset($_params['city_id'])        ?$_params['city_id']        :null;
        $_params['address_chn'] =     isset($_params['address_chn'])    ?$_params['address_chn']    :'';
        $_params['project_id'] =      isset($_params['project_id'])     ?$_params['project_id']     :null;
        $_params['recycle'] =         isset($_params['recycle'])        ?$_params['recycle']        :ESC_NORMAL;
        $_params['creator_id'] =      isset($_params['creator_id'])     ?$_params['creator_id']     :null;
        $_params['create_time'] =     isset($_params['create_time'])    ?$_params['create_time']    :h_dt_now();
        $_params['box_type'] =        isset($_params['box_type'])       ?$_params['box_type']       :ESC_BEING;
        $_params['equip_with_outdoor_sensor'] = isset($_params['equip_with_outdoor_sensor'])?$_params['equip_with_outdoor_sensor']:ESC_BEING;
        $_params['force_on'] =        isset($_params['force_on'])       ?$_params['force_on']       :ESC_STATION_FORCE_NORMAL;
        $_params['air_volume'] =      isset($_params['air_volume'])     ?$_params['air_volume']     :0;
        $_params['load_num'] =        isset($_params['load_num'])       ?$_params['load_num']       :0;
        $_params['bug_point'] =       isset($_params['bug_point'])      ?$_params['bug_point']      :100;
        $_params['ns'] =              isset($_params['ns'])             ?$_params['ns']             :0;
        $_params['ns_start'] =        isset($_params['ns_start'])       ?$_params['ns_start']       :h_dt_format("now","Ymd000000");
        $_params['standard_station_id'] = isset($_params['standard_station_id'])?$_params['standard_station_id']:0;

        $_params['stage'] =           isset($_params['stage'])          ?$_params['stage']          :1;
        $_params['status'] =           isset($_params['status'])          ?$_params['status']          :ESC_STATION_STATUS_CREATE;

        return parent::new_sql($_params);
    }


    //查找工单类型的基站
    public function findStationWorkOrder_sql($work_order_status=null){
        if(!$work_order_status){
            return array();
        }
        $query = $this->db->query("select * from stations where recycle=? and work_order_status=?",array(ESC_NORMAL,$work_order_status));
        return $query->result_array();
    }


    //根据基站ID获取工单状态
    //by liwen  
    //参数 $station_id 基站id
    //返回 work_order_status
    public function getWork_order_status_sql($station_id) {
        $station = $this->find_sql($station_id);
        return $station['work_order_status'];
    }

    //如果是基准站或者标杆站 point x 5  n+1的基站 x 3
    //===有单元测试
    public function bug_station_type($station_type){
        switch ($station_type){
        case ESC_STATION_TYPE_SAVING:
        case ESC_STATION_TYPE_STANDARD:
            $modulus=7;
            break;
        case ESC_STATION_TYPE_NPLUSONE:
            $modulus=4;
            break;
        default:
            $modulus=1;
        }
        return $modulus;
    }

    //查找未生成工单的基站
    //返回值数组
    //todo 重构
    public function prepare_station_orders($conditions,$orders,$cur_page,$per_page){
        $condition_array = array();
        $where_str = "";
        foreach($conditions as $k=>$v){
            if($v){
                array_push($condition_array,$k." ".$v);
            }
        }
        if(count($condition_array)){
            $where_str.= " and ".implode(" and ",$condition_array);
        }

        //拼where 和 order 字符串
        $where_order = "";
        $order_array = array();
        foreach($orders as $k=>$v){
            if($v){
                array_push($order_array,$k.$v);
            }
        }
        if(count($order_array)){
            $where_order .= " order by ".implode(",",$order_array);
        }

        //查询（总数以及某一页的数据）
        $sql_num = "select count(*) as num from stations where recycle=".ESC_NORMAL." and bug_point>0 and id not in (select station_id from work_orders where is_history=".ESC_WORK_ORDER_ALIVE.")".$where_str;
        $sql = "select * from stations where recycle=".ESC_NORMAL." and bug_point>0 and id not in (select station_id from work_orders  where is_history=".ESC_WORK_ORDER_ALIVE.")".$where_str.$where_order." limit ".($per_page*($cur_page-1)).",".$per_page;
        $query = $this->db->query($sql_num);
        $res_num = $query->row_array();
        $query = $this->db->query($sql);
        $res = $query->result_array();
        return array("num"=>$res_num['num'],"res"=>$res);

    }


    function getStandardStations($project_id,$city_id,$load_level,$building){
        return $this->station->findBy(array(
            'frontend_visible'=>ESC_NORMAL,
            'recycle'=>ESC_NORMAL,
            'status <> '=>ESC_STATION_STATUS_REMOVE,
            "project_id"=>$project_id,
            "city_id"=>$city_id,
            "total_load"=>$load_level,
            "building"=>$building,
            "station_type"=>ESC_STATION_TYPE_STANDARD
        ));
    }

    function getSavingStations($project_id,$city_id,$load_level,$building){
        return $this->station->findBy_sql(array(
            'frontend_visible'=>ESC_NORMAL,
            'recycle'=>ESC_NORMAL,
            'status <> '=>ESC_STATION_STATUS_REMOVE,
            "project_id"=>$project_id,
            "city_id"=>$city_id,
            "total_load"=>$load_level,
            "building"=>$building,
            "station_type"=>ESC_STATION_TYPE_SAVING
        ));
    }

    function getCommonStationsPagination($project_id,$city_id,$load_level,$building,$per_page,$cur_page){
        return $this->station->pagination_sql(array(
            'frontend_visible ='=>ESC_NORMAL,
            'recycle ='=>ESC_NORMAL,
            'status <> '=>ESC_STATION_STATUS_REMOVE,
            "project_id ="=>$project_id,
            "city_id ="=>$city_id,
            "total_load ="=>$load_level,
            "building ="=>$building,
            "station_type ="=>ESC_STATION_TYPE_COMMON
        ),array("alive"=>"asc"),$per_page,$cur_page);
    }



    //by boyu.liu
    public function get_station_energy($station_id,$date){
        $query = $this->db->query("select main_energy,ac_energy,dc_energy from daydatas where day = ? and station_id = ?",
            array($date,$station_id));
        $result = $query->row_array();
        return $result;
    }  

    public function group_by_total_load($station_array){
        $stations_group_by_total_load = array();
        foreach (h_station_total_load_array() as $total_load => $name) {
            $stations_group_by_total_load[$total_load] = array();
        }
        foreach ($station_array as $station) {
            if (h_check_total_load($station["total_load"])) {
                array_push($stations_group_by_total_load[$station["total_load"]], $station);
            }
        }
        return $stations_group_by_total_load;
    }

    public function order_by_total_load($array){
        $array_ordered = array();
        foreach(h_station_total_load_array() as $total_load=>$total_load_chn){
            if(isset($array[$total_load])){
                $array_ordered[$total_load] = $array[$total_load];
            }
        }
        return $array_ordered;
    }

    public function getStationLoadNum($station_id){
        $station = $this->find_sql($station_id);
        if(!$station){
            return null;
        }
        return $station['load_num'];
    }

    public function getSomeAvailableStationAtTime($param,$time,$order_array){
        $this->db->where($param);
        $this->db->where('create_time <',$time);
        $this->db->order_by(implode(',',$order_array));
        $query = $this->db->get('stations');
        $stations = $query->result_array();
        return $stations;
    }

    public function getStanardSavingStationsHash($project_id,$city_id,$building,$datetime){
        $this->db->where("create_time < ".h_dt_format($datetime));
        $this->db->where("(station_type = ".ESC_STATION_TYPE_STANDARD." or station_type = ".ESC_STATION_TYPE_SAVING.")");
        $stations = $this->findBy_sql(array(
            "project_id"=>$project_id,
            "recycle"=>ESC_NORMAL,
            "city_id"=>$city_id,
            "building"=>$building
        ));
        $result = array();
        foreach($stations as $station){
            $result[$station['total_load']][$station['station_type']][] = $station;
        }
        return $result;
    }






}

