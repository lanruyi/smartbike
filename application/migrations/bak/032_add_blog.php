<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_blog extends CI_Migration {


    public function up()
    {
        $this->dbforge->add_field("`id`               INT(10) UNSIGNED NOT NULL AUTO_INCREMENT");
        $this->dbforge->add_field("`station_id`       INT(10) UNSIGNED DEFAULT NULL");
        $this->dbforge->add_field("`author_id`        INT(10) UNSIGNED DEFAULT NULL");
        $this->dbforge->add_field("`content`          text COLLATE utf8_bin NOT NULL");
        $this->dbforge->add_field("`create_time`      datetime NOT NULL DEFAULT '0000-00-00 00:00:00'");

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('blogs');
    }

    public function down()
    {
        $this->dbforge->drop_table('blogs');
    }

}

?>
