<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_station_rom_id extends CI_Migration {

    public function up()
    {
        $fields = array("`rom_id` int(10) DEFAULT NULL",
                        "`new_rom_id` int(10) DEFAULT NULL",
                        "`current_part_id` int(10) DEFAULT NULL");
        $this->dbforge->add_column('stations', $fields);
    }

    public function down()
    {
                
    }

}

?>
