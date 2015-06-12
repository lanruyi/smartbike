<?php

/**
 * @group Model
 */

class DaydataModelTest extends CIUnit_TestCase {

    protected $tables = array(
    );

    public function __construct($name = NULL, array $data = array(), $dataName = '') {
        parent::__construct($name, $data, $dataName);
    }

    public function setUp() {

        $this->CI->load->model(array('station','daydata'));
        parent::setUp();
        $this->CI->db->query("truncate daydatas");
        $this->CI->db->query("truncate stations");
    }

    public function tearDown() {
        parent::tearDown();
        $this->CI->db->query("truncate daydatas");
        $this->CI->db->query("truncate stations");
    }

    //public function test_findStationMonthSavingDataTable() {
        //$res = $this->CI->daydata->findStationMonthSavingDataTable(1, 2, "20130101", "20130120");
        ////var_dump($res);
        //$res = $this->CI->daydata->findStationMonthSavingDataTable(1, 0, "20130101", "20130120");
        ////var_dump($res);
    //}

    public function test_get_n_day_load_num(){
        $day = h_dt_start_time_of_day('now');
        $this->CI->db->query("INSERT INTO `stations` (id,station_type,recycle,create_time) values 
            (1,4,1,20130601000000),
            (2,4,1,20130601000000),
            (3,4,1,20130601000000)"); 
        $this->CI->db->query("insert into daydatas (station_id,day,true_load_num) values 
            (2,".h_dt_sub_day($day,6).",91),
            (2,".h_dt_sub_day($day,3).",92),
            (2,".h_dt_sub_day($day,2).",95),
            (2,".h_dt_sub_day($day,1).",87),
            (1,".h_dt_sub_day($day,7).",81),
            (1,".h_dt_sub_day($day,6).",82),
            (1,".h_dt_sub_day($day,3).",85),
            (1,".h_dt_sub_day($day,1).",77)");

        $res = $this->CI->daydata->get_n_day_load_num(7,array(1,2,3));
        $this->assertEquals(array("1"=>"81.2500000000", "2"=>"91.2500000000"),$res); 
        $res = $this->CI->daydata->get_n_day_load_num(15,array(1,2,3));
        $this->assertEquals(array("1"=>"81.2500000000", "2"=>"91.2500000000"),$res); 
    }
    
    public function  test_findSavingDaydata(){
        //$res = $this->CI->daydata->findSavingDaydata($this->CI->station->find(1),"20130112");
        //var_dump($res);
    }
    

    // ------------------------------------------------------------------------

    /**
     * @dataProvider GetCarriersProvider
     */
    //public function testGetCarriers(array $attributes, $expected)
    //{
    //$actual = $this->_pcm->getCarriers($attributes);
    //$this->assertEquals($expected, count($actual));
    //}
    //public function GetCarriersProvider()
    //{
    //return array(
    //array(array('name'), 5)
    //);
    //}
    // ------------------------------------------------------------------------
}
