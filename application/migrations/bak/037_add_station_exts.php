<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_station_exts extends CI_Migration {


    public function up()
    {
        $this->dbforge->add_field("`id`                   INT(10) UNSIGNED NOT NULL AUTO_INCREMENT");
        $this->dbforge->add_field("`station_id`      	  INT(10) UNSIGNED DEFAULT NULL");
        $this->dbforge->add_field("`ampere`        	  INT(10) UNSIGNED DEFAULT NULL");	
	$this->dbforge->add_field("`uptime`        	  INT(10) UNSIGNED DEFAULT NULL");	
        $this->dbforge->add_field("`box_size`       	  VARCHAR(255) DEFAULT NULL");

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('station_exts');
    }

    public function down()
    {
        $this->dbforge->drop_table('station_exts');
    }

}

?>