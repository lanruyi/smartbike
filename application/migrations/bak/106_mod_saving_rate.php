<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Mod_saving_rate extends CI_Migration {

    public function up()
    {
        $this->db->query("alter table savings change rate saving_rate decimal(6,4) default null");
    }
    
    public function down()
    {
        $this->db->query("alter table savings change saving_rate rate decimal(6,4) default null");
    }
}
