<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_blog_type extends CI_Migration {


    public function up()
    {
		  //$this->db->query("alter table blogs add blog_type tinyint(2)  default null");
		$fields=array("`blog_type`     tinyint(2) DEFAULT NULL");
		//Ìí¼ÓÒ»¸öblog_type×Ö¶Î
		$this->dbforge->add_column('blogs',$fields);
		
    }


    public function down()
    {
		$this->dbforge->drop_column('blogs');
    }

}











