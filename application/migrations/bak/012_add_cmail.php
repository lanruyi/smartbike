<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_cmail extends CI_Migration {


    public function up()
    {
        $this->dbforge->add_field("`id`               INT(10) UNSIGNED NOT NULL AUTO_INCREMENT");
        $this->dbforge->add_field("`to_add`           text NOT NULL");
        $this->dbforge->add_field("`from_add`         VARCHAR(255) DEFAULT NULL");
        $this->dbforge->add_field("`subject`          VARCHAR(255) DEFAULT NULL");
        $this->dbforge->add_field("`content`          text NOT NULL");
        $this->dbforge->add_field("`type`             TINYINT(1) UNSIGNED DEFAULT '0' NOT NULL");
        $this->dbforge->add_field("`status`           TINYINT(1) UNSIGNED DEFAULT '0' NOT NULL");
        $this->dbforge->add_field("`priority`         TINYINT(1) UNSIGNED DEFAULT '0' NOT NULL");

        $this->dbforge->add_field("`create_time`      datetime NOT NULL DEFAULT '0000-00-00 00:00:00'");
        $this->dbforge->add_field("`send_time`        datetime NOT NULL DEFAULT '0000-00-00 00:00:00'");
        $this->dbforge->add_field("`real_send_time`   datetime DEFAULT '0000-00-00 00:00:00'");

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('cmails');
    }

    public function down()
    {
        
    }

}





