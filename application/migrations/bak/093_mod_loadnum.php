<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Mod_loadnum extends CI_Migration {

    public function up()
    {
        $this->db->query("alter table stations 
             modify load_num decimal(4,1) not null");
    }
    
    public function down()
    {
        $this->db->query("alter table stations 
             modify load_num int(10) not null");
    }
}
