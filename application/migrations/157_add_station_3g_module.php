<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Migration_Add_station_3g_module extends CI_Migration {

    public function up(){
        $this->db->query("alter table stations add column 3g_module varchar(10) not null default 1");
    }


    public function down(){
        $this->db->query(" ALTER TABLE `stations` DROP column `3g_module` ");
    }

}
