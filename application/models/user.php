<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define('STATUS_ACTIVATED', '1');
define('STATUS_NOT_ACTIVATED', '0');

class User extends ES_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->table_name = "users";
        $this->load->helper('common');
    }


    public function checkUser_md5($user,$pass_md5){
        return $this->user->findOneBy(array(
            "username"=>strval(trim($user)),
            "password"=>strval(trim($pass_md5)),
            "recycle"=>ESC_NORMAL));
    }

    public function findAllUsers(){
        return $this->findBy(array("recycle"=>ESC_NORMAL));
    }

    //查询用户名字
    public function getUserNameChn($id) {
        if (!$id)
            return "暂无";
        $result = $this->find_sql($id);
        return $result ? $result['name_chn'] : "暂无";
    }

    //查询某个用户组的所有用户
    public function findDepartment($department_id) {
        $query = $this->db->query("select * from users where recycle=? and department_id=?", array(ESC_NORMAL,$department_id));
        return $query->result_array();
    }

    //返回值:维修人的电话
    public function findUsertel_sql($dispatcher_id) {
        if (!$dispatcher_id) {
            return "暂无";
        }
        $user = $this->find_sql($dispatcher_id);
        return $user ? $user['telephone'] : "暂无";
    }

    //有单元
    public function del_user($user_id) {
        $this->update_sql($user_id, array('recycle' => ESC_DEL));
    }

    public function findUserByIds($arr,$params){
        $this->db->where_in('id',$arr);
        $this->db->select(implode(',', $params));
        $query = $this->db->get($this->table_name);
        $res = $query->result_array();
        return $res;
    }
 }
