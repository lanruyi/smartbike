<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_cmail_time_consume extends CI_Migration {

    public function up()
    {
        $fields = array("`time_consume`     INT(10) UNSIGNED DEFAULT NULL");
        $this->dbforge->add_column('cmails', $fields);				
    }

    public function down()
    {
		$this->dbforge->drop_column('cmails', 'time_consume');
    }

}