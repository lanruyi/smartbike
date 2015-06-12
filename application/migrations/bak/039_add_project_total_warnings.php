<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_project_total_warnings extends CI_Migration {

    public function up()
    {
        $fields = array("`total_warnings`      INT(10) UNSIGNED DEFAULT NULL");
        $this->dbforge->add_column('projects', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('projects', 'total_warnings');
    }

}