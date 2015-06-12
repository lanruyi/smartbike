<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_esg_param extends CI_Migration {

    public function up()
    {


        $sql = " CREATE TABLE IF NOT EXISTS `agingdatas` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `esg_id` int(10) unsigned NOT NULL DEFAULT '0',
              `indoor_tmp` decimal(3,1) DEFAULT NULL,
              `outdoor_tmp` decimal(3,1) DEFAULT NULL,
              `box_tmp` decimal(3,1) DEFAULT NULL,
              `colds_0_tmp` decimal(3,1) DEFAULT NULL,
              `colds_1_tmp` decimal(3,1) DEFAULT NULL,
              `indoor_hum` tinyint(3) DEFAULT NULL,
              `outdoor_hum` tinyint(3) DEFAULT NULL,
              `colds_0_on` tinyint(1) DEFAULT NULL,
              `colds_1_on` tinyint(1) DEFAULT NULL,
              `fan_0_on` tinyint(1) DEFAULT NULL,
              `colds_box_on` tinyint(1) DEFAULT NULL,
              `power_main` int(4) DEFAULT NULL,
              `power_dc` int(4) DEFAULT NULL,
              `energy_main` decimal(10,2) DEFAULT NULL,
              `energy_dc` decimal(10,2) DEFAULT NULL,
              `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
              PRIMARY KEY (`id`),
              KEY `station_time` (`esg_id`,`create_time`)
            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;";

        $this->db->query($sql);
        $fields = array("`aging_start_time`     DATETIME DEFAULT NULL",
                        "`aging_stop_time`      DATETIME DEFAULT NULL",
                        "`aging_report`         text DEFAULT NULL");
        $this->dbforge->add_column('esgs', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_table('agingdatas');
        $this->dbforge->drop_column('esgs', 'aging_report');
        $this->dbforge->drop_column('esgs', 'aging_start_time');
        $this->dbforge->drop_column('esgs', 'aging_stop_time');
    }

}
