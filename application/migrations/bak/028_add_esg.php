<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_esg extends CI_Migration {


    public function up(){
        $this->dbforge->add_field("`id`                INT(10) UNSIGNED NOT NULL AUTO_INCREMENT");
        $this->dbforge->add_field("`string`            VARCHAR(50) DEFAULT NULL");
        $this->dbforge->add_field("`esg_key`           VARCHAR(50) DEFAULT NULL");
        $this->dbforge->add_field("`station_id`        int(10) DEFAULT NULL");
        $this->dbforge->add_field("`alive`             TINYINT(1) NOT NULL DEFAULT '0'");
        $this->dbforge->add_field("`count`             int(10) DEFAULT '0' NOT NULL");
        $this->dbforge->add_field("`status`            TINYINT(3) NOT NULL DEFAULT '0'");
        $this->dbforge->add_field("`create_time`       datetime DEFAULT '0000-00-00 00:00:00'");
        $this->dbforge->add_field("`last_update_time`  datetime");
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('esgs');

        $fields = array("`esg_id`     int(10) DEFAULT NULL ");
        $this->dbforge->add_column('stations', $fields);

    }

    public function down(){
        $this->dbforge->drop_table('esgs');
        $this->dbforge->drop_column('stations', 'esg_id');
    }

}

?>
