<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_station_has_3g extends CI_Migration {

    public function up(){
        $this->db->query("alter table stations add column has_3g tinyint(2) default 2");
    }


    public function down(){
        $this->db->query(" ALTER TABLE `stations` DROP column `has_3g` ");
    }

}
