<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_table_savtablecaches extends CI_Migration {

    public function up() {
        $query = $this->db->query("


CREATE TABLE IF NOT EXISTS `savtablecaches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `city_id` smallint(6) NOT NULL,
  `datetime` datetime NOT NULL,
  `has_zhuan_saving` tinyint(1) not null default 0,
  `has_ban_saving` tinyint(1) not null default 0,
  `has_zhuan_common` tinyint(1) not null default 0,
  `has_ban_common` tinyint(1) not null default 0,
  `has_final` tinyint(1) not null default 0,
  `zhuan_saving` text,
  `ban_saving` text,
  `zhuan_common` text,
  `ban_common` text,
  `final` text,
  PRIMARY KEY (`id`)
)
        ");
    }

    public function down() {
        $query = $this->db->query("drop table savtablecaches");
    }
}
