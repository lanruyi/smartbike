<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_esgs_fixed extends CI_Migration {

    public function up()
    {
        $this->db->query("alter table esgs add column fixed tinyint(1) not null default 1 comment '固定ID'");
    }
    
    public function down()
    {
    	$this->db->query("alter table esgs drop column fixed");
    }


}

