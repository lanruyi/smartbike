<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_bug_arg extends CI_Migration {

    public function up()
    {
        $fields = array("`arg`     int(10) DEFAULT NULL");
        $this->dbforge->add_column('bugs', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('bugs', 'arg');
    }

}
