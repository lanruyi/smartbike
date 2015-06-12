<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_column_station_num_in_roms extends CI_Migration {

    public function up(){
        $this->db->query(" ALTER TABLE  `roms` ADD column station_num int(11) default null comment '该rom的基站数量'");
    }


    public function down()
    {
        $this->db->query(" ALTER TABLE `roms` DROP  column station_num");
    }

}
