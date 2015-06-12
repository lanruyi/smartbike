<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Modify_work_orders_add_category_add_remark_remove_bug_type_ids extends CI_Migration {


    public function up()
    {
        $this->db->query("alter table work_orders add `remark` text NOT NULL,add category tinyint(3) default 1,DROP COLUMN bug_type_ids");

    }


    public function down()
    {
    }

}

