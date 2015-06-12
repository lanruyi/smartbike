
<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Mod_fan_id extends CI_Migration {

    public function up()
    {
        $fields = array(
            'fans_id' => array(
                'name' => 'fan_id',
                'type' => 'INT',
                'constraint' => 4,
                'unsigned' => TRUE,
                'default' => 0
            ),
        );
        $this->dbforge->modify_column('dfanon', $fields);


    }

    public function down()
    {
    }

}
