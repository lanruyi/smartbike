<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Change_setting_table extends CI_Migration {

    public function up()
    {
        $fields = array("`comment`  TEXT NOT NULL DEFAULT ''");
        $this->dbforge->add_column('stations', $fields);

        $fields = array("`lng`  VARCHAR(20) DEFAULT NULL",
                        "`lat`  VARCHAR(20) DEFAULT NULL",
                        "`colds_num` tinyint(2) NOT NULL DEFAULT '2'",
                        "`total_load` tinyint(2) NOT NULL DEFAULT '2'",

                        "`station_state` tinyint(2) NOT NULL DEFAULT '0'",
                        "`display_state` tinyint(2) NOT NULL DEFAULT '0'",
                        "`display_order` int(11) NOT NULL DEFAULT '0'",

                        "`pic_url`  VARCHAR(200) DEFAULT NULL",
                        "`last_connect_time` datetime DEFAULT NULL");
        $this->dbforge->add_column('stations', $fields);

        $fields = array("`varchar_value` `value`  VARCHAR(30) DEFAULT NULL");
        $this->dbforge->modify_column("setting_items",$fields);
        $this->dbforge->drop_column("setting_items","int_value");
    }

    public function down()
    {
    }

}

?>
