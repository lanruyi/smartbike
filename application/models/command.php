<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(ROOTPATH."/application/helpers/command_helper.php");

class Command extends ES_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->table_name = "commands";
        $this->load->helper('command');
        $this->load->model('station');
    }

    //新建一个命令 赋予适当的初始值
    public function new_sql($_params){
        return parent::insert($_params);
    }

    public function paramFormat($_params) {
        $_params['station_id']  = isset($_params['station_id'])  ? $_params['station_id']   : 0;
        $_params['command']     = isset($_params['command'])     ? $_params['command']      : "gs";
        $_params['arg']         = isset($_params['arg'])         ? $_params['arg']          : "";
        $_params['status']      = isset($_params['status'])      ? $_params['status']       : ESC_COMMAND_STATUS__OPEN;
        $_params['priority']    = isset($_params['priority'])    ? $_params['priority']     : 0;
        $_params['user_id']     = isset($_params['user_id'])     ? $_params['user_id']      : null;
        $_params['create_time'] = isset($_params['create_time']) ? $_params['create_time']  : h_dt_now();
        return $_params;
    }


    //////////////////// 找命令 ////////////////////////////////////////////////////////////////

    //当前活跃命令包括 刚发送的 和 刚读取的
    public function findActiveCommand($station_id,$cmd=null){
        $this->db->where("( status = ".ESC_COMMAND_STATUS__OPEN." or status =".ESC_COMMAND_STATUS__READ." )");
        if($cmd){
            $this->db->where(array("command"=>$cmd));
        }
        return $this->findOneBy(array("station_id"=>$station_id));
    }
    public function findActiveGSCommand($station_id){
        return $this->command->findActiveCommand($station_id,"gs");
    }
    public function findActiveGPCommand($station_id){
        return $this->command->findActiveCommand($station_id,"gp");
    }
    public function findActiveUrcCommand($station_id){
        return $this->command->findActiveCommand($station_id,"gp");
    }

    /////////////////// 发送命令 ///////////////////////////////////////////////////////////////

    private function newCommand($station_id,$cmd,$user_id=null,$arg=""){
        if(!$station_id) return null;
        $cache_key = "command_of_" . $station_id;
        $this->cache->delete($cache_key);

        $conditions = array("station_id"=>$station_id,"command"=>$cmd,"status"=>ESC_COMMAND_STATUS__OPEN,"arg"=>$arg);
        $command = $this->findOneBy($conditions);
        if($command){
            $this->command->update($command['id'],array("status"=>ESC_COMMAND_STATUS__REPLACE));
        }
        $this->insert(array("station_id"=>$station_id,"command"=>$cmd,"arg"=>$arg,"user_id"=>$user_id));
        $command_id = $this->db->insert_id();
        //如果基站不在线则显示失败
        //$station = $this->station->find($station_id);
        //if($station['alive'] == ESC_OFFLINE){
        //$this->command->update($command_id,array("status"=>ESC_COMMAND_STATUS__FAIL));
        //}
        return $command_id;
    }

    public function newGSCommand($station_id,$user_id=null){
        return $this->newCommand($station_id,'gs',$user_id);
    }
    public function newUrcCommand($station_id,$user_id=null){
        return $this->newCommand($station_id,'urc',$user_id);
    }
    public function newREBCommand($station_id,$user_id=null){
        return $this->newCommand($station_id,'reb',$user_id);
    }
    public function newUrCommand($station_id,$arg,$user_id=null){
        return $this->newCommand($station_id,'ur',$user_id,$arg);
    }
    public function newOnCommand($station_id,$user_id=null){
        return $this->newCommand($station_id,'on',$user_id);
    }
    public function newStCommand($station_id, $arg, $user_id = null) {
        return $this->newCommand($station_id,'st',$user_id,$arg);
    }
    //发送一个mode3命令
    public function newStCommand_mode3($station_id, $user_id = null) {
        $arg= "[\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",". /*16*/
            "3,\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"]";
        return $this->newCommand($station_id,'st',$user_id,$arg);
    }
    //发送一个mode1命令
    public function newStCommand_mode1($station_id, $user_id = null) {
        $arg= "[\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",". /*16*/
            "1,\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"]";
        return $this->newCommand($station_id,'st',$user_id,$arg);
    }
    //发送一个GP命令（获取设置）
    public function newGpCommand($station_id,$arg,$user_id=null){
        $arg = $arg?$arg:'["p01","p02","p03","p04","p05","p06","p07","p08","p09","p10"]';
        return $this->newCommand($station_id,'gp',$user_id,$arg);
    }


    /////////////////// 完成命令 ///////////////////////////////////////////////////////////////


    public function finishCommandById($id){
        $this->command->update_sql($id, array("status" => ESC_COMMAND_STATUS__CLOSED));
        return $id;
    }
    public function finishCommand($station_id,$cmd){
        if(!$station_id) return null;
        $command = $this->command->findActiveCommand($station_id,$cmd);
        if(!$command){
            return null;
        }else{
            return $this->command->finishCommandById($command['id']);
        }
    }
    public function finishGSCommand($station_id){
        return $this->command->finishCommand($station_id,"gs");
    }

    public function finishGpCommand($station_id){
        return $this->command->finishCommand($station_id,"gp");
    }


    ////////////////////// 命令下发接口 //////////////////////////////////////

    //返回给一个基站的json字符串
    public function getCommandJsonOfStation($station_id){
        //命令缓存20分钟，有新命令下发时会自动清除缓存。
        //有命令被读取时 也会清空缓存
        $cache_key = "command_of_" . $station_id;
        $cache_time = 1200;
        $result = $this->cache->get($cache_key);
        if (!$result) {
            $_command = $this->command->findActiveCommand($station_id);
            if($_command){
                $_cmd_arg = $_command['arg']?$_command['arg']:"\"\"";
                $result = "[[\"" . $_command['id'] . "\",\"" . $_command['command'] . "\"," . $_cmd_arg . "]]";
                $this->command->update($_command['id'],array("status"=>ESC_COMMAND_STATUS__READ));
            }else{
                $result = "[]";
                $this->cache->save($cache_key,$result,$cache_time);
            }
        }
        return $result;
    }


    public function overTime(){
        $this->db->where("create_time < date_sub(now(),interval 60 minute)");        
        $this->db->where("( status = ".ESC_COMMAND_STATUS__OPEN." or status =".ESC_COMMAND_STATUS__READ." )");
        $commands = $this->command->findBy();
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
            $this->command->updateBy(array("status"=>ESC_COMMAND_STATUS__OVERTIME2),"id in (".implode(",",$read_ids).")");
        }
        if($open_ids){
            $this->command->updateBy(array("status"=>ESC_COMMAND_STATUS__OVERTIME),"id in (".implode(",",$open_ids).")");
        }
    }

}











