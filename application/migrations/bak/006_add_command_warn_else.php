<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_command_warn_else extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'auto_increment' => TRUE,
            ),
            'station_id' => array(
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'default' => 0
            ),
            'command' => array(
                'type' => 'VARCHAR',
                'constraint' => '20',
            ),
            'arg' => array(
                'type' => 'VARCHAR',
                'constraint' => '2048',
            ),
            'priority' => array(
                'type' => 'INT',
                'constraint' => 4,
                'unsigned' => TRUE,
                'default' => 0
            ),
            'status' => array(
                'type' => 'INT',
                'constraint' => 4,
                'unsigned' => TRUE,
                'default' => 0
            )
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('command');

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
                'constraint' => 10,
                'unsigned' => TRUE,
                'NULL' => TRUE
            ),
            'create_time' => array(
                'type' => 'DATETIME',
                'default' => '20000101000000'
            )
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('dboxtmp');

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
            'warn_num' => array(
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'NULL' => TRUE
            ),
            'create_time' => array(
                'type' => 'DATETIME',
                'default' => '20000101000000'
            )
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('warn');

    }

    public function down()
    {
        $this->dbforge->drop_table('dboxtmp');
        $this->dbforge->drop_table('command');
        $this->dbforge->drop_table('warn');
    }
}

?>
