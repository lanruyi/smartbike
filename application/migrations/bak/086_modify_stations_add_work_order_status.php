<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Modify_stations_add_work_order_status extends CI_Migration {


    public function up()
    {
        $this->db->query("
          ALTER TABLE stations add work_order_status tinyint(3) default 1
            ");

    }


    public function down()
    {
    }

}

