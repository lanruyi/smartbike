<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Esgconf_controller extends Ajax_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('esgconf','station','command'));
    }
    
    //多站点 批量设置modal
    public function mulit(){
        $station_ids = $this->input->post('station_ids');
        $this->dt['station_ids_str'] = implode(",",$station_ids);
        $stations = array();
        foreach ($station_ids as $id) {
            $stations[$id] = $this->station->find($id); 
            $stations[$id]['esgconf'] = $this->esgconf->findOneBy(array("station_id"=>$id));
        }
        $this->dt['stations'] = $stations;
        $this->load->view("ajax/esgconf/mulit",$this->dt);
    }
    
    //ajax 处理多站点设置
    public function mulit_process(){
        $post_array = $this->input->post();
        $arg_str = $this->esgconf->getECString($post_array);

        $station_ids = explode(',',$this->input->post('station_ids_str'));
        $commands = array();
        foreach($station_ids as $station_id){  
            $command_id = $this->command->newStCommand($station_id,$arg_str,$this->curr_user['id']);
            $commands[$station_id] = $command_id;
        }
        echo "[".count($commands)."]";
    }


}



