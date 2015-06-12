<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_roles extends CI_Migration {


    public function up()
    {
        $this->dbforge->add_field("`id`               INT(10) UNSIGNED NOT NULL AUTO_INCREMENT");
        $this->dbforge->add_field("`name_chn`         VARCHAR(50) DEFAULT NULL");
        $this->dbforge->add_field("`authorities`      INT(12) UNSIGNED DEFAULT '0' NOT NULL");

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('roles');

        $fields = array("`role_id`      int(10) DEFAULT NULL");
        $this->dbforge->add_column('users', $fields);
    }

    public function down()
    {
         
    }

}

?>
