<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Change_authorities extends CI_Migration {

    public function up()
    {

        $fields = array("`authorities` `authorities` BINARY(20) NOT NULL DEFAULT ''");
        $this->dbforge->modify_column("roles",$fields);
    }

    public function down()
    {
    }

}

