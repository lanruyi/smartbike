<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_esgconf_workpoint extends CI_Migration {

    public function up()
    {
        $fields = array("`colds_box_workpoint`   tinyint(2) DEFAULT NULL",
                        "`colds_box_worksens`    tinyint(2) DEFAULT NULL");
        $this->dbforge->add_column('esgconfs', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('esgconfs', 'colds_box_workpoint');
        $this->dbforge->drop_column('esgconfs', 'colds_box_worksens');
    }

}

