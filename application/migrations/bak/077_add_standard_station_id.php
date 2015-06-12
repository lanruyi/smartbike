<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_standard_station_id extends CI_Migration {

    public function up()
    {
        $fields = array("`standard_station_id`        int(11) not null DEFAULT '0'");
        $this->dbforge->add_column('stations', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('stations', 'standard_station_id');
    }

}

