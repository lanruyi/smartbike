<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Change_tmp_num extends CI_Migration {

    public function up()
    {

        $fields = array("`num` `num` DECIMAL(3,1) DEFAULT NULL");
        $this->dbforge->modify_column("temperatures",$fields);
    }

    public function down()
    {
        $fields = array("`num` `num` TINYINT(2) DEFAULT NULL");
        $this->dbforge->modify_column("temperatures",$fields);
    }

}

