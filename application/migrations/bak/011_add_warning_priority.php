<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_warning_priority extends CI_Migration {


    public function up()
    {
        $fields = array("`priority`   tinyint(2) not null DEFAULT 0"); 
        $this->dbforge->add_column('warnings', $fields);
    }

    public function down()
    {
        
    }

}

?>
