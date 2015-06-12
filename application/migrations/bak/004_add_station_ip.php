
<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_station_ip extends CI_Migration {

    public function up()
    {
        $fields = array(
            'ip' => array(
                'type' => 'VARCHAR',
                'constraint' => '16',
            ),
            'alive' => array(
                'type' => 'INT',
                'constraint' => 2,
                'unsigned' => TRUE,
                'default' => 0
            )
        );
        $this->dbforge->add_column("station",$fields);

    }

    public function down()
    {
        $this->dbforge->drop_column('station', 'ip');
        $this->dbforge->drop_column('station', 'alive');
    }

}
