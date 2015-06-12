<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_stagroups extends CI_Migration {


    public function up(){
        $this->dbforge->add_field("`id`                 INT(10) UNSIGNED NOT NULL AUTO_INCREMENT");
        $this->dbforge->add_field("`name_chn`            VARCHAR(10) DEFAULT NULL");
        $this->dbforge->add_field("`count`               INT(10) UNSIGNED DEFAULT '0' NOT NULL");
        $this->dbforge->add_field("`type`                TINYINT(2) UNSIGNED DEFAULT '0' NOT NULL");
 
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('stagroups');
    	
    }

    public function down()
    {
    }

}



