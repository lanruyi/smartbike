<?php  defined('BASEPATH') OR exit('No direct script access allowed');
class Migration_Add_temp_high_reboot extends CI_Migration {

    public function up(){
        $this->db->query("alter table stations add column temp_high_reboot tinyint(1) default 1 comment 'value 1 represents disabled, 2 is enabled'");
    }

    public function down(){
		$this->db->query("alter table `stations` drop column `temp_high_reboot`");
    }
}

