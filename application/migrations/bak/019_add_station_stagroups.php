<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_station_stagroups extends CI_Migration {

    public function up(){
        $this->dbforge->add_field("`id`                 INT(10) UNSIGNED NOT NULL AUTO_INCREMENT");
        $this->dbforge->add_field("`stagroup_id`               INT(10) UNSIGNED DEFAULT '0' NOT NULL");
        $this->dbforge->add_field("`station_id`               INT(10) UNSIGNED DEFAULT '0' NOT NULL");
 
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('station_stagroups');
    }

    public function down()
    {
    }

}


