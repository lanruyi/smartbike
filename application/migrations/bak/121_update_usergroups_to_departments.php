<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_update_usergroups_to_departments extends CI_Migration {

    public function up()
    {
        $this->db->query("RENAME TABLE  usergroups TO  departments");
        $this->db->query("alter table departments add column role_id int(10) default 0");
    }

    public function down()
    {
        $this->db->query("alter table departments drop column role_id");
        $this->db->query("RENAME TABLE  departments TO  usergroups");
    }

}
