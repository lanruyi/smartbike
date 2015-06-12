<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class hourdata_controller extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('date'));
        $this->load->model(array('daydata', 'station'));
        log_message('error', 'daydata start >>>>');
    }

    function calc_hourdata_now() {
        $hour = h_dt_start_time_of_hour("now");
        $query = $this->db->query("select count(*) as num from hourdatas where time=" . $hour);
        $result = $query->result_array();
        if ($result[0]['num'] > 0) {
            return;
        }
        $this->calc_one_hourdata($hour);
    }

    function calc_one_hourdata($hour) {

        $sql = "select station_id, energy_main, energy_dc from datas where create_time > date_sub(" . $hour . ",interval 65 minute)  and create_time < date_sub(" . $hour . ",interval 60 minute) group by station_id";
        $sql1 = "select station_id,energy_main, energy_dc from datas where create_time > date_sub(" . $hour . ",interval 5 minute)   and create_time < " . $hour . " group by station_id";
        $result = $this->db->query($sql);
        $result1 = $this->db->query($sql1);
        $front_array = $result->result_array();
        $back_array = $result1->result_array();
        $back_hash = array();
        foreach ($back_array as $back) {
            $back_hash[$back['station_id']] = $back;
        }
        $insert_array = array();
        $stations = $this->station->getAllProductStationIds();
        foreach ($front_array as $front) {
            $energy_main = null;
            $energy_dc = null;
            $energy_ac = null;
            //获取对应的小时结束时的数据
            if (isset($back_hash[$front['station_id']])) {
                $back = $back_hash[$front['station_id']];
                if ($back['energy_main'] && $front['energy_main']) {
                    //如果小时前后数据都有 可算出本小时统计数据
                    $energy_main = round($back['energy_main'] - $front['energy_main'], 2);
                    $energy_dc = round($back['energy_dc'] - $front['energy_dc'], 2);
                    //计算本小时的AC能耗
                    $energy_ac = $energy_main - $energy_dc > 0 ? $energy_main - $energy_dc : null;
                }
            }
            array_push($insert_array, array("station_id" => $front['station_id'], "energy_main" => $energy_main, "energy_dc" => $energy_dc, "energy_ac" => $energy_ac, "time" => $hour));
        }
        foreach ($insert_array as $insert) {
            $insert_hash[$insert['station_id']] = $insert;
        }
        $new_array = $insert_hash;
        for ($i = 0; $i < count($stations); $i++) {
            if (!array_key_exists($stations[$i], $insert_hash)) {
                array_push($new_array, array("station_id" => $stations[$i], "energy_main" => null, "energy_dc" => null, "energy_ac" => null, "time" => $hour,));
            }
        }
       foreach ($new_array as $new) {
            $new_hash[$new['station_id']] = $new;
        }

        $sql = "select station_id,count(station_id) from datas where create_time > date_sub(" . $hour . ",interval 65 minute)  and  create_time < date_sub(" . $hour . ",interval 5 minute) group by station_id";
        $result = $this->db->query($sql);
        $packets = $result->result_array();

        foreach ($packets as $packet) {
            if (array_key_exists($packet['station_id'], $new_hash)) {
                array_push($new_hash[$packet['station_id']], $packet['count(station_id)']);
            }
        }    
        foreach ($new_hash as $new) {
            if (count($new) == 6) {
                $new = array(
                    'station_id' => $new['station_id'],
                    'energy_main' => $new['energy_main'],
                    'energy_dc' => $new['energy_dc'],
                    'energy_ac' => $new['energy_ac'],
                    'time' => $new['time'],
                    'packets' => $new['0']
                );
            } else {
                $new = array(
                    'station_id' => $new['station_id'],
                    'energy_main' => $new['energy_main'],
                    'energy_dc' => $new['energy_dc'],
                    'energy_ac' => $new['energy_ac'],
                    'time' => $new['time']
                );
            }
            $this->db->insert('hourdatas', $new);
        }
    }

}