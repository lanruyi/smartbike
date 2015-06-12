<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_station_warnings_creator_id extends CI_Migration {

    public function up()
    {
        $fields = array("`warning_num`      INT(10) UNSIGNED DEFAULT NULL",
						"`creator_id`       INT(10) UNSIGNED DEFAULT NULL");
        $this->dbforge->add_column('stations', $fields);			
    }

    public function down()
    {
        $this->dbforge->drop_column('stations', 'warning_num');
		$this->dbforge->drop_column('stations', 'creator_id');
    }

}