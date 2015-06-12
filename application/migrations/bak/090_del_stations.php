<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Del_stations extends CI_Migration {


    public function up()
    {
        $this->db->query("alter table stations DROP COLUMN work_order_status");

    }


    public function down()
    {
    }

}

