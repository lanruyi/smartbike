<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mid_station extends ES_Model {

    public function __construct()
    {
        $this->load->model(array('mid/mid_rom','station','bug','user', 'esg','project', 'area', 'rom_update','rom','blog','autocheck','batch','esgconf'));
    }

    public function onestation_detail($station_id) {
        $station = $this->station->find($station_id);
        return $this->station_detail($station);
    }
    
    // 前端只显示部分类型的告警
    public function onestation_detail_customed($station_id) {
        $station = $this->station->find($station_id);
        $station_detail = $this->station_detail($station);
        if ($station_detail['bugs']) {
            $station_detail['bugs'] = h_get_front_display_bugs($station_detail['bugs']);
        }
        
        return $station_detail;
    }

    private function station_detail($station){
        if ($station) {
            $station['esg']      = $this->esg->findOneBy(array('station_id' => $station['id']));
            $station['batch']    = $this->batch->find($station['batch_id']);
            $station['project']  = $this->project->find($station['project_id']);
            $station['city']     = $this->area->find($station['city_id']);
            $station['district'] = $this->area->find($station['district_id']);
            $station['creator']  = $this->user->find($station['creator_id']);
            $station['rom']      = $this->rom->findARom($station['rom_id']);
            $station['bugs']     = $this->bug->findStationOpenBugs($station['id']);
            $station['esgconf']  = $this->esgconf->findOneBy(array("station_id"=>$station['id']));
            $station['current_rom_update'] = $this->mid_rom->getCurrentRomUpdate($station['id']);
            $station['autocheck_report']   = $this->autocheck->getReport($station['id']);
        }
        return $station;
    }

    public function getStationsDetail($stations) {
        $result = array();
        foreach($stations as $station){
            $result[] = $this->station_detail($station);
        }
        return $result;
    }



    public function countContractStations($contract_id){
        $contract = $this->contract->find($contract_id);
        $batches = $this->batch->findBy(array("contract_id"=>$contract_id));
        $this->db->where("batch_id in (".implode(',',h_array_to_id_array($batches)).")");
        $this->db->select("status,building,project_id,city_id,total_load,station_type,batch_id");
        $stations = $this->station->findBy(array("recycle"=>ESC_NORMAL));
        foreach(h_station_building_array() as $building => $name){
            $building_count[$building] = 0;
        }
        foreach(h_station_total_load_array() as $total_load => $name){
            $load_level_count[$total_load] = 0;
        }
        foreach(h_station_station_type_array() as $station_type => $name){
            $station_type_count[$station_type] = 0;
        }
        $cities = $this->area->findProjectCities($contract['project_id']);
        foreach($cities as $city){
            $city_count[$city['id']] = 0;
        }
        foreach($batches as $batch){
            $batch_count[$batch['id']] = 0;
        }
        $counts = array(
            "removed" => 0,
            "normal"  => 0,
            "batch"    => $batch_count,
            "building"    => $building_count,
            "load_level" => $load_level_count,
            "station_type" => $station_type_count,
            "city"    => $city_count
        );
        foreach($stations as $station){
            if($station['status'] == ESC_STATION_STATUS_REMOVE){
                $counts['removed'] ++;
            }else{
                $counts['normal'] ++;
                $counts['building'][$station['building']] ++;
                $counts['city'][$station['city_id']] ++;
                $counts['load_level'][$station['total_load']] ++;
                $counts['station_type'][$station['station_type']] ++;
                $counts['batch'][$station['batch_id']] ++;
            }
        }
        return $counts;
    }


    public function findCreatedProductStations($time){
        $day_time = h_dt_start_time_of_day($time);
        $products = $this->project->findProductProjects();
        $product_ids = h_array_to_id_array($products);
        $this->db->where("project_id in (".implode(",",$product_ids).")");
        $stations = $this->station->findCreatedStations($day_time);
        return $stations;
    }

}
