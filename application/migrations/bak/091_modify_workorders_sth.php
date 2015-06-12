<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Modify_workorders_sth extends CI_Migration {


    public function up()
    {
        $this->db->query("alter table work_orders 
            change content creator_remark text,
            change remark dispatcher_remark text,
            add status tinyint(3) default 1,
            add is_repaired tinyint(2) default 1,
            add creator_repair_remark text,
            change category third_party tinyint(2) default 1");
    }


    public function down()
    {
        $this->db->query("alter table work_orders
            change creator_remark content  text,
            change dispatcher_remark remark  text,
            drop column status,
            drop column is_repaired,
            drop column creator_repair_remark,
            change third_party category tinyint(2) default 1");
    }

}

