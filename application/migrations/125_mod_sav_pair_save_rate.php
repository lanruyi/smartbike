<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Mod_sav_pair_save_rate extends CI_Migration {

    public function up()
    {
        $this->db->query("alter table savpairs modify save_rate decimal(9,6) not null");
    }
    
    public function down()
    {
    }


}

?>
