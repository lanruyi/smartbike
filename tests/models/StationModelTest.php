<?php

/**
 * @Station Model
 */
class StationModelTest extends CIUnit_TestCase {

    private $_pcm;

    public function __construct($name = NULL, array $data = array(), $dataName = '') {
        parent::__construct($name, $data, $dataName);
    }

    public function tearDown() {
        //清空redis数据库
        //$this->CI->redis->del("alive_station_ids");
        parent::tearDown();
        $this->CI->db->query("truncate table stations");
    }

    public function setUp() {
        parent::setUp();
        $this->CI->load->model('station');
        $this->station = $this->CI->station;
        $this->CI->db->query("truncate table stations");
    }



    public function test_errorStationsOffline(){
        $this->CI->db->query("insert into stations (alive,recycle,last_connect_time) values 
            (1,1,".h_dt_sub_min('now',8)."),
            (1,1,".h_dt_sub_min('now',15).")");
        $this->station->errorStationsOffline();
        $station1 = $this->station->find(1);
        $station2 = $this->station->find(2);
        $this->assertEquals(ESC_ONLINE, $station1['alive']);
        $this->assertEquals(ESC_OFFLINE, $station2['alive']);
    }

    public function test_check_and_refresh_station() {
        $this->CI->db->query("insert into stations (alive) values (?)",array(ESC_OFFLINE));
        $this->station->check_and_refresh_station(1);
        $station = $this->station->find(1);
        $this->assertEquals(ESC_ONLINE, $station['alive']);
        $this->CI->db->query("delete from stations where id=1");
    }


    //返回 station中装站的基站创建方法测试
    public function test_new_sql() {
        $stations = $this->station->new_sql(array());
    }


    public function test_findAllStations(){
        $this->CI->db->query("insert into stations (status,alive,recycle,last_connect_time) values 
            (".ESC_STATION_STATUS_REMOVE.",1,1,".h_dt_sub_min('now',8)."),
            (".ESC_STATION_STATUS_NORMAL.",1,2,".h_dt_sub_min('now',8)."),
            (".ESC_STATION_STATUS_NORMAL.",1,1,".h_dt_sub_min('now',8)."),
            (".ESC_STATION_STATUS_NORMAL.",1,1,".h_dt_sub_min('now',15).")");
        $stations = $this->station->findAllStations();
        $this->assertEquals(2, count($stations));
        
    }

}
