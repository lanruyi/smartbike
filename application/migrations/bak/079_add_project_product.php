<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_project_product extends CI_Migration {


    public function up()
    {
        $fields = array("`is_product`     tinyint(4) DEFAULT 1");
        $this->dbforge->add_column('projects', $fields);
		
		//$this->db->query("alter table projects add column is_product tinyint(1) not null default 1");
    }


    public function down()
    {
    }

}











