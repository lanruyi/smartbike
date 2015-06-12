<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_note_openness extends CI_Migration {

    public function up()
    {
        $fields = array("`openness`      TINYINT(1) DEFAULT '1'");
        $this->dbforge->add_column('notes', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('notes', 'openness');
    }

}