<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_data_index_archive extends CI_Migration {

    public function up()
    {
        $this->db->query("alter table data_indexs add column archive tinyint(1) not null default 1 comment '数据表存档'");
    }
    
    public function down()
    {
    	$this->db->query("alter table data_indexs drop column archive");
    }


}

