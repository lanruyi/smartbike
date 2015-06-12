<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_user_current_city_id extends CI_Migration {

    public function up()
    {
        $fields = array("`default_city_id`      int(10) DEFAULT NULL");
        $this->dbforge->add_column('users', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('users', 'default_city_id');
    }

}