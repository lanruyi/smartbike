<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_esg_aging extends CI_Migration {

    public function up()
    {
        $fields = array("`aging_status`      TINYINT(1) DEFAULT '0'");
        $this->dbforge->add_column('esgs', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('esgs', 'aging_status');
    }

}
