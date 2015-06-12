<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Esg_command extends ES_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->table_name = "esg_commands";
        $this->load->helper(array('datetime'));
    }

    //新建一个命令 赋予适当的初始值
    public function new_sql($_params){
        return parent::insert($_params);
    }

    public function paramFormat($_params) {
        $_params['esg_id']  = isset($_params['esg_id'])  ? $_params['esg_id']   : 0;
        $_params['command']     = isset($_params['command'])     ? $_params['command']      : "gs";
        $_params['arg']         = isset($_params['arg'])         ? $_params['arg']          : "";
        $_params['status']      = isset($_params['status'])      ? $_params['status']       : ESC_COMMAND_STATUS__OPEN;
        $_params['create_time'] = isset($_params['create_time']) ? $_params['create_time']  : h_dt_now();
        return $_params;
    }
    
    public function insert_batch_cmd($params_array){
        if(!$params_array){
            return;
        }
        $_insert_array = array(); 
        foreach($params_array as $k =>$params_group){
            foreach($params_group as $params) {
                array_push($_insert_array,$this->paramFormat($params)); 
            }
        }
        $this->db->insert_batch($this->table_name,$_insert_array);
    }


    //////////////////// 找命令 ////////////////////////////////////////////////////////////////

    //当前活跃命令包括 刚发送的 和 刚读取的
    public function findActiveCommand($esg_id,$cmd=null){
        $this->db->where("( status = ".ESC_COMMAND_STATUS__OPEN." or status =".ESC_COMMAND_STATUS__READ." )");
        if($cmd){
            $this->db->where(array("command"=>$cmd));
        }
        return $this->findOneBy(array("esg_id"=>$esg_id));
    }
    public function findActiveGSCommand($esg_id){
        return $this->esg_command->findActiveCommand($esg_id,"gs");
    }
    public function findActiveGPCommand($esg_id){
        return $this->esg_command->findActiveCommand($esg_id,"gp");
    }
    public function findActiveUrcCommand($esg_id){
        return $this->esg_command->findActiveCommand($esg_id,"gp");
    }

    /////////////////// 发送命令 ///////////////////////////////////////////////////////////////

    private function newCommand($esg_id,$cmd,$user_id=null,$arg=""){
        if(!$esg_id) return null;
        $cache_key = "esg_command_of_" . $esg_id;
        $this->cache->delete($cache_key);

        $conditions = array("esg_id"=>$esg_id,"command"=>$cmd,"status"=>ESC_COMMAND_STATUS__OPEN,"arg"=>$arg);
        $command = $this->findOneBy($conditions);
        if($command){
            $this->esg_command->update($command['id'],array("status"=>ESC_COMMAND_STATUS__REPLACE));
        }
        $this->insert(array("esg_id"=>$esg_id,"command"=>$cmd,"arg"=>$arg,"user_id"=>$user_id));
        $command_id = $this->db->insert_id();
        //如果基站不在线则显示失败
        //$station = $this->station->find($esg_id);
        //if($station['alive'] == ESC_OFFLINE){
        //$this->esg_command->update($command_id,array("status"=>ESC_COMMAND_STATUS__FAIL));
        //}
        return $command_id;
    }

    public function newGSCommand($esg_id,$user_id=null){
        return $this->esg_command->newCommand($esg_id,'gs',$user_id);
    }
    public function newUrcCommand($esg_id,$user_id=null){
        return $this->esg_command->newCommand($esg_id,'urc',$user_id);
    }
    public function newREBCommand($esg_id,$user_id=null){
        return $this->esg_command->newCommand($esg_id,'reb',$user_id);
    }
    public function newUrCommand($esg_id,$arg,$user_id=null){
        return $this->esg_command->newCommand($esg_id,'ur',$user_id,$arg);
    }
    public function newOnCommand($esg_id,$user_id=null){
        return $this->esg_command->newCommand($esg_id,'on',$user_id);
    }
    public function newStCommand($esg_id, $arg, $user_id = null) {
        return $this->esg_command->newCommand($esg_id,'st',$user_id,$arg);
    }
    //发送一个mode3命令
    public function newStCommand_mode3($esg_id, $user_id = null) {
        $arg= "[\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",". /*16*/
            "3,\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"]";
        return $this->esg_command->newCommand($esg_id,'st',$user_id,$arg);
    }
    //发送一个mode1命令
    public function newStCommand_mode1($esg_id, $user_id = null) {
        $arg= "[\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",". /*16*/
            "1,\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"]";
        return $this->esg_command->newCommand($esg_id,'st',$user_id,$arg);
    }
    //发送一个GP命令（获取设置）
    public function newGpCommand($esg_id,$arg,$user_id=null){
        $arg = $arg?$arg:'["p01","p02","p03","p04","p05","p06","p07","p08","p09","p10"]';
        return $this->esg_command->newCommand($esg_id,'gp',$user_id,$arg);
    }


    /////////////////// 完成命令 ///////////////////////////////////////////////////////////////


    public function finishCommandById($id){
        $this->esg_command->update_sql($id, array("status" => ESC_COMMAND_STATUS__CLOSED));
        return $id;
    }
    public function finishCommand($esg_id,$cmd){
        if(!$esg_id) return null;
        $command = $this->esg_command->findActiveCommand($esg_id,$cmd);
        if(!$command){
            return null;
        }else{
            return $this->esg_command->finishCommandById($command['id']);
        }
    }
    public function finishGSCommand($esg_id){
        return $this->esg_command->finishCommand($esg_id,"gs");
    }

    public function finishGpCommand($esg_id){
        return $this->esg_command->finishCommand($esg_id,"gp");
    }


    ////////////////////// 命令下发接口 //////////////////////////////////////

    //返回给一个基站的json字符串
    public function getCommandJsonOfStation($esg_id){
        //正常返回命令缓存20分钟，有新命令下发时会自动清除缓存,即无命令下发时不进行表查询。
        $cache_key = "esg_command_of_" . $esg_id;
        $cache_time = 1200;
        $result = $this->cache->get($cache_key);
        if (!$result) {     //表中未接收命令不进行缓存
            $_command = $this->esg_command->findActiveCommand($esg_id);
            if($_command){
                $_cmd_arg = $_command['arg']?$_command['arg']:"\"\"";
                $result = "[[\"" . $_command['id'] . "\",\"" . $_command['command'] . "\"," . $_cmd_arg . "]]";
                $this->esg_command->update($_command['id'],array("status"=>ESC_COMMAND_STATUS__READ));
            }else{          // 正常返回缓存20分钟
                $result = "[]";
                $this->cache->save($cache_key,$result,$cache_time);
            }
        }
        return $result;
    }


    public function overTime(){
        $this->db->where("create_time < date_sub(now(),interval 60 minute)");        
        $this->db->where("( status = ".ESC_COMMAND_STATUS__OPEN." or status =".ESC_COMMAND_STATUS__READ." )");
        $commands = $this->esg_command->findBy();
        $read_ids = array();
        $open_ids = array();
        foreach($commands as $command){
            if($command['status'] == ESC_COMMAND_STATUS__READ){
                $read_ids[] = $command['id'];
            }else if($command['status'] == ESC_COMMAND_STATUS__OPEN){
                $open_ids[] = $command['id'];
            }
            //todo
            //$cache_key = "command_of_" . $command('station_id');
            //$this->cache->delete($cache_key);
        }
        if($read_ids){
            $this->esg_command->updateBy(array("status"=>ESC_COMMAND_STATUS__OVERTIME2),"id in (".implode(",",$read_ids).")");
        }
        if($open_ids){
            $this->esg_command->updateBy(array("status"=>ESC_COMMAND_STATUS__OVERTIME),"id in (".implode(",",$open_ids).")");
        }
    }
    
    public function set_test_cmd($esg_id, $hour) {
        $cache_key = "esg_command_of_".$esg_id;
        $this->cache->delete($cache_key);
        
        $cmd_array = array();
        switch ($hour%4) {
            case 0:
                $cmd_array = $this->newTestCmdGroup1($esg_id); // xinfeng open and setting
                break;
            case 1:
                $cmd_array = $this->newTestCmdGroup2($esg_id); // colds0 open and setting
                break;
            case 2:
                $cmd_array = $this->newTestCmdGroup3($esg_id); // colds1 open and setting 
                break;
            case 3:
                $cmd_array = $this->newTestCmdGroup4($esg_id); // all open and setting
                break;
            default :
                $cmd_array = $this->newTestCmdGroup4($esg_id);
                break;
        }
        
        return $cmd_array;
    }
    
    public function newCmdArray($esg_id, $cmd, $arg = null) {
        $esg_cmd['esg_id'] = $esg_id;
        $esg_cmd['command'] = $cmd;
        $esg_cmd['arg'] = $arg;
        $esg_cmd['status'] = ESC_COMMAND_STATUS__OPEN;
        $esg_cmd['create_time'] = h_dt_now();
        
        return $esg_cmd;
    }


    // 测试 设置s02，s06-09
    public function setting_Test1($esg_id,$user_id = null) {
        $_arg_str1 = "[\"\",5,\"\",\"\",\"\",180,18,25,38,\"\",\"\",\"\",\"\",\"\",\"\",\"\",". /*16*/
            "\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"]";
        return $this->newCmdArray($esg_id, "st", $_arg_str1);
    }
    
    // 测试 设置 s09-11
    public function setting_Test2($esg_id,$user_id = null) {
        $_arg_str1 = "[\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",38,85,25,\"\",\"\",\"\",\"\",\"\",". /*16*/
            "\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"]";
       return $this->newCmdArray($esg_id, "st", $_arg_str1);
    }
    
    public function remote_fan_Test($esg_id,$user_id = null) {
        $_arg_str1 = "[\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",". /*16*/
            "10,101,\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"]";
         return $this->newCmdArray($esg_id, "st", $_arg_str1);
    }
    
    public function remote_colds0_Test($esg_id,$user_id = null) {
        $_arg_str1 = "[\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",". /*16*/
            "10,102,\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"]";
        return $this->newCmdArray($esg_id, "st", $_arg_str1);
    }
    
    public function remote_colds1_Test($esg_id,$user_id = null) {
        $_arg_str1 = "[\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",". /*16*/
            "10,103,\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"]";
         return $this->newCmdArray($esg_id, "st", $_arg_str1);
    }
    
    public function remote_all_Test($esg_id,$user_id = null) {
        $_arg_str1 = "[\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",". /*16*/
            "10,107,\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"]";
         return $this->newCmdArray($esg_id, "st", $_arg_str1);
    }
    
    public function GSCmdTest($esg_id){
        return $this->newCmdArray($esg_id, "gs");
    }
    
    public function GPCmdTest($esg_id){
        return $this->newCmdArray($esg_id, "gp");
    }

    public function newTestCmdGroup1($esg_id){
        $cmd_array = array();
        $cmd_array[] = $this->esg_command->setting_Test1($esg_id);
        $cmd_array[] = $this->esg_command->setting_Test2($esg_id);
        $cmd_array[] = $this->esg_command->remote_fan_Test($esg_id);
        $cmd_array[] = $this->esg_command->GSCmdTest($esg_id);
        $cmd_array[] = $this->esg_command->GPCmdTest($esg_id);
        
        return $cmd_array;
    }
    
    public function newTestCmdGroup2($esg_id){
        $cmd_array = array();
        $cmd_array[] = $this->esg_command->setting_Test1($esg_id);
        $cmd_array[] = $this->esg_command->setting_Test2($esg_id);
        $cmd_array[] = $this->esg_command->remote_colds0_Test($esg_id);
        $cmd_array[] = $this->esg_command->GSCmdTest($esg_id);
        $cmd_array[] = $this->esg_command->GPCmdTest($esg_id);
        
        return $cmd_array;
        
    }
    
    public function newTestCmdGroup3($esg_id){
        $cmd_array = array();
        $cmd_array[] = $this->esg_command->setting_Test1($esg_id);
        $cmd_array[] = $this->esg_command->setting_Test2($esg_id);
        $cmd_array[] = $this->esg_command->remote_colds1_Test($esg_id);
        $cmd_array[] = $this->esg_command->GSCmdTest($esg_id);
        $cmd_array[] = $this->esg_command->GPCmdTest($esg_id);
        
        return $cmd_array;
    }
    
    public function newTestCmdGroup4($esg_id){
        $cmd_array = array();
        $cmd_array[] = $this->esg_command->setting_Test1($esg_id);
        $cmd_array[] = $this->esg_command->setting_Test2($esg_id);
        $cmd_array[] = $this->esg_command->remote_all_Test($esg_id);
        $cmd_array[] = $this->esg_command->GSCmdTest($esg_id);
        $cmd_array[] = $this->esg_command->GPCmdTest($esg_id);
        
        return $cmd_array;
    }

}











