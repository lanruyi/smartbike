<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_project_config_str extends CI_Migration {

    public function up()
    {
        $fields = array("`config_str`      text DEFAULT NULL");
        $this->dbforge->add_column('projects', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('projects', 'config_str');
    }

}

