<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_station_load_num extends CI_Migration {

    public function up()
    {
        $fields = array("`load_num`      int(10) DEFAULT NULL");
        $this->dbforge->add_column('stations', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('stations', 'load_num');
    }

}