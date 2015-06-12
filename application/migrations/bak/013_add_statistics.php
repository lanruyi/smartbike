
<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_statistics extends CI_Migration {


    public function up()
    {
        $this->dbforge->add_field("`id`               INT(10) UNSIGNED NOT NULL AUTO_INCREMENT");
        $this->dbforge->add_field("`time`             datetime NOT NULL");
        $this->dbforge->add_field("`type`             TINYINT(1) UNSIGNED DEFAULT '0' NOT NULL");
        $this->dbforge->add_field("`station_id`         INT(10) UNSIGNED NOT NULL");

        $this->dbforge->add_field("`main_energy`        DECIMAL(10,2) DEFAULT NULL");
        $this->dbforge->add_field("`ac_energy`          DECIMAL(10,2) DEFAULT NULL");
        $this->dbforge->add_field("`dc_energy`          DECIMAL(10,2) DEFAULT NULL");

        $this->dbforge->add_field("`colds_0_time`          INT(10) UNSIGNED DEFAULT NULL");
        $this->dbforge->add_field("`colds_1_time`          INT(10) UNSIGNED DEFAULT NULL");
        $this->dbforge->add_field("`fan_time`              INT(10) UNSIGNED DEFAULT NULL");
        $this->dbforge->add_field("`colds_0_switch_num`    INT(10) UNSIGNED DEFAULT NULL");
        $this->dbforge->add_field("`colds_1_switch_num`    INT(10) UNSIGNED DEFAULT NULL");
        $this->dbforge->add_field("`fan_switch_num`        INT(10) UNSIGNED DEFAULT NULL");

        $this->dbforge->add_field("`indoor_tmp_gt_time`      INT(10) UNSIGNED DEFAULT NULL");
        $this->dbforge->add_field("`box_tmp_gt_time`         INT(10) UNSIGNED DEFAULT NULL");

        $this->dbforge->add_field("`no_power_time`         INT(10) UNSIGNED DEFAULT NULL");
        $this->dbforge->add_field("`all_off_time`          INT(10) UNSIGNED DEFAULT NULL");

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('statisticses');

        $fields = array("`num` `num` DECIMAL(10,2) DEFAULT NULL");
        $this->dbforge->modify_column("energies",$fields);
    }

    public function down()
    {
        
    }

}





