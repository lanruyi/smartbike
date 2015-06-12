<?php

/**
 * @group Model
 */

class FandaydataModelTest extends CIUnit_TestCase {

    protected $tables = array(
    );

    public function __construct($name = NULL, array $data = array(), $dataName = '') {
        parent::__construct($name, $data, $dataName);
    }

    public function setUp() {
        $this->CI->load->model(array('t_fandaydata'));
        parent::setUp();
        $this->CI->db->query("truncate t_fandaydatas");
    }

    public function tearDown() {
        parent::tearDown();
        $this->CI->db->query("truncate t_fandaydatas");
    }

    public function test_getStationsFanTimeHash(){
        $this->CI->db->query("insert into t_fandaydatas (station_id,fan_total,data_total,record_time) values 
            (4,30, 40,20130701000000),

            (1,30, 1440,20130701000000),
            (1,100,1440,20130702000000),
            (1,120,1440,20130705000000),
            (1,190,1440,20130707000000),
            (1,210,1440,20130709000000),
            (1,210,1440,20130710000000),
            (1,210,1440,20130711000000),
            (1,210,1440,20130712000000),
            (1,210,1440,20130713000000),
            (1,210,1440,20130714000000),
            (1,210,1440,20130715000000),
            (1,210,1440,20130716000000),
            (1,210,1440,20130717000000),
            (1,210,1440,20130718000000),
            (1,210,1440,20130719000000),
            (1,210,1440,20130720000000),

            (2,20, 1440,20130701000000),
            (2,90, 1440,20130702000000),
            (2,110,1440,20130705000000),
            (2,180,1440,20130707000000),
            (2,200,1440,20130709000000),
            (2,120,1440,20130711000000),
            (2,180,600 ,20130731000000)");
        $res = $this->CI->t_fandaydata->getStationsFanTimeHash(array(1,2,3,4),"20130701000000");
        $my_res = array( 
            "1"=>array( "time"=> 5735),
            "2"=>array( "time"=> null),
            "4"=>array( "time"=> null)
        );
        $this->assertEquals($res,$my_res);
        

        $this->CI->db->query("truncate t_fandaydatas");
    }


}
