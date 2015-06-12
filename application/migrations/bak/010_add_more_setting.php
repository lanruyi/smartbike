<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_more_setting extends CI_Migration {

    public function up()
    {

        $fields = array(
            "`ch_tmp`     INT(10) UNSIGNED DEFAULT NULL",
            "`cd_tmp`     INT(10) UNSIGNED DEFAULT NULL",
            "`fan0_new_tmp_step`    INT(10) UNSIGNED DEFAULT NULL",
            "`hh_tmp` INT(10) UNSIGNED DEFAULT NULL",
            "`hd_tmp` INT(10) UNSIGNED DEFAULT NULL");
            //$this->dbforge->add_field("`ch_tmp`     INT(10) UNSIGNED DEFAULT NULL");
            //$this->dbforge->add_field("`cd_tmp`     INT(10) UNSIGNED DEFAULT NULL");
            //$this->dbforge->add_field("`fan0_new_tmp_step`    INT(10) UNSIGNED DEFAULT NULL");
            //$this->dbforge->add_field("`hh_tmp` INT(10) UNSIGNED DEFAULT NULL");
            //$this->dbforge->add_field("`hd_tmp` INT(10) UNSIGNED DEFAULT NULL");
        $this->dbforge->add_column("setting",$fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('setting', 'ch_tmp');
        $this->dbforge->drop_column('setting', 'cd_tmp');
        $this->dbforge->drop_column('setting', 'fan0_new_tmp_step');
        $this->dbforge->drop_column('setting', 'hh_tmp');
        $this->dbforge->drop_column('setting', 'hd_tmp');
    }

}

?>
