<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_sysconfig extends CI_Migration {


    public function up()
    {
        $this->dbforge->add_field("`id`                   INT(10) UNSIGNED NOT NULL AUTO_INCREMENT");
        $this->dbforge->add_field("`sys_status` 		  TINYINT(1) DEFAULT '1'");

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('sysconfig');
		
		$data = array('sys_status'=>'1');
		$this->db->insert('sysconfig',$data);
    }

    public function down()
    {
        $this->dbforge->drop_table('sysconfig');
    }

}

?>