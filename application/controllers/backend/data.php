<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Data_controller extends Backend_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('mid/mid_station','mid/mid_data','data_ext','daydata'));
        $this->load->helper('chart','single','datetime');
    }

    public function index() {
        if ($this->input->get('station_id')) {
            $station_id = $this->input->get('station_id');
            $this->dt['station'] = $this->mid_station->onestation_detail($station_id);
            $this->dt['title'] = $this->dt['station']['name_chn']." 数据列表 ";
        } else {
            show_error("请指定基站ID"); 
        }
        $datetime = $this->input->get("time")?$this->input->get("time"):'now';
        $type     = $this->input->get('type')?$this->input->get('type'):"recent";
        $compress = $this->input->get('compress')?$this->input->get('compress'):"1";

        //最近的数据
        if( $type == "recent"){
            $datas = $this->mid_data->findRecentDatas($station_id);
        //某小时的数据
        }else if( $type == "hour"){
            $datas = $this->mid_data->findHourDatas($station_id,$datetime);
            krsort($datas);
        //某天的数据
        }else if( $type == "day"){
            $datas = $this->mid_data->findDayDatas($station_id,$datetime);
            krsort($datas);
        }
        
        $data_x_time = $this->mid_data->dataXtimeHash($datas,6);
        $this->dt['data_x_time'] = $data_x_time;
        
        if($compress > 1){
            $compressed = array();
            foreach($datas as $key=>$data){
                if($key % $compress == 0){
                    $compressed[] = $data;
                }
            }
            $datas = $compressed;
        }

        $this->dt['type']       = $type;
        $this->dt['datas']      = $datas;
        $this->dt['datetime']   = $datetime;

        $this->load->view('templates/backend_header', $this->dt);
        $this->load->view('backend/menu');
        $this->load->view('backend/data/index');
        $this->load->view('templates/backend_footer');
    }

    public function del_abnormal_data() {
        //这个函数要重写
        redirect('/backend/data/index', 'location');
    }

}

