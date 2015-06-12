<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_setting_update_time extends CI_Migration {

    public function up()
    {

        $fields = array("`rom_version`  varchar(50) DEFAULT NULL");
        $this->dbforge->add_column('stations', $fields);

        $fields = array("`command_id` `command_id`    INT(10) UNSIGNED DEFAULT NULL");
        $this->dbforge->modify_column("settings",$fields);

        $fields = array("`update_time`  datetime DEFAULT NULL");
        $this->dbforge->add_column('settings', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('stations', 'rom_version');
        $this->dbforge->drop_column('setting', 'update_time');
    }

}

