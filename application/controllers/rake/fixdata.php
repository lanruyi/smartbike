<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// ..\..\..\tests\controllers\rake\FixdataControllerTest.php

class Fixdata_controller extends CI_Controller{

    //private $one_day_datas;
    //private $next_station_ids;
    //private $all_station_ids;
    //private $day_time;

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('data_index','mid/mid_station','fixdata','mid/mid_data','daydata','monthdata','np1stdday','savpair','sav_std','mid/mid_energy','project'));
    }


    public function go_0010(){
        $this->initNp1stdday();
    }

    public function go_0600(){
        //给出每天一天干净的data数据(每天0点)
        $this->fixOneDay(h_dt_start_time_of_day('now'));
        //给出每天能耗数据
        $this->doCalcOneDay();
        //检测每天能耗数据
        $this->judgeOneDaydata();
        if(h_dt_is_first_day_of_month('now')){
            $this->calcOneMonthData("-1 month");
            //广西等地上月节能率计算
            $this->calc_sav_stds("-1 month");
            //初始化本月节能对
            $this->savpair->copy_savpairs("-1 month","now");
            //江苏联通上月的节能率计算
            $this->mid_energy->calcAllPairSaveRate("-1 month");
        }
        $this->calcOneMonthData("now");
        //广西等地当月结能率计算
        $this->calc_sav_stds("now");
        //江苏联通当月的节能率计算
        $this->mid_energy->calcAllPairSaveRate("now");
    }


    function tests($datetime){
        $datetime = h_dt_start_time_of_month($datetime);
        $sav_pairs = $this->savpair->findBy(array('datetime'=>$datetime));
        foreach($sav_pairs as $sav_pair){
            $save_rate = $this->mid_energy->calcSinglePairSaveRate($sav_pair['std_station_id'],$sav_pair['sav_station_id'],$datetime);
                $ss = $this->station->find($sav_pair['std_station_id']);
                echo $ss['city_id']." ".$ss['name_chn']."\n";
                echo $sav_pair['std_station_id']." ".$sav_pair['sav_station_id']." ".$save_rate." ".$sav_pair['save_rate']."\n";
        }
    }

    public function initNp1stdday($time_str = "now"){
        if(!h_dt_is_future_day($time_str) && !$this->np1stdday->isInit($time_str)){ 
            $stations = $this->station->findBy(array("recycle" => ESC_NORMAL,
                "create_time <= " => h_dt_start_time_of_day($time_str), 
                "station_type" => ESC_STATION_TYPE_NPLUSONE));

            $insert_array = array();
            foreach($stations as $station){
                //如果今天是这个站基准日 则插入数据库
                if(h_dt_np1_day_sql(h_dt_start_time_of_day($time_str),$station['ns'],$station['ns_start']) == 0){
                    $insert_array[] = array("station_id"=>$station['id'],
                        "datetime"=>h_dt_start_time_of_day($time_str));
                }
            }
            $this->np1stdday->insert_array($insert_array);
        }
        $this->output->enable_profiler(true);
        $this->load->view('blank'); 
    }

    // xxx需要重构 zcq
    public function calcOneMonthData($time_str="now",$force = false){
        if(h_dt_is_time_future_month($time_str)){ return; }
        if(!$force && $this->monthdata->isCalced($time_str) ){ return; }
        $this->initOneMonthData($time_str);     //每月1号初始化1次

        $calc_type = h_dt_is_time_this_month($time_str)?2:3; //2代表计算的是当月累加的(每天计算),3代表的是当前之前的整月的计算
        $start_time = h_dt_start_time_of_month($time_str);
        $stop_time = h_dt_stop_time_of_month($time_str);
        $days = h_dt_past_days_of_month($start_time);
        $query = $this->db->query("select station_id,count(*) num,sum(main_energy) sum_main_energy,
           sum(dc_energy) sum_dc_energy
            from daydatas 
            where `day`>= ? and `day`< ? and (calc_type=? or calc_type=?) 
            group by station_id",
            array($start_time,$stop_time,ESC_DDCT_NORMAL,ESC_DDCT_TRUE_LOAD));

        $station_daydatas = $query->result_array();
        $monthdatas = $this->monthdata->findBy(array("datetime"=>$start_time));
        $monthdata_hash = h_array_to_hash($monthdatas,"station_id");
        $this->db->query("delete from monthdatas where datetime=?",array($start_time));
        foreach($station_daydatas as $sdd){
            if(isset($monthdata_hash[$sdd['station_id']])){
                $monthdata_hash[$sdd['station_id']]['main_energy'] = null;
                $monthdata_hash[$sdd['station_id']]['dc_energy'] = null;
                if($sdd['num']>($days/2)){
                    $month_main = $sdd['sum_main_energy']*$days/$sdd['num'];
                    $monthdata_hash[$sdd['station_id']]['main_energy'] = $month_main;
                    $month_dc = $sdd['sum_dc_energy']*$days/$sdd['num'];
                    $monthdata_hash[$sdd['station_id']]['dc_energy'] = $month_dc;  
                }
                $monthdata_hash[$sdd['station_id']]['calc_type'] = $calc_type;  
            }
        }
        $this->monthdata->insert_array($monthdata_hash);
    }


    //初始化该月的monthdata
    public function initOneMonthData($time_str = "now"){
        if($this->monthdata->isInit($time_str)){ 
            return; 
        }
        $query = $this->db->query("select id,create_time,station_type from stations 
            where recycle = ? and create_time<=?",
            array(ESC_NORMAL,h_dt_start_time_of_month($time_str))); 
        $res = $query->result_array();
        $insert_array = array();
        foreach($res as $station){
            array_push($insert_array,"(".$station['id'].",".h_dt_start_time_of_month($time_str).")");
        }
        if($insert_array){
            $this->db->query("insert into monthdatas (station_id,datetime) values ".implode(",",$insert_array));
        }
    }


    public function doCalcOneDay($time_str="-1 day",$force = false){
        $time_str = h_dt_start_time_of_day($time_str);
        if($this->daydata->isInit($time_str)){
            //如这一天已经算过
        }else{
            $this->calcOneDay($time_str);
        }
    }

    private function oneDaydataInitHash($time_str){
        $insert_hash = array();
        $query = $this->db->query("select id,create_time,station_type,load_num from stations 
            where recycle = ? and create_time<=?",
            array(ESC_NORMAL,h_dt_start_time_of_day($time_str))); 
        foreach($query->result_array() as $station){
            $insert_hash[$station['id']] = array("station_id"=>$station['id'],
                "day"=>h_dt_start_time_of_day($time_str),
                "calc_type"=>ESC_DDCT_NOCALC,
                "main_energy"=>null,
                "dc_energy"=>null,
                "ac_energy"=>null,
                "true_load_num"=>null,
                "load_num"=>$station['load_num']);
        }
        return $insert_hash;
    }

    private function calcOneDay($time_str){

        $insert_hash = $this->oneDaydataInitHash($time_str);
        $energy_hash = $this->fixdata->getAllOneDayEnergyHash($time_str);
        
        $insert_array = array();
        foreach($insert_hash as $station_id => $insert){
            if(isset($energy_hash[$station_id])){
                $insert = array_merge($insert,$energy_hash[$station_id]);
                //计算公式：负载(A)*53.5v/0.85/1000*24=当天dc用电量(Kwh)  
                // 2014-07-01 按照朱峰的邮件要求，电池转换效率由0.9改为0.85，相应的负载与直流能耗的
                // 关系由1.44变为1.51倍的关系
                $insert['true_load_num'] = $insert['dc_energy']?$insert['dc_energy']/1.51:null;
                if($insert['true_load_num']>250 && $insert['true_load_num']<3){
                    $insert['true_load_num'] = null;
                }
                $insert['calc_type'] = $insert['main_energy']? ESC_DDCT_NORMAL: ESC_DDCT_NOCALC;
            }
            $insert_array[] = $insert;
        }
        $this->daydata->insert_array($insert_array);
    }

    // 2014-07-01 按照朱峰的邮件要求，电池转换效率由0.9改为0.85，相应的负载与直流能耗的
    // 关系由1.44变为1.51倍的关系
    public function judgeOneDaydata($day="-1 day"){
        $day = h_dt_start_time_of_day($day);
        $this->db->query("update daydatas set calc_type = ? 
            where `day`=? and main_energy>0",
            array(ESC_DDCT_NORMAL,$day));
        //判断本日有能耗的daydatas 的能耗是否偏大
        $this->db->query("update daydatas set calc_type = ? 
            where `day`=? and calc_type=? 
            and main_energy>load_num*1.51*4",
            array(ESC_DDCT_WRONG_LARGE,$day, ESC_DDCT_NORMAL));
        //判断本日有能耗的daydatas 的能耗是否偏小
        $this->db->query("update daydatas set calc_type = ? 
            where `day`=? and calc_type=? 
            and main_energy<load_num*1.51*0.75",
            array(ESC_DDCT_WRONG_SMALL,$day, ESC_DDCT_NORMAL));
        //判断能耗异常站点里是否有负载的原因
        $this->db->query("update daydatas set calc_type = ? 
            where (calc_type=? or calc_type=?) 
            and main_energy>true_load_num*1.51*0.75 and main_energy<true_load_num*1.51*4",
                array(ESC_DDCT_TRUE_LOAD,ESC_DDCT_WRONG_LARGE,ESC_DDCT_WRONG_SMALL));
        //判断真实负载里有没有异常的
        $this->db->query("update daydatas set calc_type = ? 
            where calc_type=? and true_load_num<5",
                array(ESC_DDCT_TRUE_LOAD_WRONG,ESC_DDCT_TRUE_LOAD));

    }


    public function calcFromDay($time,$to_time){
        $_t = h_dt_start_time_of_day($time);
        while(!h_dt_compare($_t,$to_time)){
            echo "calc ".$_t." daydata\n";
            $this->calcOneDaydata($_t);
            $_t = h_dt_add_day($_t,1);
        }
    }

    public function fixFromDay($time,$to_time,$refix=false){
        $_t = h_dt_start_time_of_day($time);
        while(!h_dt_compare($_t,$to_time)){
            $_t = h_dt_add_day($_t,1);
        }
    }


    public function calc_sav_stds($time='now'){
        $time = h_dt_start_time_of_month($time);
        $projects = $this->project->findBy(array("type"=>ESC_PROJECT_TYPE_STANDARD_SAVING));
        foreach($projects as $project){
            $this->sav_std->init($time,$project['id']);
        }
        $this->mid_energy->cale_all_month_average_main_energy($time);
    } 


    //////////////////////////////////////////////////////////////////////////////

    public function fixOneDay($time){
        if(h_dt_is_future_day($time)){
            return;
        }
        $day = h_dt_start_time_of_day($time);
        $fixdatas = $this->fixdata->findBy(array("time"=>$day));
        if($fixdatas){
            echo $time." calced\n";
            return;
        }
        $data_tables = $this->data_index->getActiveTableNames(); 
        foreach($data_tables as $data_table){
            $this->data->changeTableName($data_table);
            $datas = $this->makeFixDatasNmins($day,40);
            $this->saveFixdata($day,$datas);
        }
    }

    public function makeFixDatasNmins($day,$mins){
        $_start_time = h_dt_sub_min($day,0);
        $_stop_time  = h_dt_add_min($day,$mins);
        $this->data->select("station_id,energy_main,energy_dc");
        $this->data->group_by("station_id");
        $datas = $this->data->findBy(array(
            "create_time >= " => $_start_time,
            "create_time <= " => $_stop_time,
            "energy_main > "  => 0));
        return $datas;
    }

    public function saveFixdata($day,$one_day_datas){
        $insert_array = array();
        foreach($one_day_datas as $data){
            if(!$data['energy_dc']){
                $data['energy_dc'] = "null";
            }
            $insert_array[] = array(
                "station_id"=>$data['station_id'],
                "energy_main"=>$data['energy_main'],
                "energy_dc"=>$data['energy_dc'],
                "time"=>$day);
        }
        $this->fixdata->insert_array($insert_array);
    }

    //稳定版少一个功能先
    //private function makeFixDatas6hours($day,$rest_station_ids){
        //if(!$rest_station_ids){
            //return;
        //}
        //$_start_time = h_dt_sub_min($day,180);
        //$_stop_time  = h_dt_add_min($day,180);

        //$query = $this->db->query('select station_id,main_energy,dc_energy from datas 
            //where create_time>=? and create_time<=?  
            //and station_id in ('.implode(",",$rest_station_ids).')
            //and energy_main>0
            //group by station_id', 
            //array($_start_time,$this->day_time));
        //$stations = $query->result_array();
        //$before_data_station_ids = h_array_to_array($station,'station_id');
        //$query = $this->db->query('select station_id from datas 
            //where create_time>=? and create_time<=?  
            //and station_id in ('.implode(",",$rest_station_ids).')
            //and energy_main>0
            //group by station_id', 
            //array($this->day_time,$_stop_time));
        //$stations = $query->result_array();
        //$after_data_station_ids = h_array_to_array($station,'station_id');

    //}

    //以后可能有用
    //private function interpolation($data1,$data2,$time){
        //$_t1 = strtotime($data1['create_time']);
        //$_t2 = strtotime($data2['create_time']);
        //$_t = strtotime($time);
        //$_main_inc = ($data2['energy_main'] - $data1['energy_main'])/($_t2-$_t1);
        //$_dc_inc = ($data2['energy_dc'] - $data1['energy_dc'])/($_t2-$_t1);
        //$data['energy_main'] = round($_main_inc *($_t-$_t1),2)+ $data1['energy_main'];
        //$data['energy_main_flag'] = 2;
        //$data['energy_dc']   = round($_dc_inc   *($_t-$_t1),2)+ $data1['energy_dc'];
        //$data['energy_dc_flag'] = 2;
        //return $data;
    //}




}









