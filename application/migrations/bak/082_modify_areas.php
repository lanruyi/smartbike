<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Modify_areas extends CI_Migration {


    public function up()
    {
        $this->db->query("alter table areas add `lng` varchar(20) default null,add `lat` varchar(20) default null");
    }


    public function down()
    {
       $this->dbforge->drop_column('areas'); 
    }

}











