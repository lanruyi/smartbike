<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Usergroup extends CI_Migration {


    public function up()
    {
        $this->dbforge->add_field("`id`               INT(10) UNSIGNED NOT NULL AUTO_INCREMENT");
        $this->dbforge->add_field("`name_chn`         VARCHAR(50) DEFAULT NULL");

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('usergroups');

        // $fields = array("`usergroup_id`      int(10) DEFAULT NULL");
        // $this->dbforge->add_column('users', $fields);
    }

    public function down()
    {
         $this->dbforge->drop_table('usergroups');
         // $this->dbforge->drop_column('users', 'usergroup_id');
    }

}

?>
