<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Modify_workorders_modify_sth extends CI_Migration {


    public function up()
    {
        $this->db->query("
          ALTER TABLE work_orders DROP COLUMN dispatcher_tel,DROP COLUMN status,add is_history tinyint(3) default 1
            ");

    }


    public function down()
    {
    }

}

