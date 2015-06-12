<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Mod_userlog extends CI_Migration {


    public function up()
    {
        $fields = array("`data`    `data` text DEFAULT NULL");
        $this->dbforge->modify_column("userlogs",$fields);      
    }


    public function down()
    {
    }

}
