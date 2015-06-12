<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_station_ns extends CI_Migration {

    public function up()
    {
        $fields = array("`ns`        int(10) DEFAULT '0'",
                        "`ns_start`  datetime default '20120401000000'");
        $this->dbforge->add_column('stations', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('stations', 'warning_priority');
    }

}

