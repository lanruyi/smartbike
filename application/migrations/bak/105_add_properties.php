<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_properties extends CI_Migration {

    public function up() {
        $query = $this->db->query("
            CREATE TABLE `properties` (
             `id` int(11) NOT NULL AUTO_INCREMENT,
             `esg_id` int(11) NOT NULL,
             `station_id` int(11) NOT NULL,
             `rom_version` varchar(20) DEFAULT NULL,
             `es_main_bd_ver` varchar(10) DEFAULT NULL,
             `es_ext_bd_ver` varchar(10) DEFAULT NULL,
             `outdoor_ts_ver` varchar(10) DEFAULT NULL,
             `indoor_ts_ver` varchar(10) DEFAULT NULL,
             `colds_0_ts_ver` varchar(10) DEFAULT NULL,
             `colds_1_ts_ver` varchar(10) DEFAULT NULL,
             `box_1_ts_ver` varchar(10) DEFAULT NULL,
             `box_2_ts_ver` varchar(10) DEFAULT NULL,
             `up_time` int(11) DEFAULT NULL,
             `update_time` datetime DEFAULT NULL,
             PRIMARY KEY (`id`)
            )
        ");
    }

    public function down() {
        $query = $this->db->query("drop table properties");
    }
}
