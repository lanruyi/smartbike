<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_warning_finish_type extends CI_Migration {


    public function up()
    {
        $fields = array("`finish_type` tinyint(1) NOT NULL DEFAULT 0",
                        "`update_time` datetime NOT NULL DEFAULT '0000-00-00'",
                        "`start_time`  datetime NOT NULL DEFAULT '0000-00-00'",
                        "`end_time`    datetime NOT NULL DEFAULT '0000-00-00'",
                        "`status`      tinyint(1) NOT NULL DEFAULT 0");
        $this->dbforge->add_column('warnings', $fields);
    }

    public function down()
    {

        
    }

}

?>
