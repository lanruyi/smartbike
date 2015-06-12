<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_rom_update extends CI_Migration {

    public function up() {
        $query = $this->db->query("

CREATE TABLE IF NOT EXISTS `rom_updates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `station_id` int(11) NOT NULL,
  `old_rom_id` int(11) DEFAULT NULL,
  `new_rom_id` int(11) NOT NULL,
  `part_num` smallint(6) NOT NULL,
  `start_time` datetime NOT NULL,
  `down_time` datetime DEFAULT NULL,
  `stop_time` datetime DEFAULT NULL,
  `current_part_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `finish` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) 

        ");
    }

    public function down() {
        $query = $this->db->query("drop table rom_updates");
    }
}
