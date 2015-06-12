<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_columns_in_agingdata extends CI_Migration {

    public function up()
    {
        $this->db->query("alter table agingdatas add column true_out_tmp	decimal(3,1) default null");
        $this->db->query("alter table agingdatas add column box_tmp_1       decimal(3,1) default null");
        $this->db->query("alter table agingdatas add column box_tmp_2       decimal(3,1) default null");
    }

    public function down()
    {
        $this->db->query("alter table agingdatas drop column true_out_tmp");
        $this->db->query("alter table agingdatas drop column box_tmp_1");
        $this->db->query("alter table agingdatas drop column box_tmp_2");
    }

}
