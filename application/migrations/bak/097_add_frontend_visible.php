<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_frontend_visible extends CI_Migration {

    public function up()
    {
        $fields = array('frontend_visible' => array(
                                                'type'=>'tinyint(2)',
                                                'default'=>1
                                                ));
        $this->dbforge->add_column('stations', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('stations', 'frontend_visible');
    }

}
