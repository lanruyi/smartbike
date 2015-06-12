<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_bug_esg_station_id_index extends CI_Migration {

    public function up(){
        $this->db->query(" ALTER TABLE  `esgs` ADD INDEX (`station_id`)");
        $this->db->query(" ALTER TABLE  `bugs` ADD INDEX (`station_id`)");
    }


    public function down()
    {
        $this->db->query(" ALTER TABLE `esgs` DROP INDEX `station_id` ");
        $this->db->query(" ALTER TABLE `bugs` DROP INDEX `station_id` ");
    }

}
