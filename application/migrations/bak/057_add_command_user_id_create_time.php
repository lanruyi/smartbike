<?php
class Migration_Add_command_user_id_create_time extends CI_Migration {

    public function up()
    {
        $fields = array("`user_id`      INT(10) UNSIGNED DEFAULT NULL",
                        "`create_time`  DATETIME DEFAULT '0000-00-00 00:00:00'");
        $this->dbforge->add_column('commands', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('commands', 'user_id');
        $this->dbforge->drop_column('commands', 'create_time');
    }

}
