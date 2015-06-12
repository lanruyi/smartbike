<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Userlog extends CI_Migration {


    public function up()
    {
        $this->dbforge->add_field("`id`                   INT(10) UNSIGNED NOT NULL AUTO_INCREMENT");
        $this->dbforge->add_field("`user_id`      	  INT(10) UNSIGNED DEFAULT NULL");
        $this->dbforge->add_field("`url`        	  VARCHAR(255) DEFAULT NULL");		
        $this->dbforge->add_field("`data`       	  VARCHAR(255) DEFAULT NULL");
	$this->dbforge->add_field("`method`        	  VARCHAR(10) DEFAULT NULL");
        $this->dbforge->add_field("`create_time`          DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'");

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('userlogs');
    }

    public function down()
    {
        $this->dbforge->drop_table('userlogs');
    }

}

?>
