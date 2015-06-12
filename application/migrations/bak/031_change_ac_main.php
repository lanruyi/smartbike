<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Change_ac_main extends CI_Migration {


    public function up()
    {
        $this->dbforge->drop_column('stations', 'ac_main_correct_base');
        $this->dbforge->drop_column('stations', 'ac_main_correct_slope');
        $fields = array("`main_energy_base`              DECIMAL(10,2) DEFAULT 0",
                        "`main_energy_correct_base`      DECIMAL(10,2) DEFAULT 0",
                        "`main_energy_slope`             DECIMAL(6,5) DEFAULT 1");
        $this->dbforge->add_column('stations', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('stations', 'main_energy_correct_base');
        $this->dbforge->drop_column('stations', 'main_energy_correct_slope');
        $fields = array("`ac_main_correct_base`      DECIMAL(10,2) DEFAULT 0",
                        "`ac_main_correct_slope`     DECIMAL(6,5) DEFAULT 1");
        $this->dbforge->add_column('stations', $fields);
    }

}

?>
