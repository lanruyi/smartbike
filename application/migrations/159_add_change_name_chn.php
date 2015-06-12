<?php  defined('BASEPATH') OR exit('No direct script access allowed');
class Migration_Add_change_name_chn extends CI_Migration {

    public function up(){
        $this->db->query("alter table stations add column change_name_chn varchar(20) not null");
    }


    public function down(){
        $this->db->query(" ALTER TABLE `stations` DROP column `change_name_chn` ");
    }

}

