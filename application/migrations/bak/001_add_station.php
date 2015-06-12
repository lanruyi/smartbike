<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_station extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'auto_increment' => TRUE,
            ),
            'name_chn' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
            ),
            'name_py' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
            )
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('station');
        // the form station is from 101. the first 100 stations are for test.
        $this->db->query('alter table station AUTO_INCREMENT=100');
        $this->db->insert('station', array("id"=>1,"name_chn"=>'测试一号站',"name_py"=>'yx1h'));
        $this->db->insert('station', array("id"=>2,"name_chn"=>'测试二号站',"name_py"=>'yx2h'));
        $this->db->insert('station', array("id"=>3,"name_chn"=>'测试三号站',"name_py"=>'yx3h'));
        $this->db->insert('station', array("id"=>4,"name_chn"=>'测试四号站',"name_py"=>'yx4h'));
        $this->db->insert('station', array("id"=>5,"name_chn"=>'测试五号站',"name_py"=>'yx5h'));
        $this->db->insert('station', array("id"=>6,"name_chn"=>'测试六号站',"name_py"=>'yx6h'));

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
        $this->dbforge->create_table('dindoortmp');


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
        $this->dbforge->create_table('doutdoortmp');


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
                'default' => '20010101010000'
            )
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('dindoortmp_hour_cache');

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
                'default' => '20010101010000'
            )
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('doutdoortmp_hour_cache');

    }

    public function down()
    {
        $this->dbforge->drop_table('station');
        $this->dbforge->drop_table('dindoortmp');
        $this->dbforge->drop_table('doutdoortmp');
        $this->dbforge->drop_table('dindoortmp_hour_cache');
        $this->dbforge->drop_table('doutdoortmp_hour_cache');
    }
}

?>
