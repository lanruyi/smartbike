
<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_uniqe_area_name_chn extends CI_Migration {

    public function up()
    {
        $this->db->query("ALTER TABLE  `esdata`.`areas` ADD UNIQUE ( `name_chn`)");
    }

    public function down()
    {
    }
}
