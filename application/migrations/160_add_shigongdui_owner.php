<?php  defined('BASEPATH') OR exit('No direct script access allowed');
class Migration_Add_shigongdui_owner extends CI_Migration {

    public function up(){
        $this->db->query("alter table stations add column shigongdui varchar(255) not null");
        $this->db->query("alter table stations add column owner      varchar(20)  not null");
    }

    public function down(){
        $this->db->query(" ALTER TABLE `stations` DROP column `shigongdui` ");
        $this->db->query(" ALTER TABLE `stations` DROP column `owner` ");
    }

}

