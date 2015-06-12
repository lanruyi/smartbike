<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Rom_controller extends Ajax_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('mid/mid_station','temp','rom','station','command','rom_update'));
    }
    
    //多站点 批量设置modal
    public function mulit(){
        $station_ids = $this->input->post('station_ids');
        $this->dt['station_ids_str'] = implode(",",$station_ids);
        $stations = array();
        foreach ($station_ids as $id) {
            $stations[$id] = $this->station->find($id); 
            //$stations[$id]['rom'] = $this->esgconf->findOneBy(array("station_id"=>$id));
        }
        $this->dt['roms'] = $this->rom->findRoms();
        $this->dt['stations'] = $stations;
        $this->load->view("ajax/rom/mulit",$this->dt);
    }
    
    //ajax 处理多站点设置
    public function mulit_process(){
        $rom = $this->rom->findARom($this->input->post('rom_id'));
        $station_ids = explode(',',$this->input->post('station_ids_str'));
        $err_str = "";
        $num = 0;
        foreach ($station_ids as $station_id) {
            $station = $this->mid_station->onestation_detail($station_id);
            //正在更新的站点
            if($station['current_rom_update']){ continue; }
            //不在更新且rom要对
            if($station['rom_id'] != $rom['id']){
                $_arg_str = "{\"rom_id\":\"".$rom['id']
                    ."\",\"num\":\"".$rom['part_num']
                    ."\",\"size\":\"".$rom['size']
                    ."\",\"name\":\"".$rom['name']
                    ."\",\"packet_size\":\"".$this->temp->getDownloadSize()."\"}";
                $this->command->newUrCommand($station_id,$_arg_str,$this->curr_user['id']);
                $this->rom_update->insert(array(
                    "station_id"=>$station_id,
                    "old_rom_id"=>$station['rom_id'],
                    "new_rom_id"=>$rom['id'],
                    "part_num"=>$rom['part_num']));
                $num ++;
            }else{
                $err_str .= ($station['name_chn']." ");
            }
        }
        $str = '批量固件升级启动成功'.$num.'个！ ';
        if($err_str){
            $str .= ('这几个网站无法升级 '.$err_str);
        }
        echo "[$str]";
        //$this->session->set_flashdata('flash_succ',$str);
    }


}



