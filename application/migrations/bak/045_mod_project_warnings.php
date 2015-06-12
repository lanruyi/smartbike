<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Mod_project_warnings extends CI_Migration {


    public function up()
    {
        $fields = array("`total_warnings` `total_warnings` VARCHAR(255) DEFAULT NULL");
        $this->dbforge->modify_column("projects",$fields);      
    }

    public function down()
    {
		$fields = array("`total_warnings` `total_warnings` INT(10) UNSIGNED DEFAULT NULL");
        $this->dbforge->modify_column("projects",$fields);         
    }

}

?>