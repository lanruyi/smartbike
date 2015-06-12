<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_alias_to_contracts extends CI_Migration {

    public function up()
    {
        $this->db->query("alter table contracts add `alias` varchar(255) default null comment '分期别名'");
    }
    
    public function down()
    {
    	$this->db->query("alter table contracts drop `alias`");
    }


}

