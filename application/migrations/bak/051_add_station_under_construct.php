<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_station_under_construct extends CI_Migration {

    public function up()
    {
        $fields = array("`under_construct`     tinyint(1) DEFAULT '1'");
        $this->dbforge->add_column('stations', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('stations', 'under_construct');
    }

}
