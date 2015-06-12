<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Mod_station_state_2_status extends CI_Migration {


    public function up()
    {
        $this->db->query("alter table stations drop column `station_state`");
        $this->db->query("alter table stations drop column `display_state`");
        $this->db->query("alter table stations drop column `under_construct`");
        $this->db->query("alter table stations drop column `warning_num`");

    }


    public function down()
    {
        $this->db->query("alter table stations add column `station_state` tinyint(2) not null default 1");
        $this->db->query("alter table stations add column `display_state` tinyint(2) not null default 1");
        $this->db->query("alter table stations add column `under_construct` tinyint(2) not null default 1");
        $this->db->query("alter table stations add column `warning_num` tinyint(2) not null default 1");
    }

}

