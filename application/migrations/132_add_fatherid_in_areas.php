<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_fatherid_in_areas extends CI_Migration {

    public function up()
    {
        $this->db->query("alter table `areas` add column `father_id` int(9) not null default 0 comment '父类id'");
        $this->db->query("alter table `stations` add column `district_id` int(9) not null default 0 comment '区域id'");


    }
    
    public function down()
    {
        $this->db->query("alter table `areas` drop column `father_id`");
        $this->db->query("alter table `stations` drop column `district_id`");
    }


}

