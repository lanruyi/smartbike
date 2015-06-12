<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_datahum extends CI_Migration {

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
        $this->dbforge->create_table('dindoorhum');


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
        $this->dbforge->create_table('doutdoorhum');


    }

    public function down()
    {
        $this->dbforge->drop_table('dindoorhum');
        $this->dbforge->drop_table('doutdoorhum');
    }
}

?>
