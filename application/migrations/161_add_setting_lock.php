<?php  defined('BASEPATH') OR exit('No direct script access allowed');
class Migration_Add_setting_lock extends CI_Migration {

    public function up(){
        $this->db->query("alter table stations add column setting_lock tinyint(1) default 1 comment 'value 1 represents unlock, 2 is locked'");
    }

    public function down(){
		$this->db->query("alter table `stations` drop column `setting_lock`");
    }
}

