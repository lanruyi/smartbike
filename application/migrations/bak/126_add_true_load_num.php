<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_true_load_num extends CI_Migration {

    public function up()
    {
        $this->db->query("alter table daydatas add column true_load_num decimal(9,6) default null comment '真实负载'");
        $this->db->query("alter table monthdatas add column true_load_num decimal(9,6) default null comment '真实负载'");
    }
    
    public function down()
    {
    	$this->db->query("alter table daydatas drop column true_load_num");
    	$this->db->query("alter table monthdatas drop column true_load_num");
    }


}

