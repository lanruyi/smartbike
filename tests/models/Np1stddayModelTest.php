<?php

class Np1stddayTestModel extends CIUnit_TestCase {

    protected $tables = array(
    );

    public function __construct($name = NULL, array $data = array(), $dataName = '') {
        parent::__construct($name, $data, $dataName);
    }

    public function setUp() {
        $this->CI->load->model(array('np1stdday'));
        parent::setUp();
        $this->CI->db->query("truncate np1stddays");
        $this->CI->db->query("truncate stations");
    }

    public function tearDown() {
        parent::tearDown();
        $this->CI->db->query("truncate np1stddays");
        $this->CI->db->query("truncate stations");
    }

    public function test_findLastByTime(){
        $this->CI->db->query(" INSERT INTO `np1stddays` (station_id,datetime) values 
            (8,20130530000000), 
            (8,20130523000000), 
            (8,20130606000000), 
            (4,20130523000000), 
            (4,20130530000000), 
            (4,20130606000000)"); 
        $res = $this->CI->np1stdday->findLastByTime(4,"20130602000000");
        $this->assertEquals(h_dt_format($res['datetime']),"20130530000000");
        $res = $this->CI->np1stdday->findLastByTime(8,"20130603000000");
        $this->assertEquals(h_dt_format($res['datetime']),"20130530000000");
    }


    public function test_isStdday(){
        $this->CI->db->query(" INSERT INTO `np1stddays` (station_id,datetime) values 
            (8,20130530000000), 
            (8,20130523000000), 
            (8,20130606000000), 
            (4,20130523000000), 
            (4,20130530000000), 
            (4,20130606000000)"); 
        $this->assertEquals(true, $this->CI->np1stdday->isStdday(8,"20130606000000"));
        $this->assertEquals(false,$this->CI->np1stdday->isStdday(8,"20130605000000"));
        $this->assertEquals(true, $this->CI->np1stdday->isStdday(4,"20130523000000"));
        $this->assertEquals(false,$this->CI->np1stdday->isStdday(4,"20130531000000"));
    }


}










