<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_station_force extends CI_Migration {

    public function up()
    {
        $fields = array("`force_on`     tinyint(1) DEFAULT '1'");
        $this->dbforge->add_column('stations', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('stations', 'force_on');
    }

}
