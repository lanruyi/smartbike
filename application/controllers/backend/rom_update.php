<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Rom_update_controller extends Backend_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('mid/mid_station','mid/mid_rom','rom_update','station','command','temp'));
        $this->load->helper('station','datetime');
    }

    public function index($cur_page = 1) {

    }

    public function rlist($cur_page = 1){
        $this->dt['title'] = "rom更新";

        //$data['creators'] = $this->user->findBy_sql(array('department_id'=>4));
        //$data['cities'] = $this->area->findBy_sql(array());
        //$data['projects'] = $this->project->findBy_sql(array());
        //$data['roms'] = $this->rom->findBy_sql(array());
        
        $per_page = $this->input->get('per_page')? $this->input->get('per_page'):8;	

        $conditions = array();
        $conditions['finish ='] = ESC_UR_FINISH__OPEN;
        $orders = array("id"=>"desc");
        $paginator =  $this->rom_update->pagination_sql($conditions,$orders,$per_page,$cur_page);
        $config['base_url'] = '/backend/rom_update/rlist/';
        $config['suffix'] = "?".$_SERVER['QUERY_STRING'];
        $config['first_url'] = $config['base_url'].$config['suffix'];
        $config['total_rows'] = $paginator['num'];
        $config['per_page'] = $per_page; 
        $this->pagination->initialize($config); 
        $this->dt['pagination'] = $this->pagination->create_links();
        $rom_updates =  $paginator['res'];
        foreach($rom_updates as $key=>$rom_update){
            $rom_updates[$key] = $this->mid_rom->getCurrentRomUpdate($rom_update['station_id']);
            $rom_updates[$key]['station'] = $this->station->find($rom_update['station_id']);
        }
        $this->dt['rom_updates'] = $rom_updates;
            
        $this->load->view('templates/backend_header', $this->dt);
        $this->load->view('backend/menu');
        $this->load->view('backend/rom_update/rlist');
        $this->load->view('templates/backend_footer');
    }

    public function single() {
        if ($this->input->get('station_id')) {
            $this->dt['station'] = $this->mid_station->onestation_detail($this->input->get('station_id'));
            $station_id = $this->input->get('station_id');
            $this->dt['title'] = $this->dt['station']['name_chn']." rom更新 ";
        } else {
            show_error("请指定基站ID"); 
        }
        $this->dt['roms'] = $this->rom->findRoms();


        $this->dt['current_rom_update'] = $this->mid_rom->getCurrentRomUpdate($station_id);
        $this->dt['rom_updates'] = $this->mid_rom->getHistoryRomUpdates($station_id);

        $this->load->view('templates/backend_header', $this->dt);
        $this->load->view('backend/menu');
        $this->load->view('backend/rom_update/single');
        $this->load->view('templates/backend_footer');
    }

    public function start_update_rom(){
        $_new_rom_id = $this->input->post('new_rom_id');
        $_station_id = $this->input->post('station_id');

        $station = $this->station->find_sql($_station_id);
        if($station['rom_id'] != $_new_rom_id ){
            $this->mid_rom->startRomUpdate($_station_id,$_new_rom_id);
            $this->session->set_flashdata('flash_succ', "开始更新rom!");
        }else{
            $this->session->set_flashdata('flash_err', "要更新的rom和原来一样!");
        }
        redirect('/backend/rom_update/single?station_id='.$_station_id, 'location');
    }

    public function reset_update_rom(){
        $_station_id = $this->input->get('station_id');
        $this->rom_update->finishRomUpdate($_station_id);
        //todo 考虑各种异常情况下被踢出来的处理善后工作
            //todo 删除多余的命令
            //todo 如果urc最后一步没完成怎么样
        redirect('/backend/rom_update/single?station_id='.$_station_id, 'location');
    }

    public function urcsent_update_rom(){
        $_station_id = $this->input->get('station_id');
        //todo 判断两个rom版本是否一致
        $this->command->newUrcCommand($_station_id,$th2012081731is->curr_user['id']);
        //此处关掉之前的ur (有则关之 无则Pass)
        $this->command->finishCommand($_station_id,'ur');
        $this->rom_update->changeRomUpdateStatus($_station_id,ESC_UR_STATUS__URCSENT);
        redirect('/backend/rom_update/single?station_id='.$_station_id, 'location');
    }

    public function confirm_update_rom(){
        $_station_id = $this->input->get('station_id');
        //确认一下urc命令是否已经结束
        if($this->command->findActiveUrcCommand($_station_id)){
            $this->session->set_flashdata('flash_err', "发下去的urc命令还没有执行");
        }else{
            $this->rom_update->changeRomUpdateStatus($_station_id,ESC_UR_STATUS__COMFIRMED);
        }
        redirect('/backend/rom_update/single?station_id='.$_station_id, 'location');
    }

    ///////////////////// 批量操作 //////////////////////////
    
    
    
    public function batch_update_rom(){
        $this->dt['title'] = "基站批量固件更新";
        $this->dt['backurlstr'] = urlencode($this->input->get('backurlstr'));
        $station_ids = $this->input->post('station_ids');
        if(!$station_ids){
            echo "no station";
            return;
        }
        $this->dt['station_ids_str'] = implode(",",$station_ids);
        $this->dt['roms'] = $this->rom->findRoms();

        $stations = array();
        foreach ($station_ids as $id) {
            $station = $this->mid_station->onestation_detail($id);
            array_push($stations, $station);
        }
        $this->dt['stations'] = $stations;
        
        $this->load->view('templates/backend_header', $this->dt);
        $this->load->view('backend/menu');
        $this->load->view('backend/rom_update/batch_update_rom');
        $this->load->view('templates/backend_footer');       
    }

    public function batch_update_rom_process(){
        $rom = $this->rom->findARom($this->input->post('new_rom_id'));
        $station_ids = explode(",",$this->input->post('station_ids_str'));
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
            $srt .= ('这几个网站无法升级 '.$err_str);
        }
        $this->session->set_flashdata('flash_succ',$str);
         
        redirect(urldecode($this->input->post('backurlstr')), 'location');        
    }


}

