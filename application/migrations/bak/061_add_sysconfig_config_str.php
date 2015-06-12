<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_sysconfig_config_str extends CI_Migration {

    public function up()
    {
        $fields = array("`config_str`      text DEFAULT NULL");
        $this->dbforge->add_column('sysconfig', $fields);
        $this->dbforge->drop_column('sysconfig','sys_status');
    }

    public function down()
    {
        $this->dbforge->drop_column('sysconfig', 'config_str');
        $fields = array("`sys_status` 		  TINYINT(1) DEFAULT '1'");
        $this->dbforge->add_column('sysconfig',$fields);
    }

}


