<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_station_air_volume extends CI_Migration {

    public function up()
    {
        $fields = array("`air_volume`   tinyint(1) DEFAULT '0'");
        $this->dbforge->add_column('stations', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('stations', 'air_volume');
    }

}
