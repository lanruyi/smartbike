<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_project_city_list extends CI_Migration {


    public function up()
    {
        $fields = array("`city_list`      varchar(10) DEFAULT NULL");
        $this->dbforge->add_column('projects', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('projects', 'city_list');
    }

}
