<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_project_type extends CI_Migration {

    public function up()
    {
        $fields = array("`type`     tinyint(1) DEFAULT '1'");
        $this->dbforge->add_column('projects', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('projects', 'type');
    }

}