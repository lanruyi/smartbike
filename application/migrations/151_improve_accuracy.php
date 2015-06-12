<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Improve_accuracy extends CI_Migration {

    public function up()
    {
        $this->db->query("ALTER TABLE  `savpairdatas` CHANGE  `rate`  `rate` DECIMAL( 12, 11 ) NOT NULL");
        $this->db->query("ALTER TABLE  `savpairs` CHANGE  `save_rate`  `save_rate` DECIMAL( 12, 11 ) NOT NULL");
    }

    public function down()
    {
    }

}




