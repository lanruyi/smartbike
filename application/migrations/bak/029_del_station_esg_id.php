<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Del_station_esg_id extends CI_Migration {


    public function up(){
        $this->dbforge->drop_column('stations', 'esg_id');
    }

    public function down(){
        $fields = array("`esg_id`     int(10) DEFAULT NULL ");
        $this->dbforge->add_column('stations', $fields);
    }

}

?>
