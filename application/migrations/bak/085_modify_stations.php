<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Modify_stations extends CI_Migration {


    public function up()
    {
        $this->db->query("
          alter table stations modify bug_point smallint not null default 0;
            ");

    }


    public function down()
    {
    }

}

