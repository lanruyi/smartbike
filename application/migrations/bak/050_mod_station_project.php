<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Mod_station_project extends CI_Migration {


    public function up()
    {
        $fields = array("`project_id`    `project_id` int(10) DEFAULT NULL");
        $this->dbforge->modify_column("stations",$fields);      
    }


    public function down()
    {
    }

}

?>
