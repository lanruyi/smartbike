<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_host_to_esgs extends CI_Migration {

    public function up()
    {
        $this->db->query("alter table esgs add column host varchar(50) not null default ''");
        $this->db->query("alter table esgs add column subsys tinyint(2) not null default 0");
    }

    public function down()
    {
        $this->db->query("alter table esgs drop column host");
        $this->db->query("alter table esgs drop column subsys");
    }

}

