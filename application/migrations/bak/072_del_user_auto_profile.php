<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Del_user_auto_profile extends CI_Migration {

    public function up()
    {
        $this->db->query("drop table user_profiles");
        $this->db->query("drop table user_autologin");
        $this->dbforge->drop_column('station_exts','ampere');
    }

    public function down()
    {
    }

}

