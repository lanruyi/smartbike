<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_ope_type extends CI_Migration {

    public function up()
    {
        $this->db->query("
            alter table projects add column ope_type varchar(10) not null default 'common' comment '项目运营类型'
            ");
    }

    public function down()
    {
        $this->db->query("
            alter table projects drop column ope_type
            ");
    }

}




