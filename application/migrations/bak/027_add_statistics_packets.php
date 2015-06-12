<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_statistics_packets extends CI_Migration {

    public function up()
    {
        $fields = array("`packets`      INT(10) DEFAULT NULL");
        $this->dbforge->add_column('statisticses', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('statisticses', 'packets');
    }

}

