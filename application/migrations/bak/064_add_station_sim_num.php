<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_station_sim_num extends CI_Migration {

    public function up()
    {
        $fields = array("`sim_num`     varchar(50) DEFAULT ''");
        $this->dbforge->add_column('stations', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('stations', 'sim_num');
    }

}
