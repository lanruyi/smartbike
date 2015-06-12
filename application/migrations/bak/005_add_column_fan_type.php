<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_column_fan_type extends CI_Migration {

    public function up()
    {
        $fields = array("`fan_type` tinyint(2) NOT NULL DEFAULT '0'",
                        "`building` tinyint(2) NOT NULL DEFAULT '0'",
                        "`colds_0_type` int(4) NOT NULL DEFAULT '0'",
                        "`colds_1_type` int(4) NOT NULL DEFAULT '0'");
        $this->dbforge->add_column('stations', $fields);
    }

    public function down()
    {
                
    }

}

?>
