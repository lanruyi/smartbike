
<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_column_in_stations extends CI_Migration {

    public function up()
    {
        $this->db->query("alter table stations add column have_box	tinyint(1) default 2");
        $this->db->query("update stations set have_box=1 where box_type=2");
    }

    public function down()
    {
        $this->db->query("alter table stations drop column have_box");
    }

}