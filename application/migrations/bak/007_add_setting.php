<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_setting extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field("`id`                 INT(10) UNSIGNED NOT NULL AUTO_INCREMENT");
        $this->dbforge->add_field("`station_id`         INT(10) UNSIGNED DEFAULT '0' NOT NULL");
        $this->dbforge->add_field("`command_id`         INT(10) UNSIGNED DEFAULT '0' NOT NULL");
        $this->dbforge->add_field("`update_duration`    INT(10) UNSIGNED DEFAULT NULL");
        $this->dbforge->add_field("`update_fixed_datetime` VARCHAR(30) DEFAULT NULL");
        $this->dbforge->add_field("`sample_duration`    INT(10) UNSIGNED DEFAULT NULL");
        $this->dbforge->add_field("`sample_fixed_datetime` VARCHAR(30) DEFAULT NULL");
        $this->dbforge->add_field("`base_interval`      INT(10) UNSIGNED DEFAULT NULL");
        $this->dbforge->add_field("`warning_period`     INT(10) UNSIGNED DEFAULT NULL");
        $this->dbforge->add_field("`lowest_press`       INT(10) UNSIGNED DEFAULT NULL");
        $this->dbforge->add_field("`highest_colds_temp` INT(10) UNSIGNED DEFAULT NULL");
        $this->dbforge->add_field("`highest_indoor_tmp` INT(10) UNSIGNED DEFAULT NULL");
        $this->dbforge->add_field("`highest_indoor_hum` INT(10) UNSIGNED DEFAULT NULL");
        $this->dbforge->add_field("`highest_box_tmp`    INT(10) UNSIGNED DEFAULT NULL");
        $this->dbforge->add_field("`type`               INT(4) UNSIGNED DEFAULT '0' NOT NULL");
        $this->dbforge->add_field("`setting_type`       INT(4) UNSIGNED DEFAULT '0' NOT NULL");
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('setting');
    }

    public function down()
    {
        $this->dbforge->drop_table('setting');
    }

}

?>
