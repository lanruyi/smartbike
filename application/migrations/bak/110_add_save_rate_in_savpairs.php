
<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_save_rate_in_savpairs extends CI_Migration {

    public function up()
    {
        $this->db->query("alter table savpairs add column save_rate decimal(4,2) default 0");
    }

    public function down()
    {
        $this->db->query("alter table savpairs drop column save_rate");
    }

}
