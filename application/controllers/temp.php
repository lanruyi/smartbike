<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Temp_controller extends CI_Controller{

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('temp'));
    }

    public function index(){}

    public function set(){
        $this->dt['title'] = '设置部分临时变量';

        $download_size = $this->temp->findOneBy_sql(array('key'=>'download_size'));
        $urtcq = $this->temp->findOneBy_sql(array('key'=>'update_rom_test_chuanqi'));
        $urtcq = isset($urtcq)?json_decode($urtcq['value'],true):null;
        $this->dt['download_size'] = isset($download_size)?$download_size['value']:null;
        $this->dt['rom_1_id']      = isset($urtcq['rom_1_id'])?$urtcq['rom_1_id']:null;
        $this->dt['rom_2_id']      = isset($urtcq['rom_2_id'])?$urtcq['rom_2_id']:null;
        $this->dt['station_ids']   = isset($urtcq['station_ids'])?$urtcq['station_ids']:null;

        $this->load->view('templates/header',$this->dt);
        $this->load->view('temp/set');
    }

    public function update_download_size(){
        $download_size = $this->temp->findOneBy_sql(array('key'=>'download_size'));
        $_params['key'] = 'download_size';
        $_params['value'] = (int)trim($this->input->post('size'));
        if($download_size){
            $this->temp->update_sql($download_size['id'],$_params);
        }else{
            $this->temp->insert($_params);
        }
        redirect('/temp/set','location');
    }

    public function update_urtcq(){
        $urtcq = $this->temp->findOneBy_sql(array('key'=>'update_rom_test_chuanqi'));
        $_params['key'] = 'update_rom_test_chuanqi';
        $_params['value'] = json_encode(array(
            "rom_1_id"=>$this->input->post('rom_1_id'),
            "rom_2_id"=>$this->input->post('rom_2_id'),
            "station_ids"=>$this->input->post('station_ids')
        ));
        if($urtcq ){
            $this->temp->update_sql($urtcq['id'],$_params);
        }else{
            $this->temp->insert($_params);
        }
        redirect('/temp/set','location');
    }
}
