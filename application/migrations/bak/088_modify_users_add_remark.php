<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Modify_users_add_remark extends CI_Migration {


    public function up()
    {
        $this->db->query("alter table users add `remark` text NOT NULL");

    }


    public function down()
    {
    }

}

