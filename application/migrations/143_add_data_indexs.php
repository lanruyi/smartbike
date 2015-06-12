<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_data_indexs extends CI_Migration {

    public function up(){
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `data_indexs` (
              `id` smallint(11) NOT NULL,
              `from` date NOT NULL,
              `to` date NOT NULL,
              `project_id` int(11) NOT NULL,
              `table` varchar(255) NOT NULL,
              PRIMARY KEY (`id`)
            ) 
        ");
    }


    public function down()
    {
        $this->dbforge->drop_table('data_indexs');
    }

}
