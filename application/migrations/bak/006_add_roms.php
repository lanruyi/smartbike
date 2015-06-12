<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_roms extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field("`id`                 INT(10) UNSIGNED NOT NULL AUTO_INCREMENT");
        $this->dbforge->add_field("`version`            VARCHAR(30) DEFAULT NULL");
        $this->dbforge->add_field("`size`               INT(10) UNSIGNED DEFAULT '0' NOT NULL");
        $this->dbforge->add_field("`num`                INT(4) UNSIGNED DEFAULT '0' NOT NULL");
        $this->dbforge->add_field("`type`               TINYINT(2) UNSIGNED DEFAULT '0' NOT NULL");
        $this->dbforge->add_field("`name`               VARCHAR(300) DEFAULT NULL");
        $this->dbforge->add_field("`orig_name`          VARCHAR(300) DEFAULT NULL");
        $this->dbforge->add_field("`comment`            TEXT NOT NULL DEFAULT ''");
        $this->dbforge->add_field("`created`            datetime NOT NULL DEFAULT '0000-00-00 00:00:00'");

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('roms');

    }

    public function down()
    {
    }
}

?>
