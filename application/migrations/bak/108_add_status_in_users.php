<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_status_in_users extends CI_Migration {

    public function up()
    {
        $this->db->query("alter table users add column recycle tinyint(1) default 1");
    }

    public function down()
    {
        $this->db->query("alter table users drop column recycle");
    }

}
