<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_data extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field("`id`                 INT(10) UNSIGNED NOT NULL AUTO_INCREMENT");
        $this->dbforge->add_field("`station_id`         INT(10) UNSIGNED DEFAULT '0' NOT NULL");

        $this->dbforge->add_field("`indoor_tmp`          DECIMAL(3,1) DEFAULT NULL");
        $this->dbforge->add_field("`outdoor_tmp`         DECIMAL(3,1) DEFAULT NULL");
        $this->dbforge->add_field("`box_tmp`             DECIMAL(3,1) DEFAULT NULL");
        $this->dbforge->add_field("`colds_0_tmp`         DECIMAL(3,1) DEFAULT NULL");
        $this->dbforge->add_field("`colds_1_tmp`         DECIMAL(3,1) DEFAULT NULL");

        $this->dbforge->add_field("`indoor_hum`          TINYINT(3) DEFAULT NULL");
        $this->dbforge->add_field("`outdoor_hum`         TINYINT(3) DEFAULT NULL");

        $this->dbforge->add_field("`colds_0_on`         TINYINT(1) DEFAULT NULL");
        $this->dbforge->add_field("`colds_1_on`         TINYINT(1) DEFAULT NULL");
        $this->dbforge->add_field("`fan_0_on`           TINYINT(1) DEFAULT NULL");
        $this->dbforge->add_field("`colds_box_on`       TINYINT(1) DEFAULT NULL");

        $this->dbforge->add_field("`power_main`         INT(4) DEFAULT NULL");
        $this->dbforge->add_field("`power_dc`           INT(4) DEFAULT NULL");

        $this->dbforge->add_field("`energy_main`        DECIMAL(10,2) DEFAULT NULL");
        $this->dbforge->add_field("`energy_dc`          DECIMAL(10,2) DEFAULT NULL");

        $this->dbforge->add_field("`create_time`        datetime NOT NULL DEFAULT '0000-00-00 00:00:00'");

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('datas');
        //$this->db->query("ALTER TABLE  `datas` ADD INDEX station_time (  `station_id` ,  `create_time` ) ;");

        $this->dbforge->rename_table('temperatures', 'bak_temperatures');
        $this->dbforge->rename_table('humidities', 'bak_humidities');
        $this->dbforge->rename_table('switchons', 'bak_switchons');
        $this->dbforge->rename_table('powers', 'bak_powers');
        $this->dbforge->rename_table('energies', 'bak_energies');
        
    }


    public function down()
    {
        $this->dbforge->drop_table('datas');
        $this->dbforge->rename_table('bak_temperatures', 'temperatures');
        $this->dbforge->rename_table('bak_humidities', 'humidities');
        $this->dbforge->rename_table('bak_switchons', 'switchons');
        $this->dbforge->rename_table('bak_powers', 'powers');
        $this->dbforge->rename_table('bak_energies', 'energies');
    }

}
