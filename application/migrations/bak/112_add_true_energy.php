<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_true_energy extends CI_Migration {

    public function up()
    {
        $this->db->query("alter table monthdatas add column true_energy decimal(7,2) default null");
    }

    public function down()
    {
        $this->db->query("alter table monthdatas drop column true_energy");
    }

}
