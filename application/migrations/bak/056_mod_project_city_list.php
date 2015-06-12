<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Mod_project_city_list extends CI_Migration {


    public function up()
    {
        $fields = array("`city_list`   `city_list`    varchar(255) DEFAULT NULL");
        $this->dbforge->modify_column("projects",$fields);      
    }

    public function down()
    {
		$fields = array("``city_list`  `city_list`    varchar(10) DEFAULT NULL");
        $this->dbforge->modify_column("projects",$fields);         
    }

}


