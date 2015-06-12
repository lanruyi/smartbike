<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_weather extends CI_Migration {


    public function up()
    {
        $this->dbforge->add_field("`id`               INT(10) UNSIGNED NOT NULL AUTO_INCREMENT");
        $this->dbforge->add_field("`city_id`          INT(10) UNSIGNED DEFAULT NULL");
        $this->dbforge->add_field("`day`              date NOT NULL DEFAULT '0000-00-00'");
        $this->dbforge->add_field("`high_tmp`         INT(2) UNSIGNED DEFAULT '0' NOT NULL");
        $this->dbforge->add_field("`low_tmp`          INT(2) UNSIGNED DEFAULT '0' NOT NULL");
        $this->dbforge->add_field("`weather`          VARCHAR(50) DEFAULT NULL");
        $this->dbforge->add_field("`fx`               VARCHAR(50) DEFAULT NULL");
        $this->dbforge->add_field("`type`             INT(1) UNSIGNED DEFAULT '0' NOT NULL");

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('weathers');
    }

    public function down()
    {
        
    }

}

?>
