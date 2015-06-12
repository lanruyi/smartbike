<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_station_columns extends CI_Migration {

    public function up()
    {
        $fields = array("`new_station_key`  varchar(250) DEFAULT NULL",
                        "`ac_revise_base`   int(12) NOT NULL DEFAULT 0",
                        "`ac_revise`        DECIMAL(6,5) NOT NULL DEFAULT 1");
        $this->dbforge->add_column('stations', $fields);

        $fields = array("`org_num`          DECIMAL(10,2) DEFAULT NULL");
        $this->dbforge->add_column('energies', $fields);
    }

    public function down()
    {
                
    }

}

