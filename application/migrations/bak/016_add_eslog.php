<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_eslog extends CI_Migration {


    public function up()
    {
        $this->dbforge->add_field("`id`               INT(10) UNSIGNED NOT NULL AUTO_INCREMENT");
        $this->dbforge->add_field("`long_log`         text NOT NULL");
        $this->dbforge->add_field("`log`              VARCHAR(255) DEFAULT NULL");
        $this->dbforge->add_field("`type`             TINYINT(1) UNSIGNED DEFAULT '0' NOT NULL");
        $this->dbforge->add_field("`create_time`      datetime NOT NULL DEFAULT '0000-00-00 00:00:00'");
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('eslogs');
    }

    public function down()
    {
        $this->dbforge->drop_table('eslogs');
    }

}

