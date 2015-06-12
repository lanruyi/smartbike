<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_userlog_project_id extends CI_Migration {

    public function up()
    {
        $fields = array("`project_id`      INT(10) UNSIGNED DEFAULT NULL");
        $this->dbforge->add_column('userlogs', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('userlogs', 'project_id');
    }

}