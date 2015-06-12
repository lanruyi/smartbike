<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class SavPair extends ES_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->table_name = "savpairs";
        $this->load->model(array('station'));
    }

    public function initSavpairandSavpairdatas($conditions, $post_savpairs, $saving_funcs) {
        $this->insertSavpairs($conditions, $post_savpairs);
        $savpairs = $this->savpair->findBy_sql($conditions);
        if($saving_funcs){
            $this->savpairdata->initSavPairDatas($conditions["datetime"], $saving_funcs);    
        }
    }
    
    public function insertSavpairs($conditions, $post_savpairs) {
        
        $_savpairs = array();
        foreach ($post_savpairs as $load_level => $pairs) {
            foreach ($pairs as $pos => $pair) {
                if ($pair[ESC_STATION_TYPE_STANDARD] && $pair[ESC_STATION_TYPE_SAVING]) {
                    $data = array();
                    $data['project_id'] = $conditions['project_id'];
                    $data['city_id'] = $conditions['city_id'];
                    $data['datetime'] = $conditions['datetime'];
                    $data['total_load'] = $load_level;
                    $data['building_type'] = $conditions['building_type'];
                    $data['sav_station_id'] = $pair[ESC_STATION_TYPE_SAVING];
                    $data['std_station_id'] = $pair[ESC_STATION_TYPE_STANDARD];
                    $_savpairs[$pair[ESC_STATION_TYPE_SAVING] . "-" . $pair[ESC_STATION_TYPE_STANDARD]] = $data;
                }
            }
        }
        if($_savpairs){
            $this->insert_array($_savpairs);
        }
    }

    public function paramFormat($_params) {
        $_params['datetime']       = isset($_params['datetime'])       ? $_params['datetime']       : 0;
        $_params['project_id']     = isset($_params['project_id'])     ? $_params['project_id']     : 0;
        $_params['city_id']        = isset($_params['city_id'])        ? $_params['city_id']        : 0;
        $_params['building_type']  = isset($_params['building_type'])  ? $_params['building_type']  : 0;
        $_params['total_load']     = isset($_params['total_load'])     ? $_params['total_load']     : 0;
        $_params['sav_station_id'] = isset($_params['sav_station_id']) ? $_params['sav_station_id'] : 0;
        $_params['std_station_id'] = isset($_params['std_station_id']) ? $_params['std_station_id'] : 0;
        $_params['save_rate']      = isset($_params['save_rate'])      ? $_params['save_rate']      : 0;
        return $_params;
    }

    public function insert_array($params_array) {
        $_insert_array = array();
        foreach ($params_array as $params) {
            array_push($_insert_array, $this->paramFormat($params));
        }
        $this->db->insert_batch('savpairs', $_insert_array);
    }

    public function delSomeSavpairsandSavpairdatas($param) {
        $old_pairs = $this->findBy_sql($param);
        $this->delBy($param);
        //清空savpairdatas的相关数据
        foreach ($old_pairs as $old_pair) {
            $this->savpairdata->delSomeSavpairdatas($old_pair['id'], $old_pair['datetime']);
        }
    }

    public function getSavPairsbyTime($time) {
        return $sav_pairs = $this->findBy_sql(array("datetime" => $time));
    }
    
    public function getSavPairs($conditions){
        return $sav_pairs = $this->findBy_sql($conditions);
    }

    public function getSavStationCspt($savpair_id,$time,$time_type){
        $savpairdata = $this->savpairdata->findOneBy_sql(array("savpair_id"=>$savpair_id,"datetime"=>$time,"time_type"=>$time_type));
        return $savpairdata['sav_station_cspt'];
    }
        
    public function getStdStationCspt($savpair_id,$time,$time_type){
        $savpairdata = $this->savpairdata->findOneBy_sql(array("savpair_id"=>$savpair_id,"datetime"=>$time,"time_type"=>$time_type));
        return $savpairdata['std_station_cspt'];
    }
    
    public function getSavPairRate($savpair_id,$time,$time_type,$saving_func){
        $savpairdata = $this->savpairdata->findOneBy_sql(array("savpair_id"=>$savpair_id,"datetime"=>$time,"time_type"=>$time_type,"saving_func"=>$saving_func));
        return $savpairdata['rate'];
       }
       
    public function getDisplaySavPairs($conditions, $nums = 4) {
        $_con = $conditions;
        foreach (h_station_total_load_array() as $total_load => $total_load_chn) {
            $_con['total_load'] = $total_load;
            $pairs_info = $this->savpair->findBy_sql($_con);
            
            //基站对数补齐    
            $pairs_format[$total_load] = array();
            $count = 0;
            foreach ($pairs_info as $pair) {
                $pairs_format[$total_load][$count] = $pair;
                $count++;
            }
            if(4==$count){
                continue;
            }
            foreach (range($count, $nums - 1) as $value) {
                $pairs_format[$total_load][$value] = array("sav_station_id" => "0", "std_station_id" => "0","std_cspt_adjust"=>"0.00");
            }
        }
        
        return $pairs_format;
    }

    function stationSelectArray($conditions) {

        $stations = $this->station->findBy_sql(array("project_id" => $conditions['project_id'],
            "city_id" => $conditions['city_id'], "building" => $conditions['building_type'],
            "recycle" => ESC_NORMAL,"create_time <"=>$conditions['datetime']));

        $total_loads_stations = $this->station->group_by_total_load($stations);
        foreach ($total_loads_stations as $total_load => $stations) {
            $total_loads_stations[$total_load][ESC_STATION_TYPE_STANDARD] = array();
            $total_loads_stations[$total_load][ESC_STATION_TYPE_SAVING] = array();
            foreach ($stations as $station) {
                $total_loads_stations[$total_load][$station['station_type']][] = $station;
            }
        }
        return $total_loads_stations;
    }

    public function getSavPairAvgData($savpairinfo,$datetime,$time_type,$saving_func){
        $query = $this->db->query("select avg(sav_station_cspt) as sav_station_cspt,avg(std_station_cspt) as std_station_cspt,avg(rate) as rate
                            from savpairs left join savpairdatas 
                            on savpairs.id=savpairdatas.savpair_id
                            where project_id=? and city_id=? and building_type=? and 
                                  total_load=? and savpairdatas.datetime=? and 
                                  time_type=? and saving_func=?",
                            array($savpairinfo['project_id'],$savpairinfo['city_id'],
                                $savpairinfo['building_type'],$savpairinfo['total_load'],
                                $datetime,$time_type,$saving_func));
       $avg_info = $query->row_array();
       return $avg_info;
    }

    //获取单个平均节能率
    function getOneAverageSavingRate($project_id,$city_id,$building,$datetime,$load_level){
        $savpairs_info = $this->savpair->getSavpairsInfo($project_id,$datetime);
        if(isset($savpairs_info[$city_id][$building][$load_level])){
            return  $savpairs_info[$city_id][$building][$load_level]['save_rate'];
        }else{
            return 0;
        }
    }


    //获取某项目某城市某月某种建筑类型的所有数据
    function getAverageSavingRate($project_id,$city_id,$building,$datetime){
        $savpairs_info = $this->savpair->getSavpairsInfo($project_id,$datetime);
        $hash = array();
        if(isset($savpairs_info[$city_id][$building])){
            $result = $savpairs_info[$city_id][$building];
        }
        foreach(h_station_total_load_array() as $total_load => $name){
            if(isset($result[$total_load]['save_rate'])){
                $hash[$total_load] = $result[$total_load]['save_rate'];
            }else{
                $hash[$total_load] = 0;
            }
        }
        return $hash;
    }

    //取得某项目某月的所有用于对比的基准标杆站 对数和平均节能率
    function getSavpairsInfo($project_id,$datetime){
        $query = $this->db->query("select * from savpairs 
            where project_id=? and datetime=?",
            array($project_id,$datetime));
        $savpair_hash = array();
        foreach($query->result_array() as $savpair){
            $savpair_hash[$savpair['city_id']][$savpair['building_type']][$savpair['total_load']][] = $savpair;
        }
        $result = array();
        foreach($savpair_hash as $city_id => $city_savpairs){
            foreach($city_savpairs as $building => $building_savpairs){
                foreach($building_savpairs as $load_level => $savpairs){
                    $result[$city_id][$building][$load_level]['nums'] = count($savpairs);
                    $result[$city_id][$building][$load_level]['save_rate'] = 
                            $this->average_save_rate($savpairs);
                }
            }
        }
        return $result;
    }

    function average_save_rate($savpairs){
        $total = 0;
        $nums = 0;
        foreach($savpairs as $savpair){
            if($savpair['save_rate'] == 0){
                continue;
            }
            $total += $savpair['save_rate'];
            $nums += 1;
        }
        if($nums){
            $total = $total/$nums;
        }
        return $total;
    }


    function getSavpairsHash($project_id,$city_id,$building,$datetime){
        $savpairs = $this->findBy_sql(array(
            "project_id"=>$project_id,
            "city_id"=>$city_id,
            "building_type"=>$building,
            "datetime"=>$datetime
        ));
        $result = array();
        foreach($savpairs as $savpair){
            $result[$savpair['total_load']][]=$savpair;
        }
        return $result;
    }

    function delSavpairs($project_id,$city_id,$building,$datetime){
        $this->db->query("delete from savpairs where project_id=? and city_id =? and building_type=? and datetime=?",
            array($project_id,$city_id,$building,$datetime));
    }


    //将一个月的节能对拷贝的另一个月
    //节能率不要拷贝
    function copy_savpairs($from,$to){
        $from = h_dt_start_time_of_month($from);
        $to   = h_dt_start_time_of_month($to);
        $to_pairs   = $this->savpair->findBy(array("datetime"=>$to));
        //判断被拷贝的月份是否已经有数据
        if(!$to_pairs){
            $this->db->select("project_id,city_id,building_type,total_load,sav_station_id,std_station_id");
            $from_pairs = $this->savpair->findBy(array("datetime"=>$from));
            $to_pairs = $from_pairs;
            if($to_pairs){
                foreach($to_pairs as $key=>$to_pair){
                    $to_pairs[$key]['datetime'] = $to;
                }
                $this->savpair->insert_array($to_pairs);
            }
        }
    }
}

