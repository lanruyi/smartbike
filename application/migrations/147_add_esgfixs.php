<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_esgfixs extends CI_Migration {

    public function up(){
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `esgfixs` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `station_id` int(11) NOT NULL,
              `esg_id` int(11) NOT NULL,
              `esg_ver` tinyint(2) NOT NULL,
              `new_esg_id` int(11) NOT NULL,
              `new_esg_ver` tinyint(2) NOT NULL,
              `reason` varchar(200) NOT NULL default '',
              `other_reason` varchar(200) NOT NULL default '',
              `datetime` datetime default '2012-01-01',
              `user_id` int(11) default NULL,
              PRIMARY KEY (`id`)
            ) 
        ");
    }

    public function down()
    {
        $this->dbforge->drop_table('esgfixs');
    }

}

