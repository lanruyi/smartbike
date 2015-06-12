<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_extra_ac_to_station extends CI_Migration {

    public function up(){
        $this->db->query("alter table stations add extra_ac int(10) default 0");
    }


    public function down(){
        $this->db->query("ALTER TABLE `stations` DROP column `extra_ac` ");
    }

}
