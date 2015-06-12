<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_price_to_station extends CI_Migration {

    public function up()
    {
        $this->db->query("alter table stations add column price decimal(5,3) default null");
    }

    public function down()
    {
        $this->db->query("alter table stations drop column price");
    }

}
