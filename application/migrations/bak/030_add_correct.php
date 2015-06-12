<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_correct extends CI_Migration {


    public function up()
    {
        $this->dbforge->add_field("`id`              INT(10) UNSIGNED NOT NULL AUTO_INCREMENT");
        $this->dbforge->add_field("`station_id`      INT(10) UNSIGNED NOT NULL");
        $this->dbforge->add_field("`org_num`         DECIMAL(10,2) DEFAULT NULL");
        $this->dbforge->add_field("`correct_num`     DECIMAL(10,2) DEFAULT NULL");
        $this->dbforge->add_field("`type`            TINYINT(2) UNSIGNED DEFAULT '0' ");
        $this->dbforge->add_field("`time`            datetime DEFAULT '0000-00-00 00:00:00'");
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('corrects');
        
        $fields = array("`ac_main_correct_base`      DECIMAL(10,2) DEFAULT 0",
                        "`ac_main_correct_slope`     DECIMAL(6,5) DEFAULT 1");
        $this->dbforge->add_column('stations', $fields);

    }

    public function down()
    {
        $this->dbforge->drop_table('corrects');
        $this->dbforge->drop_column('stations', 'ac_main_correct_base');
        $this->dbforge->drop_column('stations', 'ac_main_correct_slope');
    }

}

?>
