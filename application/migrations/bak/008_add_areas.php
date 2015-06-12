<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_areas extends CI_Migration {


    public function up()
    {
        $this->dbforge->add_field("`id`               INT(10) UNSIGNED NOT NULL AUTO_INCREMENT");
        $this->dbforge->add_field("`name_chn`         VARCHAR(50) DEFAULT NULL");
        $this->dbforge->add_field("`name_py`         VARCHAR(50) DEFAULT NULL");
        $this->dbforge->add_field("`weather_code`     VARCHAR(20) DEFAULT NULL");
        $this->dbforge->add_field("`type`             INT(4) UNSIGNED DEFAULT '0' NOT NULL");

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('areas');

        $fields = array("`city_id`      int(10) DEFAULT NULL", 
                        "`address_chn`  VARCHAR(250) NOT NULL DEFAULT ''");
        $this->dbforge->add_column('stations', $fields);
    }

    public function down()
    {
        
    }

}

?>
