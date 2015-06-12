<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_mod_usergroup_id extends CI_Migration {

    public function up()
    {
        $this->db->query("alter table users change usergroup_id department_id int(10) DEFAULT NULL");
    }

    public function down()
    {
        $this->db->query("alter table users change department_id usergroup_id int(10) DEFAULT NULL");
    }

}
