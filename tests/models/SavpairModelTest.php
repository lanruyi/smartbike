<?php

class SavpairModelTest extends CIUnit_TestCase {

    public function __construct($name = NULL, array $data = array(), $dataName = '') {
        parent::__construct($name, $data, $dataName);
    }

    public function setUp() {
        $this->CI->load->model('savpair');
        parent::setUp();
        $this->CI->db->query("truncate savpairs");
    }

    public function tearDown() {
        parent::tearDown();
        $this->CI->db->query("truncate savpairs");
    }


    public function test_copy_savpairs(){
        $this->CI->db->query("insert into savpairs (datetime,project_id,city_id,
            building_type,total_load,sav_station_id,std_station_id,save_rate) values
            (20130601000000,4,20,1,1,12,14,30),
            (20130601000000,4,20,1,2,13,15,30),
            (20130601000000,4,20,1,3,19,22,30),
            (20130601000000,4,20,2,1,4,9,30),
            (20130601000000,4,22,2,2,9,141,30),
            (20130601000000,4,20,2,3,111,34,30),
            (20130801000000,4,20,2,3,111,34,30)");
        $this->CI->savpair->copy_savpairs("20130604020301","20130704010101");
        $savpairs = $this->CI->savpair->findBy(array("datetime"=>"20130701000000"));
        $this->assertEquals(6, count($savpairs));
        $this->CI->savpair->copy_savpairs("20130704020301","20130804010101");
        $savpairs = $this->CI->savpair->findBy(array("datetime"=>"20130801000000"));
        $this->assertEquals(1, count($savpairs));
    }
    



}

