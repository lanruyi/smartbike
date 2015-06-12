<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rom_controller extends Backend_Controller{

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('rom'));
    }

    function test_rom(){
        echo $rom->Num();
    }

    public function index(){
        $this->dt['title'] = "rom";
        $this->dt['roms'] = $this->rom->findBy_sql(array(),array("recycle,id desc"));
        $this->load->view('templates/backend_header', $this->dt);
        $this->load->view('backend/menu');
        $this->load->view('backend/rom/index');
        $this->load->view('templates/backend_footer');
    }


    public function add_rom(){
        $this->dt['title'] = "添加固件";
        $this->dt['mod'] = false;
        $this->load->view('templates/backend_header', $this->dt);
        $this->load->view('backend/menu');
        $this->load->view('backend/rom/add_rom');
        $this->load->view('templates/backend_footer');
    }

    public function mod_rom($rom_id){
        $this->dt['title'] = "修改固件";
        $this->dt['mod'] = true;
        $this->dt['rom'] = $this->rom->find_sql($rom_id);
        $this->load->view('templates/backend_header', $this->dt);
        $this->load->view('backend/menu');
        $this->load->view('backend/rom/add_rom');
        $this->load->view('templates/backend_footer');
    }


    private function divide_file($file_path,$file_name,$divide_path,$rom_id){
        $i    = 0;                               //分割的块编号
        $fp   = fopen($file_path.$file_name,"rb");     //要分割的文件
        while(!feof($fp))
        {
            fread($fp,300);
            $handle = fopen($divide_path.$rom_id."_".$i,"wb");
            fwrite($handle,fread($fp,300));            //可以自定义.就是每个所分割的文件大小
            fclose($handle);
            unset($handle);
            $i++;
        }
        fclose ($fp);
        return $i;
    }

    public function split_rom($rom_id){
        $rom = $this->rom->find_sql($rom_id);
        $this->divide_file("./static/uploads/roms/",$rom['name'],'./static/d/',$rom['id']); 
    }

    public function insert_rom(){
        $_path = './static/uploads/roms/';
        $_inside_name = 'new_kits.scode';
        $_tar_name = 'kits_v'.$this->input->post('version').'.tar.gz';
        $config['upload_path'] = $_path;
        $config['allowed_types'] = '*';
        $config['max_size'] = '1024';
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload()){
            $error = array('error' => $this->upload->display_errors());
            return $error["error"];
        }else{
            $_d = $this->upload->data();
            rename($_path.$_d['orig_name'],$_path.$_tar_name);
            $this->rom->insert(array(
                "name"     => $_tar_name,
                "orig_name" => $_d['orig_name'],
                "size"     => filesize($_path.$_tar_name),
                "version"  => $this->input->post('version'),
                "type"     => $this->input->post('type'),
                "comment"  => $this->input->post('comment')
            ));
        }
        redirect('/backend/rom', 'location');
    }

    public function update_rom(){
        $rom_id =  $this->input->post('id');
        $this->rom->update_sql($rom_id,array(
            "comment"=>$this->input->post('comment')));
        redirect('/backend/rom', 'location');
    }

    public function del_rom($rom_id){
        $this->rom->update_sql($rom_id,array("recycle"=>ESC_DEL));
        $this->session->set_flashdata('flash_succ', '删除完成');
        redirect('/backend/rom', 'location');
    }

    public function recal_rom(){
        $query = $this->db->query("select rom_id,count(id) sum from stations where recycle=? group by rom_id",array(ESC_NORMAL));
        $roms = $query->result_array();
        $this->rom->resetStationNums();
        foreach($roms as $rom){
            if($rom['rom_id']){
                $this->rom->update_sql($rom['rom_id'],array('station_num'=>$rom['sum']));
            }
        }
        $this->session->set_flashdata('flash_succ', '统计完成!');
        redirect('/backend/rom','location');
    }

}





