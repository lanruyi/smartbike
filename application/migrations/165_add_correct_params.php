<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_correct_params extends CI_Migration {

    public function up(){
        $this->db->query("alter table corrects add column `last_time` datetime DEFAULT NULL");
		$this->db->query("alter table corrects add column `last_correct_num` decimal(10,2) DEFAULT NULL");
		$this->db->query("alter table corrects add column `last_org_num` decimal(10,2) DEFAULT NULL");
		$this->db->query("alter table corrects add column `status` tinyint(1) unsigned DEFAULT 1");
		$this->db->query("alter table corrects add column `ratio` decimal(5,4) DEFAULT 1.0000 comment '联通/博欧电表各自两次差值的比值'");
    }


    public function down()
    {
        $this->db->query(" ALTER TABLE `corrects` DROP column `last_time` ");
		$this->db->query(" ALTER TABLE `corrects` DROP column `last_correct_num` ");
		$this->db->query(" ALTER TABLE `corrects` DROP column `last_org_num` ");
		$this->db->query(" ALTER TABLE `corrects` DROP column `status` ");
		$this->db->query(" ALTER TABLE `corrects` DROP column `ratio` ");
    }

}
