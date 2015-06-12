<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define('ESC_UR_FINISH__OPEN',1);
define('ESC_UR_FINISH__CLOSED',2);

define('ESC_UR_STATUS__START',1);
define('ESC_UR_STATUS__DOWNING',2);
define('ESC_UR_STATUS__WAITURC',3);
define('ESC_UR_STATUS__URCSENT',4);
define('ESC_UR_STATUS__COMFIRMED',5);

class Rom_update extends ES_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->table_name = "rom_updates";
    }


    public function paramFormat($_params) {
        $_params['station_id'] = isset($_params['station_id']) ? $_params['station_id']  : 0;
        $_params['new_rom_id'] = isset($_params['new_rom_id']) ? $_params['new_rom_id']  : 0;
        $_params['old_rom_id'] = isset($_params['old_rom_id']) ? $_params['old_rom_id']  : 0;
        $_params['part_num']   = isset($_params['part_num'])   ? $_params['part_num']    : 0;
        $_params['start_time'] = isset($_params['start_time']) ? $_params['start_time']  : h_dt_now();
        $_params['down_time']  = isset($_params['down_time'])  ? $_params['down_time']   : null;
        $_params['stop_time']  = isset($_params['stop_time'])  ? $_params['stop_time']   : null;
        $_params['status']     = isset($_params['status'])     ? $_params['status']      : ESC_UR_STATUS__START;
        $_params['finish']     = isset($_params['finish'])     ? $_params['finish']      : ESC_UR_FINISH__OPEN;
        $_params['current_part_id'] = isset($_params['current_part_id']) ? $_params['current_part_id'] : 0;
        return $_params;
    }


    public function isFinishedRomUpdate($station_id){
        $ur = $this->rom_update->findOneBy(array("station_id"=>$station_id,"finish" => ESC_UR_FINISH__OPEN));
        return $ur?false:true;
    }

    public function finishRomUpdate($station_id){
        $ur = $this->findOneBy_sql(array("station_id"=>$station_id,"finish" => ESC_UR_FINISH__OPEN));
        if($ur){
            $this->update_sql($ur['id'], array("finish" => ESC_UR_FINISH__CLOSED,"stop_time"=>h_dt_now()));
        }
    }

    public function changeRomCurrentPartId($station_id,$part_id){
        $ur = $this->findOneBy_sql(array("station_id"=>$station_id,"finish"=>ESC_UR_FINISH__OPEN));
        if($ur){
            if($ur['part_num'] <= ($part_id+1)){
                $this->update_sql($ur['id'], 
                    array("status" => ESC_UR_STATUS__WAITURC,
                    "current_part_id"=>$part_id+1,
                    "down_time"=>h_dt_now()));
            }else{
                $this->update_sql($ur['id'], 
                    array("status" => ESC_UR_STATUS__DOWNING,"current_part_id"=>$part_id+1));
            }
        }
    }

    public function changeRomUpdateStatus($station_id,$status){
        $ur = $this->findOneBy_sql(array("station_id"=>$station_id,"finish"=>ESC_UR_FINISH__OPEN));
        if($ur){
            if($status == ESC_UR_STATUS__COMFIRMED){
                $this->update_sql($ur['id'], 
                    array("status" => $status,
                    "finish"=>ESC_UR_FINISH__CLOSED,
                    "stop_time"=>h_dt_now()));
            }else{
                $this->update_sql($ur['id'], array("status" => $status));
            }
        }
        
    }

    
}
