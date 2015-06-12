<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_column_in_savpairs extends CI_Migration {

    public function up()
    {
        $this->db->query("alter table savpairs add column std_cspt_adjust decimal(6,2) default 0.00");
    }

    public function down()
    {
        $this->db->query("alter table savpairs drop column std_cspt_adjust");
    }

}
