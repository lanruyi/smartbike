<?php

class DataTestModel extends CIUnit_TestCase {

    protected $tables = array(
    );

    public function __construct($name = NULL, array $data = array(), $dataName = '') {
        parent::__construct($name, $data, $dataName);
    }

    public function setUp() {
        parent::setUp();
        $this->CI->load->model('archive/data');
        $this->CI->data->changeTableName("d");
        $this->CI->db->query("truncate test_datas");
        $this->CI->cache->clean();
    }

    public function tearDown() {
        parent::tearDown();
        $this->CI->data->changeTableName("d");
        $this->CI->db->query("truncate test_datas");
        $this->CI->cache->clean();
    }


    public function test_find(){
        echo __METHOD__."\n";
        $this->CI->db->query("insert into test_datas (station_id,fan_0_on,colds_0_on,colds_1_on,power_dc,power_main,create_time) values 
            (1, 1,1,1, 1800,1900,".h_dt_sub_min('now',8)."),
            (1, 1,1,1, 1800,1900,".h_dt_sub_min('now',7)."),
            (1, 1,1,0, 1811,1900,".h_dt_sub_min('now',6)."),
            (1, 1,0,0, 1800,1900,".h_dt_sub_min('now',5)."),
            (1, 0,0,0, 1800,1900,".h_dt_sub_min('now',4)."),
            (1, 0,0,0, 1809,1900,".h_dt_sub_min('now',3)."),
            (1, 0,0,0, 1800,1900,".h_dt_sub_min('now',2)."),
            (1, 1,0,0, 1802,1900,".h_dt_sub_min('now',1)."),
            (7, 0,0,0, 1800,3600,".h_dt_sub_min('now').")");
        $this->CI->data->changeTableName("test_datas");
        $d = $this->CI->data->findLast(1);
        $this->assertEquals(1802,$d['power_dc']);
        $d = $this->CI->data->findLastN(1,3);
        $this->assertEquals(1809,$d[2]['power_dc']);
        $d = $this->CI->data->findPeriodDatas(1,h_dt_sub_min('now',8),h_dt_sub_min('now',5),"asc");
        $this->assertEquals(1811,$d[2]['power_dc']);
    }

}





