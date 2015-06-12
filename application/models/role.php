<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


define('ESC_AUTHORITY__FRONTEND_READ', 1); #前端数据查看权限
define('ESC_AUTHORITY__FRONTEND_CONTROL', 2); #前端基站控制权限
define('ESC_AUTHORITY__FRONTEND_DETAIL', 10); #前端基站详细数据权限

define('ESC_AUTHORITY__BACKEND_STATION_DATA', 3); #后端基站数据管理权限
define('ESC_AUTHORITY__BACKEND_ESG', 4); #后端ESG管理权限
define('ESC_AUTHORITY__BACKEND_ADMINISTRATOR', 5); #后端超级管理权限（area.cmail.rom.user.role.project.statistic.report.tools）
define('ESC_AUTHORITY__BACKEND_AGING', 6); #后端老化系统管理权限
define('ESC_AUTHORITY__BACKEND_STATION_LOG', 7); #后端基站维护日志管理权限
define('ESC_AUTHORITY__BACKEND_INSTALLATION', 8); #后端施工管理权限

define('ESC_AUTHORITY__REPORTING',9);#报表系统查看权限

class Role extends ES_Model {

	public function __construct()
	{
        parent::__construct();
        $this->load->database();
		$this->table_name = "roles";
        $this->load->helper('role');
	}

	public function getRoleNameChn($id=0){
		$result = $this->find_sql($id);
		return $result?$result['name_chn']:"无";
	}

    public function getAllRoles(){
        return $this->findBy_sql(array());
    }


    public function paramFormat($_params) {
        $_params['name_chn']  = isset($_params['name_chn'])  ? $_params['name_chn']   : "";
        $_params['role_id']   = isset($_params['role_id'])   ? $_params['role_id']   : null;
        return $_params;
    }



}

