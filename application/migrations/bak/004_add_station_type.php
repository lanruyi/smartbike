<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_station_type extends CI_Migration {

    public function up()
    {
        $fields = array("`station_type` tinyint(1) NOT NULL DEFAULT '0'");
        $this->dbforge->add_column('stations', $fields);

        $fields = array("`total_load` `total_load` tinyint(2) NOT NULL DEFAULT '0'");
        $this->dbforge->modify_column("stations",$fields);
    }

    public function down()
    {
                
    }

}

