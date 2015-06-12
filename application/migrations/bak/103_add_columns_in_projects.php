<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_columns_in_projects extends CI_Migration {

    public function up()
    {
        $this->db->query("alter table projects add column saving_func varchar(50) default null");
    }

    public function down()
    {
        $this->db->query("alter table projects drop column saving_func");
    }

}
