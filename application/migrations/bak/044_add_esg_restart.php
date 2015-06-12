<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_esg_restart extends CI_Migration {


    public function up()
    {
        $this->dbforge->add_field("`id`               INT(10) UNSIGNED NOT NULL AUTO_INCREMENT");
        $this->dbforge->add_field("`station_id`       INT(10) UNSIGNED DEFAULT NULL");
        $this->dbforge->add_field("`esg_id`        	  INT(10) UNSIGNED DEFAULT NULL");
        $this->dbforge->add_field("`restart_time`     datetime DEFAULT '0000-00-00 00:00:00'");

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('restarts');
    }

    public function down()
    {
        $this->dbforge->drop_table('restarts');
    }

}

?>