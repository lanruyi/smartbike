<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Property_controller extends Backend_Controller{

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('mid/mid_station','property','station','command','esg'));
        $this->load->helper(array('property'));
    }

    public function index($cur_page = 1){
        $data['title'] = "属性列表";
    }
    

    public function send_command($station_id){
        $this->command->newGpCommand($station_id);
        redirect('/backend/property/read/'.$station_id, 'location');
    }


     public function read($station_id){
        $this->dt['backurlstr'] = urlencode($this->input->get('backurl'));
        $this->dt['station'] = $this->mid_station->onestation_detail($station_id); 
        $this->dt['title'] = $this->dt['station']['name_chn']." 属性页面 ";

        $this->dt['gp_command'] = $this->command->findActiveGPCommand($station_id);
        $esg_id = $this->esg->getEsgId($station_id);
        $this->dt['property'] = $this->property->findOneBy_sql(array("esg_id"=>$esg_id));

        $this->load->view('templates/backend_header',$this->dt);
        $this->load->view('backend/menu');
        $this->load->view('backend/property/read');
        $this->load->view('templates/backend_footer');
    }

}
