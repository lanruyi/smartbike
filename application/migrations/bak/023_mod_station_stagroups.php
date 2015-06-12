<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Mod_station_stagroups extends CI_Migration {

    public function up(){

        $this->dbforge->drop_table('station_stagroups');
        $this->dbforge->add_field("`station_id`               INT(10) UNSIGNED DEFAULT '0' NOT NULL");
        $this->dbforge->add_field("`stagroup_id`               INT(10) UNSIGNED DEFAULT '0' NOT NULL");
 
        $this->dbforge->add_key(array('station_id','stagroup_id'), TRUE);
        $this->dbforge->create_table('station_stagroups');
    }

    public function down()
    {
    }

}


