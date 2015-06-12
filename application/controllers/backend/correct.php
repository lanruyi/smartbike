<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Correct_controller extends Backend_Controller{

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('mid/mid_station','correct','station','mid/mid_data'));
        $this->load->helper();
    }

    public function index(){
        $station_id = $this->input->get('station_id');
        $station = $this->station->find_sql($station_id);
        $this->dt['title'] = $station["name_chn"]." 总电表同步 ";
        $station or show_error("no station!");
        $this->dt['station'] = $this->mid_station->onestation_detail($station_id);
        $this->dt['corrects'] = $this->correct->findBy_sql(
            array("station_id"=>$station['id']),array("time desc"));
        $this->load->view('templates/backend_header', $this->dt);
        $this->load->view('backend/menu');
        $this->load->view('backend/correct/index');
        $this->load->view('templates/backend_footer');
    }

    public function del_correct($station_id,$correct_id){
        $this->correct->del_sql($correct_id);
        $this->correct->calc_last_correct($station_id);
        redirect($this->input->get('backurl'), 'location');
    } 

    public function add_correct($station_id){
        $_data = $this->mid_data->findRecentLast($station_id);
        if($_data){
            $this->correct->insert(array('type'=>ESC_CORRECT__MAIN_ENERGY,
                'correct_num'=>$this->input->post('correct_num'),
                "org_num"=>$_data['energy_main'],
                "time"=>$_data['create_time'],
                "station_id"=>$station_id));
            //计算这次同步电表后的同步参数
            $this->correct->calc_last_correct($station_id);
        }else{
            $this->session->set_flashdata('flash_error', "站点当前无数据,无法同步电表");
        }
        redirect($this->input->get('backurl'), 'location');
    }

    //////////// private ///////////////



    //function add_main_energy_correct($station_id){
            //$this->correct->new_sql(array('type'=>ESC_CORRECT__MAIN_ENERGY,
                //'correct_num'=>$this->input->post('correct_num'),
                //"org_num"=>$this->input->post('org_num'),
                //"time"=>$this->input->post('time'),
                //"station_id"=>$station_id));
        //redirect('/backend/correct/index/'.$station_id, 'location');
    //}

    

}





