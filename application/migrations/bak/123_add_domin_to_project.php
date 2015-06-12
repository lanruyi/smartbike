<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_domin_to_project extends CI_Migration {

    public function up()
    {
        $this->db->query("alter table projects add column domin varchar(50) default ''");
        $this->db->query("alter table projects drop column saving_func");
        $this->db->query("alter table monthdatas add column reason text NOT NULL default ''");
        $this->db->query("alter table savpairs drop column std_cspt_adjust");
    }

    public function down()
    {
        $this->db->query("alter table projects drop column domin");
        $this->db->query("alter table projects add column saving_func varchar(50)");
        $this->db->query("alter table monthdatas drop column reason");
        $this->db->query("alter table savpairs add column std_cspt_adjust decimal(6,2) not null default 0");
    }

}


