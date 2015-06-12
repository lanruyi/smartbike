<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_esgconf_load_num_host extends CI_Migration {

    public function up()
    {
        $this->db->query("alter table esgconfs add column load_num decimal(5,2) not null default 0 comment '当前基站负载'");
        $this->db->query("alter table esgconfs add column host varchar(20) not null default '' comment '上位机主机名'");
    }
    
    public function down()
    {
        $this->db->query("alter table esgconfs drop column load_num");
        $this->db->query("alter table esgconfs drop column host");
    }

}








