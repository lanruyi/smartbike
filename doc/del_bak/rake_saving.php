<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Saving_controller extends CI_Controller{

    function __construct(){
        parent::__construct();
        $this->load->helper(array('date','url'));
        $this->load->model(array('daydata','monthdata','station','savpair','loadleveldata','saving'));
        log_message('error','daydata start >>>>');        
    }
    


    public function calcInitedDataFrom(){
        $conditions['project_id'] = $this->input->post('project_id');
        $conditions['city_id'] = $this->input->post('city_id');
        $conditions['datetime'] = $this->input->post('datetime');
        $conditions['building_type'] = $this->input->post('building_type');
        
        $this->calcSavPairDataFrom($conditions);
        $this->calcLoadLevelDataFrom($conditions);
        $this->calcSavingDataFrom($conditions);
        
        $this->dt['backurl'] = $this->input->post('backurl');
        $this->load->view("reporting/home/success",  $this->dt);
    }

    public function adjustCalcedDataFrom(){
        $conditions['project_id'] = $this->input->post('project_id');
        $conditions['city_id'] = $this->input->post('city_id');
        $conditions['datetime'] = $this->input->post('datetime');
        $conditions['building_type'] = $this->input->post('building_type');
        
        // $this->adjustSavPairDataFrom($time, $to_time);
        $this->adjustSavingDataFrom($conditions);
        
        $this->dt['backurl'] = $this->input->post('backurl');
        $this->load->view("reporting/home/success",  $this->dt);
    }
    
    public function calcSavPairDataFrom($conditions){
        $time = h_dt_start_time_of_month($conditions['datetime']);
        $to_time = h_dt_stop_time_of_month($conditions['datetime']);
        
        $query = $this->db->query("select * from savpairs left join savpairdatas
            on savpairs.id=savpairdatas.savpair_id 
            where project_id=? and city_id=? and building_type=? and 
            (sav_station_cspt is null or std_station_cspt is null or rate is null or error is not null) and
            savpairdatas.datetime between ? and ?",array($conditions['project_id'],$conditions['city_id'],$conditions['building_type'],$time,$to_time));
        $pairdatas = $query->result_array();
        
        foreach($pairdatas as $pairdata){
            $this->calcSavPairData($pairdata);
        }
    }
    
    public function calcSavPairData($savpairdata){
        $savpair = $this->savpair->find_sql($savpairdata['savpair_id']);
        
        if(ESC_MONTH == $savpairdata['time_type']){
            $sav_daymonthdata = $this->monthdata->findStationMonthdata($savpair["sav_station_id"],$savpairdata['datetime']);
            $std_daymonthdata = $this->monthdata->findStationMonthdata($savpair["std_station_id"],$savpairdata['datetime']);
        }elseif(ESC_DAY == $savpairdata['time_type']){
            $sav_daymonthdata = $this->daydata->findStationDaydata($savpair["sav_station_id"],$savpairdata['datetime']);
            $std_daymonthdata = $this->daydata->findStationDaydata($savpair["std_station_id"],$savpairdata['datetime']);
        }
        $data = array();
        $data['error'] = null;
        $data['rate'] = null;
        $data['sav_station_cspt'] = null;
        $data['std_station_cspt'] = null;
        
        if(ESC_MONTH==$savpairdata['time_type']){
            if($std_daymonthdata){
                $std_daymonthdata['main_energy']+=$savpair['std_cspt_adjust'];
            }
            ($std_daymonthdata)?$data['std_station_cspt'] = $std_daymonthdata['main_energy']:$data['error'] = ESC_ERROR_NO_STD_CSPT_FOUND;
            ($sav_daymonthdata)?$data['sav_station_cspt'] = $sav_daymonthdata['main_energy']:$data['error'] = ESC_ERROR_NO_SAV_CSPT_FOUND;
        }elseif(ESC_DAY == $savpairdata['time_type']){
            ($std_daymonthdata)?$data['std_station_cspt'] = $std_daymonthdata['main_energy']:$data['error'] = ESC_ERROR_NO_STD_CSPT_FOUND;
            ($sav_daymonthdata)?$data['sav_station_cspt'] = $sav_daymonthdata['main_energy']:$data['error'] = ESC_ERROR_NO_SAV_CSPT_FOUND;
        }
        
        if(!$data['error']){
            if(!(float)$sav_daymonthdata['main_energy']||!(float)$std_daymonthdata['main_energy']){
                $data['error'] = ESC_ERROR_STATION_CSPT_FAULT;
            }else{
                if(ESC_SAV_STD_FUN_A==$savpairdata['saving_func']){
                    $rate_res = $this->calcSavRate_a($sav_daymonthdata,$std_daymonthdata);                
                }elseif(ESC_SAV_STD_FUN_B==$savpairdata['saving_func']){
                    $rate_res = $this->calcSavRate_b($sav_daymonthdata,$std_daymonthdata);                
                }else{
                    echo "No saving function set!";
                    return;
               }
                $data['rate'] = $rate_res['rate'];
                $data['error'] = $rate_res['error'];
                
            }
        }    
        $this->savpairdata->update_sql($savpairdata['id'],$data);
    }
    
    public function calcSavRate_a($sav_daymonthdata,$std_daymonthdata){
        $res['rate'] = null;
        $res['error'] = null;
        if (!(int)$sav_daymonthdata['dc_energy']) {
            $res['error'] = ESC_ERROR_NO_SAV_DC_ENERGY_FOUND;
            return $res;
        }
        if (!(int)$std_daymonthdata['dc_energy']) {
            $res['error'] = ESC_ERROR_NO_STD_DC_ENERGY_FOUND;
            return $res;
        }
        $res['rate'] = $this->daydata->contract_energy_saving_rate_v0($std_daymonthdata["main_energy"], 
            $sav_daymonthdata["main_energy"], 
            $std_daymonthdata['dc_energy'], $sav_daymonthdata['dc_energy']);
        return $res;
    }



    public function calcSavRate_b($sav_daymonthdata,$std_daymonthdata){
        $res['rate'] = null;
        $res['error'] = null;
        $sav_station = $this->station->find_sql($sav_daymonthdata['station_id']);
        $std_station = $this->station->find_sql($std_daymonthdata['station_id']);
        if (!$sav_station || !$std_station) { return $res; }
        if (!(int)$sav_station['load_num']) {
            $res['error'] = ESC_ERROR_NO_SAV_LOAD_NUM_FOUND;
            return $res;
        }
        if (!(int)$std_station['load_num']) {
            $res['error'] = ESC_ERROR_NO_STD_LOAD_NUM_FOUND;
            return $res;
        }
        $res['rate'] = $this->daydata->contract_energy_saving_rate_v0($std_daymonthdata["main_energy"], 
            $sav_daymonthdata["main_energy"], 
            $std_station['load_num'], $sav_station['load_num']);
        return $res;
    }
    
     public function calcLoadLevelDataFrom($conditions){
        $time = h_dt_start_time_of_month($conditions['datetime']);
        $to_time = h_dt_stop_time_of_month($conditions['datetime']);
        
         $query = $this->db->query("select * from loadleveldatas  where 
            project_id=? and city_id=? and building_type=? and
            saving_rate is null or error is not null and 
            datetime between ? and ?",array($conditions['project_id'],$conditions['city_id'],$conditions['building_type'],$time,$to_time));
        $loadleveldatas = $query->result_array();
        foreach($loadleveldatas as $loadleveldata){
            $this->calcLoadLevelData($loadleveldata);
        }
    }
    public function calcLoadLevelData($loadleveldata){
        $query = $this->db->query("select avg(rate) as saving_rate,rate,count(*) as num from savpairs left join savpairdatas 
                            on savpairs.id=savpairdatas.savpair_id
                            where project_id=? and city_id=? and building_type=? and savpairdatas.datetime=? and 
                                  time_type=? and total_load=? and saving_func=?",
                            array($loadleveldata['project_id'],$loadleveldata['city_id'],
                                $loadleveldata['building_type'],$loadleveldata['datetime'],
                                $loadleveldata['time_type'],$loadleveldata['total_load'],$loadleveldata['saving_func']));
        $rate_array = $query->row_array();
        if(!$rate_array['rate']){
            $data['error'] = ESC_ERROR_NO_SAVPAIR_RATE_FOUND;
        }
        if($rate_array['num']>count($rate_array['rate'])){
            $data['warning'] = ESC_WARNING_SOME_SAVPAIR_RATE_FAILED;
        }
        $data['saving_rate'] = $rate_array['saving_rate'];
        $this->loadleveldata->update_sql($loadleveldata['id'],$data);
    }
    
    public function calcSavingDataFrom($conditions){
        $time = h_dt_start_time_of_month($conditions['datetime']);
        $to_time = h_dt_stop_time_of_month($conditions['datetime']);
        
        $query = $this->db->query("select * from savings  where
            project_id=? and city_id=? and building_type=? and 
            saving_rate is null or error is not null and
            datetime between ? and ?",array($conditions['project_id'],$conditions['city_id'],$conditions['building_type'],$time,$to_time));
        $savingdatas = $query->result_array();
        foreach($savingdatas as $savingdata){
            if(ESC_SAV_STD_FUN_A==$savingdata['saving_func']||ESC_SAV_STD_FUN_B==$savingdata['saving_func']){
            $this->calcSavingData($savingdata);
            }
        }
    }
    
    public function calcSavingData($savingdata){
        $saving = array();
        $loadleveldata = $this->loadleveldata->findStationLoadLevelData($savingdata['station_id'],$savingdata['datetime'],$savingdata['time_type'],$savingdata['saving_func']);
        if(!$loadleveldata){
            $saving['error'] = ESC_NO_LOADLEVELDATA_FOUND;
        }elseif(!$loadleveldata['saving_rate']){
            $saving['error'] = ESC_NO_SAVING_RATE_FOUND;
        }else{
            $saving['saving_rate'] = $loadleveldata['saving_rate'];
            if(ESC_MONTH == $savingdata['time_type']){
                $saving_daymonthdata = $this->monthdata->findStationMonthdata($savingdata["station_id"],$savingdata['datetime']); 
            }elseif(ESC_DAY == $savingdata['time_type']){
                $saving_daymonthdata = $this->daydata->findStationDaydata($savingdata["station_id"],$savingdata['datetime']);
            }
            if(!$saving_daymonthdata){
                $saving['error'] = ESC_ERROR_NO_CSPT_FOUND;
            }elseif(!$saving_daymonthdata['main_energy']){
                $saving['error'] = ESC_ERROR_NO_CSPT_FOUND;
            }else{
                $saving['energy_save'] = $this->saving->calcEnergySave($saving['saving_rate'],$saving_daymonthdata['main_energy']);
            } 
        }
        $this->saving->update_sql($savingdata['id'],$saving);
    }
//    public function adjustSavPairDataFrom($time,$to_time){
//        $query = $this->db->query("select * from savpairdatas where
//            (error is not null) and
//            datetime between ? and ?",array($time,$to_time));
//        $pairdatas = $query->result_array();
//        if(!$pairdatas){
//            return;
//        }else{
//            foreach($pairdatas as $pairdata){
//                $this->adjustSavPairData($pairdata);
//            }
//        }
//    }
//    
//    public function adjustSavPairData($savpairdata){
//        $savpair_info = $this->savpair->find_sql($savpairdata['savpair_id']);
//        $avg_info = $this->savpair->getSavPairAvgData($savpair_info,$savpairdata['datetime'],
//                $savpairdata['time_type'],$savpairdata['saving_func']);
//        $adjust_data['sav_station_cspt'] = $avg_info['sav_station_cspt'];
//        $adjust_data['std_station_cspt'] = $avg_info['std_station_cspt'];
//        $adjust_data['rate'] = $avg_info['rate'];
//        
//        $this->savpairdata->update_sql($savpairdata['id'],$adjust_data);
//    }
//     
    public function adjustSavingDataFrom($conditions){
        $time = h_dt_start_time_of_month($conditions['datetime']);
        $to_time = h_dt_stop_time_of_month($conditions['datetime']);
        
        $query = $this->db->query("select * from savings
            where project_id=? and city_id=? and building_type=? and
            error is not null and station_type=4 and datetime between ? and ?",
                array($conditions['project_id'],$conditions['city_id'],$conditions['building_type'],$time,$to_time));
        $savingdatas = $query->result_array();
        
        if(!$savingdatas){
            return;
        }else{
            foreach($savingdatas as $savingdata){
                $this->adjustSavingData($savingdata);
            }
        }    
    }

    public function adjustSavingData($savingdata){
        $avg_info = $this->saving->getSavingAvgData($savingdata);
        $adjust_data['energy_save'] = $avg_info['energy_save'];
        
        $this->saving->update_sql($savingdata['id'],$adjust_data);
    }
    
}
