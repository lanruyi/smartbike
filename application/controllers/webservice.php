<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Webservice_controller extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('mid/mid_rom','mid/mid_data','bug','esg', 'eslog', 
            'station','property','command','esg_command','autocheck', 
            'weather', 'data', 'agingdata', 'restart', 'rom','esgconf','temp'));
        if($this->input->get('debug')=='cx'){
            $this->output->enable_profiler(true);
        }
    }

    //类似linux /dev/null 黑洞
    public function null(){
        echo "";
    }

    public function index() {
    }

    //ESG校对时间接口 同时记录下重启情况
    function get_time() {
        echo "{\"time\":" . strtotime('now') . "}";
        $esg_id = $this->input->post('s');
        $this->restart->recordRestart($esg_id);
    }

    //测试gprs模块是否能连上服务器的接口 连上后数据存在eslog里
    public function testgprs() {
        $this->eslog->addtestgprs($this->input->get('id'));
        echo $this->input->get('id') . " airborne!";
    }


    ////////////////////
    //  核心接口函数  //
    ////////////////////
    public function senddatav4() {
        if ($_SERVER['REQUEST_METHOD'] != "POST") {
            log_message('error', "method is:" . $_SERVER['REQUEST_METHOD']);
            return;
        } 
        $esg_id = $this->input->post('s');
        //分配esgid
        if(!$esg_id){
            echo $this->createNewEsg($this->input->post('info'));
            return;
        }

        $esg = $this->esg->check_and_refresh_esg($esg_id);
        if(!$esg){
            log_message('error', 'no that esg: ' . $esg_id );
            return;
        }

        $station = $this->station->check_and_refresh_station($esg['station_id']);
        //没有挂载在基站的esg,将数据插入老化系统
        if (!$station) {
            $this->getEsgDatas($esg_id,$this->input->post('d'),$this->input->post('v'));
            $this->getEsgFinishes($this->input->post('f'));
            echo $this->esg_command->getCommandJsonOfStation($esg_id);
            return;
        }
        $station_id = $station['id'];
        $this->getDatas($station_id,$this->input->post('d'),$this->input->post('v'));
        $this->getWarnings($station_id,$this->input->post('w'));
        $this->getCloseWarnings($station_id,$this->input->post('cw'));
        $this->getSettingsOld($station_id,$esg_id,$this->input->post('t'));
        $this->getSettings($station_id,$this->input->post('st'));
        $this->getProperties($station_id,$esg_id,$this->input->post('p'));
        $this->getFinishes($this->input->post('f'));

        //复用此接口 给出命令
        echo $this->command->getCommandJsonOfStation($station_id);
    }

    
    //有单元    
    public function createNewEsg($info_json){
        if ($info_json) {
            //如果有info信息 进行id分配任务 
            $_info = json_decode($info_json);
            if($_info){
                if (!property_exists($_info, 'name') or !property_exists($_info, 'key')) {
                    return "{error:no name or no key}";
                }
                $esg_id = $this->esg->get_esg_by_esg_key($_info->name, $_info->key);
                return "{\"station_id\":" . $esg_id. "}";
            }
        }
    }
    
    // 老化中，esg命令返回ACK，更新数据库
    public function getEsgFinishes($finishs_json) {
         if ($finishs_json) {
            $_data = json_decode($finishs_json);
            if (!$_data) {
                log_message('error', 'json command finish error:' . $finishs_json);
                return; 
            }
            
            foreach ($_data as $_command_id => $_return) {
                $this->esg_command->finishCommandById($_command_id);
            }
        }
    }

    //有单元    
    public function getFinishes($finishs_json){
        if ($finishs_json) {
            $_data = json_decode($finishs_json);
            if (!$_data) {
                log_message('error', 'json command finish error:' . $finishs_json);
                return; 
            }
            foreach ($_data as $_command_id => $_return) {
                $this->command->finishCommandById($_command_id);
                $command = $this->command->find($_command_id);
                if($command && $command['command'] == "urc"){
                    $this->rom_update->changeRomUpdateStatus(
                        $command['station_id'],ESC_UR_STATUS__COMFIRMED);
                }
            }
        }
    }

    //有单元    
    public function getSettings($station_id,$settings_json){
        if ($settings_json) {
            if($this->esgconf->setJsonEsgConf_v2($station_id,$settings_json)){
                $this->command->finishGSCommand($station_id);
            }
        }
    }

    //有单元    
    public function getSettingsOld($station_id,$esg_id,$settings_json){
        if ($settings_json) {
            $esgconf = $this->esgconf->setJsonEsgConf($station_id,$settings_json);
            if(isset($esgconf['rom_version']) && $esgconf['rom_version']){
                $this->command->finishGSCommand($station_id);
                $this->property->updatePropertyByJson($esg_id,'{"p01":'.$esgconf['rom_version'].'}');
                $this->mid_rom->updateStationRomIdbyEsgAndVersion($esg_id,$esgconf['rom_version']);
                //如果在升级中且收到的romid和要升级的romid一致 
                if($this->mid_rom->isNewRomOk($station_id)){
                    $this->command->newUrcCommand($station_id);
                    $this->rom_update->changeRomUpdateStatus($station_id,ESC_UR_STATUS__URCSENT);
                }
            }
        }
    }

    //有单元    
    public function getProperties($station_id,$esg_id,$propreties_json){
        if ($propreties_json){
            $propreties = $this->property->updatePropertyByJson($esg_id,$propreties_json);
            if($propreties){
                $this->command->finishGpCommand($station_id);
                if(isset($propreties['rom_version'])){
                    $this->mid_rom->updateStationRomIdbyEsgAndVersion($esg_id,$propreties['rom_version']);
                    //如果在升级中且收到的romid和要升级的romid一致 
                    if($this->mid_rom->isNewRomOk($station_id)){
                        $this->command->newUrcCommand($station_id);
                        $this->rom_update->changeRomUpdateStatus($station_id,ESC_UR_STATUS__URCSENT);
                    }
                }
            }//end if($propreties)
        }
    }

    public function getWarnings($station_id,$warnings_json){
        if ($warnings_json) {
            $this->bug->updateBugsByJson($station_id,$warnings_json);
        }
    }

    public function getCloseWarnings($station_id,$warnings_json){
        if ($warnings_json) {
            $this->bug->closeBugsByJson($station_id,$warnings_json);
            //如果有关闭20的话 要进行自检的过程
            if($this->bug->hasCloseWarning($warnings_json,20)){
                $report = $this->mid_data->autocheck($station_id);
                $this->autocheck->add($station_id,$report);
            }
        }
    }

    //有测试
    public function getDatas($station_id,$datas_json,$version=null){
        if ($datas_json) {
            if($this->mid_data->changeTable($station_id,'now')){
                $this->data->insertJsonData_new($station_id,$datas_json,$version);
            }
        }
    }

    //有单元    
    public function getEsgDatas($esg_id,$datas_json,$version=null){
        if ($datas_json) {
            if(3 == $version){
                $this->agingdata->insertJsonData_v3($esg_id,$datas_json);
            }else if(2 == $version){
                $this->agingdata->insertJsonData_v2($esg_id,$datas_json);
            }else{
                $this->agingdata->insertJsonData($esg_id,$datas_json);
            }            
        }
    }


    public function rom_parts($rom_id = null, $part_id = null) {
        $esg = $this->esg->check_and_refresh_esg($this->input->get('s_id'));//这个函数看情况重构
        if($esg){ 
            $rom_update = $this->mid_rom->getCurrentRomUpdate($esg['station_id']);
            if ($rom_update && $rom_update['new_rom']){
                $this->rom_update->changeRomCurrentPartId($esg['station_id'],$part_id);
                $pay_load = $this->file_part("./static/uploads/roms/", 
                        $rom_update['new_rom']['name'], $part_id);
                $pay_load = $this->add_fp_pay_load($part_id, $pay_load);
                if ($this->input->get('debug')) { echo $pay_load; exit(); }
                header('HTTP/1.1 200 OK');
                header('Content-Type: application/octet-stream');
                header('Content-Transfer-Encoding: binary');
                header('Connection:Keep-Alive');
                ob_clean();
                flush();
                echo $pay_load;
                exit();
            }else{
                echo "no new rom!";
                //todo 应该报个错 方便后期排查
            }
        }else{
            echo "no esg!";
        }
    }

    //给内容前面加两字节id，尾部加两字节校验
    private function add_fp_pay_load($id, $pay_load) {
        $len = strlen($pay_load);
        $crc = 0;
        for ($i = 0; $i < $len; $i++) {
            $crc += ord($pay_load[$i]);
        }
        $crc = $crc % 65536;
        $head1 = chr(floor($id / 256));
        $head2 = chr($id % 256);
        //$head1 = chr(floor($len/256));
        //$head2 = chr($len%256);
        $tail1 = chr(floor($crc / 256));
        $tail2 = chr($crc % 256);
        return $head1 . $head2 . $pay_load . $tail1 . $tail2;
    }

    //取出文件对应部分内容
    private function file_part($file_path, $file_name, $part_id) {
        $i = 0;                               //分割的块编号
        $download_size = $this->temp->findOneBy_sql(array('key'=>'download_size'));
        $rom_part_size = $download_size?$download_size['value']:$this->config->item('rom_part_size');
        $fp = fopen($file_path . $file_name, "rb");     //要分割的文件
        while (!feof($fp)) {
            if ($i == $part_id) {
                $res = fread($fp, $rom_part_size);
                fclose($fp);
                return $res;
            }
            $_null = fread($fp, $rom_part_size);
            $i++;
        }
    }


}

