<?php

class Mid_energyTestModel extends CIUnit_TestCase {

    protected $tables = array(
    );

    public function __construct($name = NULL, array $data = array(), $dataName = '') {
        parent::__construct($name, $data, $dataName);
    }

    public function setUp() {
        $this->CI->load->model(array('mid/mid_energy'));
        parent::setUp();
        $this->CI->db->query("truncate np1stddays");
        $this->CI->db->query("truncate daydatas");
        $this->CI->db->query("truncate monthdatas");
        $this->CI->db->query("truncate datas");
        $this->CI->db->query("truncate stations");
    }

    public function tearDown() {
        parent::tearDown();
        $this->CI->db->query("truncate np1stddays");
        $this->CI->db->query("truncate daydatas");
        $this->CI->db->query("truncate monthdatas");
        $this->CI->db->query("truncate datas");
        $this->CI->db->query("truncate stations");
    }



    function test_calcSinglePairSaveRate(){
        $this->CI->db->query("INSERT INTO stations (id,load_num) values (1,22),(2,20)");
        $this->CI->db->query("INSERT INTO monthdatas (station_id,main_energy,datetime,true_energy) values 
            (1,90,20131001000000,100), 
            (2,85,20131001000000,80)"); 
        $res = $this->CI->mid_energy->calcSinglePairSaveRate(1,2,"2013-10-01");
        $this->assertEquals($res,0.12); 
        $res = $this->CI->mid_energy->calcSinglePairSaveRate(2,1,"2013-10-01");
        $this->assertEquals($res,0); 
    }

    function test_calcDaySaveRate_JiangSu(){
        $this->CI->db->query("INSERT INTO stations (id,load_num) values (1,22),(2,20)");
        $this->CI->db->query("INSERT INTO daydatas (station_id,main_energy,day) values 
            (1,100,20131001000000), 
            (2,80 ,20131001000000)"); 
        $res = $this->CI->mid_energy->calcDaySaveRate_JiangSu(1,2,"2013-10-01");
        $this->assertEquals($res,0.12); 
        $res = $this->CI->mid_energy->calcDaySaveRate_JiangSu(2,1,"2013-10-01");
        $this->assertEquals($res,0); 
    }

}
