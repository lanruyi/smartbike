<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_esgconf extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field("`id`                         INT(10) UNSIGNED NOT NULL AUTO_INCREMENT");
        $this->dbforge->add_field("`station_id`                 INT(10) UNSIGNED DEFAULT  '0' NOT NULL");
        $this->dbforge->add_field("`update_duration`            INT(10) DEFAULT NULL");
        $this->dbforge->add_field("`update_fixed_datetime`      INT(10) DEFAULT NULL");
        $this->dbforge->add_field("`sample_duration`            VARCHAR(50) DEFAULT NULL");
        $this->dbforge->add_field("`sample_fixed_datetime`      INT(10) DEFAULT NULL");
        $this->dbforge->add_field("`base_interval`              VARCHAR(50) DEFAULT NULL");
        $this->dbforge->add_field("`warning_period`             INT(10) DEFAULT NULL");
        $this->dbforge->add_field("`lowest_press`               INT(10) DEFAULT NULL");
        $this->dbforge->add_field("`highest_colds_temp`         INT(10) DEFAULT NULL");
        $this->dbforge->add_field("`highest_indoor_tmp`         INT(10) DEFAULT NULL");
        $this->dbforge->add_field("`highest_indoor_hum`         INT(10) DEFAULT NULL");
        $this->dbforge->add_field("`highest_box_tmp`            INT(10) DEFAULT NULL");
        $this->dbforge->add_field("`ch_tmp`                     INT(10) DEFAULT NULL");
        $this->dbforge->add_field("`cd_tmp`                     INT(10) DEFAULT NULL");
        $this->dbforge->add_field("`fan0_new_tmp_step`          INT(10) DEFAULT NULL");
        $this->dbforge->add_field("`hh_tmp`                     INT(10) DEFAULT NULL");
        $this->dbforge->add_field("`hd_tmp`                     INT(10) DEFAULT NULL");
        $this->dbforge->add_field("`sys_mode`                   INT(10) DEFAULT NULL");
        $this->dbforge->add_field("`simple_control`             INT(10) DEFAULT NULL");
        $this->dbforge->add_field("`day_of_week`                INT(10) DEFAULT NULL");
        $this->dbforge->add_field("`ctime`                      INT(10) DEFAULT NULL");
        $this->dbforge->add_field("`colds_order`                INT(10) DEFAULT NULL");
        $this->dbforge->add_field("`colds_min_time`             INT(10) DEFAULT NULL");
        $this->dbforge->add_field("`colds_box_type`             INT(10) DEFAULT NULL");
        $this->dbforge->add_field("`smart_meter_type`           INT(10) DEFAULT NULL");
        $this->dbforge->add_field("`colds_0_ctrl_type`          INT(10) DEFAULT NULL");
        $this->dbforge->add_field("`colds_1_ctrl_type`          INT(10) DEFAULT NULL");
        $this->dbforge->add_field("`fan_keep_on_time`           INT(10) DEFAULT NULL");
        $this->dbforge->add_field("`last_update_time`           datetime DEFAULT NULL");

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('esgconfs');

    }

    public function down()
    {
        $this->dbforge->drop_table('esgconfs');
    }
}
