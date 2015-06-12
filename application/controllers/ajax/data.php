<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Data_controller extends Ajax_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('mid/mid_station','mid/mid_data','data_ext','daydata'));
        $this->load->helper('chart','single','datetime');
    }

    public function single_json($station_id,$datetime="now",$hour="all"){

        if(!$station_id){ return ""; }
        if( $hour == "all"){
            $datas = $this->mid_data->findDayDatas($station_id,$datetime);
        }else{
            $datas = $this->mid_data->findHourDatas($station_id,h_dt_format($datetime,"Ymd".sprintf('%02d',$hour)."0000"));
        }
        echo json_encode($datas);
    }

    public function back_single($station_id,$datetime="now",$hour="all"){
        if(!$station_id){ return ""; }
        if( $hour == "all"){
            $datas = $this->mid_data->findDayDatas($station_id,$datetime);
        }else{
            $datas = $this->mid_data->findHourDatas($station_id,h_dt_format($datetime,"Ymd".sprintf('%02d',$hour)."0000"));
        }
        $this->load->view("ajax/data/back_single",$this->dt);
    }


}



