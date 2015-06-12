<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_gprs_platform extends CI_Migration {

    public function up(){
        $this->db->query("alter table properties add column gprs_type varchar(50) default ''");
        $this->db->query("alter table properties add column platform  varchar(20) default ''");
    }


    public function down(){
        $this->db->query(" ALTER TABLE `properties` DROP column `gprs_type` ");
        $this->db->query(" ALTER TABLE `properties` DROP column `platform` ");
    }

}

