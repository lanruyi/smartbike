<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Mod_station_box_type extends CI_Migration {


    public function up()
    {
        $fields = array("`equip_with_box`    `box_type` tinyint(1) DEFAULT '1'");
        $this->dbforge->modify_column("stations",$fields);      
    }


    public function down()
    {
        $fields = array("`box_type`    `equip_with_box` tinyint(1) DEFAULT '1'");
        $this->dbforge->modify_column("stations",$fields);
    }

}











