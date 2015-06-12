<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_station_id_index extends CI_Migration {

    public function up()
    {
        $this->db->query("ALTER TABLE `esgconfs` ADD INDEX (`station_id`)");
    }
    
    public function down()
    {
    }


}



