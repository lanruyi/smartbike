<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_test_user extends CI_Migration {


    public function up(){
        $query = $this->db->query("select * from users where username='test'");
        if(count($query->result_array())){
            $this->db->query("delete from users where username='test'");
        }
        $this->db->query("INSERT INTO `users` (`username`, `password`, `activated`,`email`,`last_ip`) VALUES ('test', 'fe01ce2a7fbac8fafaed7c982a04e229', '1','','')");

        $query = $this->db->query("select * from users where username='demo'");
        if(count($query->result_array())){
            $this->db->query("delete from users where username='demo'");
        }
        $this->db->query("INSERT INTO `users` (`username`, `password`, `activated`,`email`,`last_ip`) VALUES ('demo', 'fe01ce2a7fbac8fafaed7c982a04e229', '1','','')");
    }

    public function down()
    {
        $this->db->query("delete from users where username='test'");
        $this->db->query("delete from users where username='demo'");
    }

}



