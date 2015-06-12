<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_edge extends CI_Migration {

    public function up()
    {
        $this->db->query(" CREATE TABLE `edges` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `name_chn` varchar(20) NOT NULL,
              `edge_desc` text NOT NULL,
              `query` text NOT NULL,
              `time_slot` varchar(200) NOT NULL,
              `threshold` int(10) NOT NULL,
              `last_query_time` datetime DEFAULT NULL,
              `station_nums` int(11) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");
        $this->db->query(" CREATE TABLE `station_edges` (
              `station_id` int(11) NOT NULL,
              `edge_id` int(11) NOT NULL,
              `nums` int(11) NOT NULL
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8; ");

    }

    public function down()
    {
        $this->dbforge->drop_table('edges');
        $this->dbforge->drop_table('station_edges');
    }

}
