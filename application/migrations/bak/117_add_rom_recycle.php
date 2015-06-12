<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_rom_recycle extends CI_Migration {

    public function up()
    {
        $this->db->query("alter table roms add column recycle tinyint(2) default 1");
    }

    public function down()
    {
        $this->dbforge->drop_column('roms', 'recycle');
    }

}

