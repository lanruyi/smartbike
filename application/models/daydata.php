<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//ddct = daydata calc_type
define('ESC_DDCT_NOCALC', 1);
define('ESC_DDCT_NORMAL', 3); 

define('ESC_DDCT_TRUE_LOAD', 4);
define('ESC_DDCT_TRUE_LOAD_WRONG', 5);
define('ESC_DDCT_WRONG_LARGE', 21);
define('ESC_DDCT_WRONG_SMALL', 22);


class Daydata extends ES_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->table_name = "daydatas";
        $this->load->helper("daydata");
    }

    //获取基站某些日子的平均能耗，无修正，去除特别小的
    public function getStationsNDaysAverageMain($station_ids,$start_time,$stop_time){
        $start_day = h_dt_start_time_of_day($start_time);
        $stop_day = h_dt_start_time_of_day($stop_time);
        $days = h_dt_diff_day($stop_time,$start_time) + 1;
        $result = array();
        if($station_ids){
            $this->daydata->where("station_id in (".implode(",",$station_ids).")");
            $this->daydata->where("day >= ".$start_day." and day <= ".$stop_day);
            $daydatas = $this->daydata->findBy();
            foreach($station_ids as $station_id){
                $result[$station_id] = array("num"=>0,"total_main"=>0);
            }
            foreach($daydatas as $daydata){
                //如果整体小于5A的站，是断线的或者电压检测线有问题的。 
                if($daydata['main_energy'] > 7){
                    $result[$daydata['station_id']]["num"] += 1;
                    $result[$daydata['station_id']]["total_main"] += $daydata['main_energy'];
                }
            }
            foreach($station_ids as $station_id){
                if($result[$station_id]['num'] > $days/2){
                    $result[$station_id]["main_energy"] = $result[$station_id]["total_main"] / $result[$station_id]['num'];
                }else{
                    $result[$station_id]["main_energy"] = 0;
                }
            }
        }
        return $result;
    }


    public function get_n_day_load_num($n,$station_ids){
        $day = h_dt_start_time_of_day('now');
        $days = array();
        for($i=0;$i<$n;$i++){
            $days[] = h_dt_sub_day($day,$i+1);
        }
        $sql = "select station_id,avg(true_load_num) as avg_true_load_num from daydatas where 
            station_id in (".join(",",$station_ids).") and
            day in (".join(",",$days).") 
            group by station_id";
        $query = $this->db->query($sql);
        $daydatas = $query->result_array();
        $result = array();
        foreach($daydatas as $daydata){
            $result[$daydata['station_id']] = $daydata['avg_true_load_num'];
        }
        return $result;
    }
    


    public function findStandardStationDaydata($station_id,$start_str,$stop_str){
        $t = new DateTime($start_str);
        $stop = new DateTime($stop_str);
        $query = $this->db->query("select * from daydatas where station_id = ? and day>=? and day<=? order by day asc",
            array($station_id,$start_str,$stop_str));
        $daydatas = $query->result_array();
        $count = array("ac_energy"=>0,"std_ac_energy"=>0,"total"=>count($daydatas));
        $sum = array("ac_energy"=>0,"std_ac_energy"=>0,"err"=>"本站为基准站");
        foreach($daydatas as &$daydata){
            $daydata['err'] = ""; 
            $daydata['time'] = $daydata['day']."000000"; 
        }
        $result['days'] = $daydatas;
        $result['total'] = $sum;
        return $result;
    }

    public function  findDayDatasHash($station_id,$start_str,$stop_str){
        $this->db->where("`day` >=".$start_str." and `day` <= ".$stop_str);
        $daydatas = $this->daydata->findBy_sql(array("station_id"=>$station_id),array("day asc"));
        $hash = array();
        foreach($daydatas as  $dd){
            $hash[h_dt_format($dd['day'])] = $dd;
        }
        return $hash;
    } 
    


    public function findByStationAndPeriod($station_id,$start_time,$stop_time){
        $this->db->where(array('day >= '=> h_dt_format($start_time),'day <= '=> h_dt_format($stop_time)));
        return $this->findBy_sql(array("station_id"=>$station_id),array("`day` asc"));
    }


    public function findStationDaydata($station_id, $day) {
        return $this->findOneBy(array('station_id' => $station_id, 'day' => h_dt_start_time_of_day($time)));
    }

    public function getDayMainEnergy($station_id,$day){
        $daydata = $this->findOneBy(array('station_id' => $station_id, 'day' => h_dt_start_time_of_day($day)));
        if($daydata && $daydata['main_energy']){
            return $daydata['main_energy'];
        }
        return null;
    }


    public function isInit($time_str){
        $query = $this->db->query("select count(*) n from daydatas where `day`= ?",array(h_dt_start_time_of_day($time_str)));
        $res = $query->row_array();
        if($res['n']){
            return true;
        }
        return false;
    }
    
    public function isCalced($time_str){
        $query = $this->db->query("select count(*) n from daydatas where main_energy is not null and `day`= ?",array(h_dt_start_time_of_day($time_str)));
        $res = $query->row_array();
        if($res['n']){
            return true;
        }
        return false;
    }

    public function findMonthdaydatas($station_id,$time){
        $start = h_dt_start_time_of_month($time);
        $stop  = h_dt_stop_time_of_month($time);
        $this->db->where(array('day >= '=>$start,'day < '=>$stop));
        return $this->daydata->findBy(array("station_id"=>$station_id),array('day asc'));
    }

    
}





