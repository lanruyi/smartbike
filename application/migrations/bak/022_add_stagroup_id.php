<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_stagroup_id extends CI_Migration {

    public function up()
    {
        $fields = array("`stagroup_id`      int(10) DEFAULT NULL");
        $this->dbforge->add_column('users', $fields);
    }

    public function down()
    {
    }

}

