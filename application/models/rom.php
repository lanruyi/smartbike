<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/********************************
Fast JJump 
Entities/Rom.php 
..\..\controllers\sysm\rom.php

********************************/
class Rom extends ES_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->table_name = "roms";
    }


    public function paramFormat($_params) {
        $_params['version']   = isset($_params['version'])   ? $_params['version']   : 0;
        $_params['size']      = isset($_params['size'])      ? $_params['size']      : 0;
        $_params['num']       = isset($_params['num'])       ? $_params['num']       : 0;
        $_params['type']      = isset($_params['type'])      ? $_params['type']      : 0;
        $_params['name']      = isset($_params['name'])      ? $_params['name']      : 0;
        $_params['orig_name'] = isset($_params['orig_name']) ? $_params['orig_name'] : 0;
        $_params['comment']   = isset($_params['comment'])   ? $_params['comment']   : "";
        $_params['created']   = isset($_params['created'])   ? $_params['created']   : h_dt_now();
        return $_params;
    }

    public function findARom($rom_id){
        $rom = $this->find($rom_id);
        if($rom){
            $rom['part_num'] = $this->romPartNum($rom['size']);
        }
        return $rom;
    }

    public function findRoms(){
        $roms = $this->findBy(array('recycle'=>ESC_NORMAL),array("id desc"));
        foreach($roms as $key => $rom){
            $roms[$key]['part_num'] = $this->romPartNum($rom['size']);
        }
        return $roms;
    }

    public function romPartNum($size){
        $query = $this->db->query("select * from temps where `key`=?",array('download_size'));
        $download_size = $query->row_array();
        $rom_part_size = $download_size?$download_size['value']:$this->config->item('rom_part_size');
        return ceil($size/$rom_part_size);
    }

    public function resetStationNums(){
        $this->db->query("update roms set station_num = 0");
    }

    public function getRomVersion($rom_id){
        $rom = $this->rom->find($rom_id);
        if($rom){
            return $rom['version'];
        }else{
            return "";
        }
    }

}






