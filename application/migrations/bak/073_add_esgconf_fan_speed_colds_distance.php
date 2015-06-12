<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_esgconf_fan_speed_colds_distance extends CI_Migration {

    public function up()
    {
        $fields = array("`fan_full_speed_duration`     varchar(50) DEFAULT NULL",
                        "`colds_onoff_distance`        decimal(10,1) DEFAULT NULL");
        $this->dbforge->add_column('esgconfs', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('esgconfs', 'fan_full_speed_duration');
        $this->dbforge->drop_column('esgconfs', 'colds_onoff_distance');
    }

}