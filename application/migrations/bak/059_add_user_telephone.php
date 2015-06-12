<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_user_telephone extends CI_Migration {

    public function up()
    {
        $fields = array("`telephone`      varchar(20) DEFAULT NULL");
        $this->dbforge->add_column('users', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('users', 'telephone');
    }

}
