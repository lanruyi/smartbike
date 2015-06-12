<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_stage_to_station extends CI_Migration {

    public function up()
    {
        $this->db->query("alter table stations add column stage tinyint(2) default 1");
    }

    public function down()
    {
        $this->db->query("alter table stations drop column stage");
    }

}
