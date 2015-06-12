<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_station_percentage extends CI_Migration {

    public function up(){
        $this->db->query("alter table stations add column saving_percentage decimal(3,2) not null default 1.00");
    }


    public function down()
    {
        $this->db->query(" ALTER TABLE `stations` DROP column `saving_percentage` ");
    }

}
