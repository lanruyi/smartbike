<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Mod_esgconf_r3 extends CI_Migration {

    public function up()
    {
        $this->db->query("alter table esgconfs change update_fixed_datetime  fan_sampling_last_time int(10) DEFAULT NULL");
        $this->db->query("alter table esgconfs change sample_duration        base_day_ac_temp       int(10) DEFAULT NULL");
        $this->db->query("alter table esgconfs change sample_fixed_datetime  energy_saving_ac_temp  int(10) DEFAULT NULL");
        


    }
    
    public function down()
    {
    }
}
