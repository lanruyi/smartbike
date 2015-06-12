<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_sysconfig_config_name extends CI_Migration {

    public function up()
    {
        $this->db->query("alter table sysconfig add `config_name` varchar(20) not null default '' comment '配置名'");
    }
    
    public function down()
    {
    	$this->db->query("alter table sysconfig drop `config_name`");
    }


}

