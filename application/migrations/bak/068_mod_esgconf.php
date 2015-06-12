<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Mod_esgconf extends CI_Migration {

    public function up()
    {
        $fields = array("`highest_colds_temp` `highest_colds_temp` DECIMAL(10,2) DEFAULT NULL", 
                        "`highest_indoor_tmp` `highest_indoor_tmp` DECIMAL(10,2) DEFAULT NULL", 
                        "`highest_indoor_hum` `highest_indoor_hum` DECIMAL(10,2) DEFAULT NULL", 
                        "`highest_box_tmp`    `highest_box_tmp`    DECIMAL(10,2) DEFAULT NULL", 
                        "`ch_tmp`             `ch_tmp`             DECIMAL(10,2) DEFAULT NULL", 
                        "`cd_tmp`             `cd_tmp`             DECIMAL(10,2) DEFAULT NULL", 
                        "`fan0_new_tmp_step`  `fan0_new_tmp_step`  DECIMAL(10,2) DEFAULT NULL", 
                        "`hh_tmp`             `hh_tmp`             DECIMAL(10,2) DEFAULT NULL", 
                        "`hd_tmp`             `hd_tmp`             DECIMAL(10,2) DEFAULT NULL");

        $this->dbforge->modify_column("esgconfs",$fields);
    }

    public function down()
    {
    }

}

