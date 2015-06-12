<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_esg_commands extends CI_Migration {

    public function up(){
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `esg_commands` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `esg_id` int(10) unsigned NOT NULL DEFAULT '0',
			  `command` varchar(50) DEFAULT NULL,
			  `arg` varchar(2048) DEFAULT NULL,
			  `status` tinyint(1) NOT NULL DEFAULT '0',
			  `user_id` int(10) unsigned DEFAULT NULL,
			  `create_time` datetime DEFAULT '0000-00-00 00:00:00',
			  PRIMARY KEY (`id`),
			  KEY `esg_cmd_status` (`esg_id`,`status`)
            ) 
        ");
    }


    public function down()
    {
        $this->dbforge->drop_table('esg_commands');
    }

}
