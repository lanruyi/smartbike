<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_station_equipment extends CI_Migration {

    public function up()
    {
        $fields = array("`equip_with_box`     			 tinyint(1) DEFAULT '1'",
						"`equip_with_outdoor_sensor`     tinyint(1) DEFAULT '1'");
        $this->dbforge->add_column('stations', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('stations', 'equip_with_box');
		$this->dbforge->drop_column('stations', 'equip_with_outdoor_sensor');
    }

}