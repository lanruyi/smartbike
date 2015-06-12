<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bug_controller extends CI_Controller{

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('mid/mid_data','mid/mid_energy','esg','property','station','bug','cmail','project','command','daydata','sysconfig'));
    }

    function __destruct() {
    }

    //每10分钟计算bugs
    public function go_bugs_10(){
        //here is part one: detect bugs 
        $all_bugs = $this->mid_data->getBugs();
        foreach($all_bugs as $type => $station_bugs){            
            if($type == ESC_BUG__SMART_METER_BROKEN_2){
                //只开不关(每天关一次)
                $this->bug->openBugs($station_bugs,$type);
            }else{
                $this->bug->openAndCloseBugs($station_bugs,$type);
            }
        }
        $this->bug->openAndCloseBugs($this->station->errorStationsOffline(),ESC_BUG__DISCONNECT);
        $this->bug->closeOverTimeBugs();    //代维按钮等bug统计

        //from here is part two: handle bugs automatic
        //处理485错误
        if($all_bugs[ESC_BUG__485_DIE]){ 
            $force_on_stations = $this->station->findAllForceOnStations();
            $restart_stations = array_diff_key(
                $all_bugs[ESC_BUG__485_DIE],
                h_array_to_id_hash($force_on_stations));
            foreach ($restart_stations as $station_id => $arg){
                $esg_id = $this->esg->getEsgId($station_id);
                $property =  $this->property->findOneBy_sql(array("esg_id"=>$esg_id));
                if ($property && intval($property['rom_version']) < 2012112603
                        && intval($property['rom_version']) > 2000000000)  {
                    $this->command->newREBCommand($station_id);
                }
            }
        }
        //统计断线bug 断线前的室内温度
        $this->setOfflineBugTemp();
    }
    
    public function bugs_temp_high_reboot() {
        $this->mid_data->errorTempHighReboot();
    }


    //每天计算bugs
    public function go_bugs_day(){
        //关闭所有的电表故障2
        $this->bug->closeAll(ESC_BUG__SMART_METER_BROKEN_2);
        //总能耗错误
        $this->mid_energy->analysisMainEnergy();

        //todo dcbug 这个功能暂时不上线
        //$Dc_bugs = $this->analysisDcLoad();
		//$Saving_bugs =$this->analysis_np1_saving_abnormal();
    }


    //分析所有基站的直流负载问题
    public function analysisDcLoad(){

        $this->db->where("station_type=".ESC_STATION_TYPE_STANDARD." or station_type=".ESC_STATION_TYPE_SAVING);
        $stations = $this->station->findNormalStations();

        $bugs = $this->bug->findBy(array("type"=>ESC_BUG__SMART_METER_BROKEN, "status"=>ESC_BUG_STATUS__OPEN));
        $smart_meter_bug_station_ids = h_array_to_array($bugs,"station_id");
        //todo 也许应该把电表故障2也加上

        $bug_stations = array();
        foreach($stations as $station){
            $daydata = $this->daydata->findOneBy(array("station_id"=>$station['id'],"day"=>h_dt_start_time_of_day("-1 day")));
            if($daydata && $station['load_num']){
                $delta = round($daydata['dc_energy']*1000/60/24,2) - $station['load_num'];
                $delta_percent = floor($delta*100/$station['load_num']);
                if($delta_percent >= 10 || $delta_percent <= - 10){
                    if(!in_array($station['id'],$smart_meter_bug_station_ids)){
                        $bug_stations[$station['id']] = $delta_percent;
                    }
                }
            }
        }
        return $bug_stations;
    }
  
  
    public function setOfflineBugTemp(){
        $bugs = $this->bug->findNoTempOfflineBugs();
        foreach($bugs as $bug){
            //todo fb 这个findlast 要改
            $data = $this->mid_data->findLast($bug['station_id']);
            $temp = ($data&&$data['indoor_tmp'])?$data['indoor_tmp']:0;
            $this->bug->update($bug['id'],array("arg"=>$temp));
        }
    }
  








}



