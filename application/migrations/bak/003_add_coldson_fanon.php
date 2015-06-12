<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_coldson_fanon extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'station_id' => array(
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'default' => 0
            ),
            'num' => array(
                'type' => 'INT',
                'constraint' => 2,
                'unsigned' => TRUE,
                'NULL' => TRUE
            ),
            'create_time' => array(
                'type' => 'DATETIME',
                'default' => '20000101000000'
            ),
            'colds_id' => array(
                'type' => 'INT',
                'constraint' => 4,
                'unsigned' => TRUE,
                'default' => 0
            )
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('dcoldson');
		
		$this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'station_id' => array(
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'default' => 0
            ),
            'num' => array(
                'type' => 'INT',
                'constraint' => 2,
                'unsigned' => TRUE,
                'NULL' => TRUE
            ),
            'create_time' => array(
                'type' => 'DATETIME',
                'default' => '20000101000000'
            ),
            'fans_id' => array(
                'type' => 'INT',
                'constraint' => 4,
                'unsigned' => TRUE,
                'default' => 0
            )
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('dfanon');
	
    }

    public function down()
    {
        $this->dbforge->drop_table('dcoldson');
		$this->dbforge->drop_table('dfanon');
    }
}

?>
