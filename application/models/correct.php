<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define('ESC_CORRECT__MAIN_ENERGY', 1);

class Correct extends ES_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->table_name = "corrects";
    }

    public function paramFormat($_params) {
        $_params['station_id']   = isset($_params['station_id'])   ? $_params['station_id']   : 0;
        $_params['correct_num']  = isset($_params['correct_num'])  ? $_params['correct_num']  : 0;
        $_params['org_num']      = isset($_params['org_num'])      ? $_params['org_num']      : 0;
        $_params['type']         = isset($_params['type'])         ? $_params['type']         : 1;
        $_params['base']         = isset($_params['base'])         ? $_params['base']         : null; 
        $_params['correct_base'] = isset($_params['correct_base']) ? $_params['correct_base'] : null;
        $_params['slope']        = isset($_params['slope'])        ? $_params['slope']        : null;
        $_params['time']         = isset($_params['time'])         ? $_params['time']         : h_dt_now();
        $_params['last_correct_num']  = isset($_params['last_correct_num'])  ? $_params['last_correct_num']  : null;
        $_params['last_org_num']      = isset($_params['last_org_num'])      ? $_params['last_org_num']      : null;
        $_params['last_time']         = isset($_params['last_time'])         ? $_params['last_time']         : null;
        return $_params;
    }

    public function calc_last_correct($station_id){
        $correct_1 = $this->findLastCorrect($station_id);
        $correct_2 = $this->findSecondLastCorrect($station_id);
        $res = $this->calc_correct($correct_1,$correct_2);
        $this->correct->update_sql($correct_1['id'],array(
            "base"=>$res['base'],
            "correct_base"=>$res['correct_base'],
            "slope"=>$res['slope']));
        $this->correct->update_sql($correct_2['id'],array(
            "base"=>null,"correct_base"=>null,"slope"=>null));
        return; 
    }

    public function calc_correct($correct_1,$correct_2){
        $result=array("base"=>0,"correct_base"=>0,"slope"=>1);
        if($correct_1 && $correct_2){
            $delta_org_num = $correct_1['org_num'] - $correct_2['org_num'] ;
            $delta_correct_num = $correct_1['correct_num'] - $correct_2['correct_num'];
            $result["base"] = $correct_1['org_num'];
            $result["correct_base"] = $correct_1['correct_num'];
            if($delta_org_num > 0 && $delta_correct_num > 0){
                $result["slope"] = round(
                    $delta_correct_num / $delta_org_num,6);
            }else{
                $result["slope"] = 0;
            }
        }else if($correct_1){
            $result["base"] = $correct_1['org_num'];
            $result["correct_base"] = $correct_1['correct_num'];
        }
        return $result;
    }
    
    // 获取某个时间段内有抄表基站的最近一条抄表数据
    public function findCorrectDuration($stop_time,$start_time=null){
        if ($start_time) {
            $sql = "time >= ".$start_time." and time < ".$stop_time;
        } else {
            $sql = "time < ".$stop_time;
        }

        return $this->correct->findBy_sql($sql,array("time desc"));
    }

    public function findLastCorrect($station_id){
        $this->db->limit(1);
        return $this->correct->findOneBy_sql(
            array("station_id"=>$station_id),
            array("time desc"));
    }
    
    public function findOneCorrectBefore($station_id,$time){
        $this->db->limit(1);
        $this->correct->where("time < ".$time);
        return $this->correct->findOneBy_sql(
            array("station_id"=>$station_id),
            array("time desc"));
    }

    public function findSecondLastCorrect($station_id){
        $this->db->limit(1,1);
        return $this->correct->findOneBy_sql(
            array("station_id"=>$station_id),
            array("time desc"));
    }


    public function findWrongCorrects(){
        $query = $this->db->query("select * from corrects where slope is not null and ( slope >1.1 or slope < 0.9 )");
        return $query->result_array();
    }
    
    public function insert_new_record($station_id,$correct_num,$org_num,$time) {
        $last = $this->correct->findOneCorrectBefore($station_id,$time);
        if($last) {
            $this->correct->insert(array('type'=>ESC_CORRECT__MAIN_ENERGY,
                'correct_num'=>$correct_num,
                "org_num"=>$org_num,
                "time"=>  $time,
                "station_id"=>$station_id,
                "last_correct_num"=>$last['correct_num'],
                "last_org_num"=>$last['org_num'],
                "last_time"=>$last['time']));
        } else {
            $this->correct->insert(array('type'=>ESC_CORRECT__MAIN_ENERGY,
                'correct_num'=>$correct_num,
                "org_num"=>$org_num,
                "time"=>  $time,
                "station_id"=>$station_id));
        }
    }
    
    //查找某个月有校准的基站且包含上一个校准值
    public function findStationsCorrectdataHash($station_ids,$datetime){
        if(!$station_ids) return array();
        $this->db->where("station_id in (".implode(",",$station_ids).")");
        $this->db->where("last_time is not null");
        $this->db->where("time >= ".h_dt_start_time_of_month($datetime)." and time <=".h_dt_stop_time_of_month($datetime));
        $corrects = $this->findBy();
        $correcthash = array();
        foreach($corrects as $correct){
            $correcthash[$correct['station_id']] = $correct; 
        }
        
        return $correcthash;
    }
    
}

