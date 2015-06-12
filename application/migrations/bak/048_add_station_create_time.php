<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_station_create_time extends CI_Migration {

    public function up()
    {
        $fields = array("`create_time`     datetime DEFAULT '0000-00-00 00:00:00'");
        $this->dbforge->add_column('stations', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('stations', 'create_time');
    }

}