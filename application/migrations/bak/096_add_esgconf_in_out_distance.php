<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_esgconf_in_out_distance extends CI_Migration {

    public function up()
    {
        $fields = array("`in_out_distance`     tinyint(2) DEFAULT NULL");
        $this->dbforge->add_column('esgconfs', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('esgconfs', 'in_out_distance');
    }

}
