<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mid_rom extends ES_Model {

    public function __construct()
    {
        $this->load->model(array('rom_update','rom','command'));
    }


    public function startRomUpdate($_station_id,$_new_rom_id){
        $station = $this->station->find($_station_id);
        $rom = $this->rom->findARom($_new_rom_id);
        if($rom){
            $_arg_str = "{\"rom_id\":\"".$rom['id']
                ."\",\"num\":\"".$rom['part_num']
                ."\",\"size\":\"".$rom['size']
                ."\",\"name\":\"".$rom['name']
                ."\",\"packet_size\":\"".$this->temp->getDownloadSize()."\"}";
            $this->command->newUrCommand($_station_id,$_arg_str,$this->curr_user['id']);
            $this->rom_update->insert(array(
                "station_id"=>$_station_id,
                "old_rom_id"=>$station['rom_id'],
                "new_rom_id"=>$_new_rom_id,
                "part_num"=>$rom['part_num']));
        }
    }

    public function getCurrentRomUpdate($station_id){
        $rom_update = $this->rom_update->findOneBy_sql(
            array("station_id"=>$station_id,"finish"=>ESC_UR_FINISH__OPEN));
        if($rom_update){
            //$rom_update['old_rom'] = $this->rom->findARom($rom_update['old_rom_id']);
            $rom_update['new_rom'] = $this->rom->findARom($rom_update['new_rom_id']);
            $rom_update['update_percent'] = floor($rom_update['current_part_id']*100/$rom_update['part_num']);
        }
        return $rom_update;
    }

    public function getHistoryRomUpdates($station_id){
        $rom_updates = $this->rom_update->findBy_sql(
            array("station_id"=>$station_id,"finish"=>ESC_UR_FINISH__CLOSED),array('id desc'));
        foreach($rom_updates as $key=>$rom_update){
            $rom_updates[$key]['old_rom'] = $this->rom->findARom($rom_update['old_rom_id']);
            $rom_updates[$key]['new_rom'] = $this->rom->findARom($rom_update['new_rom_id']);
            $rom_updates[$key]['update_percent'] = floor($rom_update['current_part_id']*100/$rom_update['part_num']);
        }
        return $rom_updates;
    }


    public function updateStationRomIdbyEsgAndVersion($esg_id,$v){
        $esg = $this->esg->find_sql($esg_id);
        $rom = $this->rom->findOneBy_sql(array('version'=>$v));
        if($esg && $rom){
            $this->station->update_sql($esg['station_id'],array('rom_id'=>$rom['id']));
        }
    }

    public function isNewRomOk($station_id){
        $station = $this->station->find_sql($station_id);
        $rom_update = $this->rom_update->findOneBy_sql(array(
            "station_id"=>$station_id,
            "finish"=>ESC_UR_FINISH__OPEN,
            "new_rom_id"=>$station['rom_id']));
        return $rom_update?true:false;
    }

}
