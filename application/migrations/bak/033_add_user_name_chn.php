<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_user_name_chn extends CI_Migration {

    public function up()
    {

        $fields = array("`name_chn`         VARCHAR(50) NOT NULL DEFAULT '匿名'",
                        "`usergroup_id`     INT(10) DEFAULT NULL");
        $this->dbforge->add_column('users', $fields);

        $this->dbforge->drop_column('users', 'ban_reason');
        $this->dbforge->drop_column('users', 'new_password_key');
        $this->dbforge->drop_column('users', 'new_password_requested');
        $this->dbforge->drop_column('users', 'new_email');
        $this->dbforge->drop_column('users', 'new_email_key');
        $this->dbforge->drop_column('users', 'stagroup_id');

        

    }

    public function down()
    {
        $this->dbforge->drop_column('users', 'name_chn');
    }

}

