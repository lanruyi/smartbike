<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Mod_esgconf_3 extends CI_Migration {

    public function up()
    {
        $fields = array("`fan0_new_tmp_step`  `all_close_temp`          DECIMAL(10,2) DEFAULT NULL", 
                        "`hh_tmp`             `temp_adjust_factor`      DECIMAL(10,2) DEFAULT NULL", 
                        "`hd_tmp`             `fan_min_time`            DECIMAL(10,2) DEFAULT NULL");

        $this->dbforge->modify_column("esgconfs",$fields);
    }

    public function down()
    {
        $fields = array("`all_close_temp`      `fan0_new_tmp_step`      DECIMAL(10,2) DEFAULT NULL", 
                        "`temp_adjust_factor`  `hh_tmp`                 DECIMAL(10,2) DEFAULT NULL", 
                        "`fan_min_time`        `hd_tmp`                 DECIMAL(10,2) DEFAULT NULL");

        $this->dbforge->modify_column("esgconfs",$fields);
    }

}

