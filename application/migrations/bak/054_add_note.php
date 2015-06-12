<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_note extends CI_Migration {


    public function up()
    {
        $this->dbforge->add_field("`id`               INT(10) UNSIGNED NOT NULL AUTO_INCREMENT");
        $this->dbforge->add_field("`station_id`       INT(10) UNSIGNED DEFAULT NULL");
        $this->dbforge->add_field("`author_id`        INT(10) UNSIGNED DEFAULT NULL");
        $this->dbforge->add_field("`content`          text COLLATE utf8_bin DEFAULT NULL");
        $this->dbforge->add_field("`create_time`      datetime DEFAULT NULL");
		$this->dbforge->add_field("`note_time`        datetime DEFAULT NULL");

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('notes');
    }

    public function down()
    {
        $this->dbforge->drop_table('notes');
    }

}

?>