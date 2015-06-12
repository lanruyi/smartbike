<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Del_station_ext extends CI_Migration {


    public function up()
    {
        $this->db->query("drop table station_exts");

    }


    public function down()
    {
    }

}

