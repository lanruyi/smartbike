<?php

/**
 * @Station Model
 */
class TempControllerTest extends CIUnit_TestCase {

    protected $tables = array(
    );

    public function __construct($name = NULL, array $data = array(), $dataName = '') {
        parent::__construct($name, $data, $dataName);
    }

    public function tearDown() {
        parent::tearDown();
    }

    public function setUp() {
        $this->CI = set_Controller("rake/temp");
        $this->CI->load->model(array('station','fixdata','data','daydata','monthdata'));
        parent::setUp();
    }

    public function test_recalculate_day(){
        echo __METHOD__."\n";
        $this->CI->db->query("truncate daydatas");
        $this->CI->db->query("insert into daydatas (station_id,day,main_energy,dc_energy,ac_energy) values 
            (1,20130701000000,NULL,NULL,NULL),
            (1,20130702000000,100,80,20)");
        $this->CI->recalculate_day();
        $daydata1 = $this->CI->daydata->findOneBy_sql(array('station_id'=>1,'day'=>'2013-7-1'));
        $this->assertEquals($daydata1['true_load_num'],NULL);
        $daydata2 = $this->CI->daydata->findOneBy_sql(array('station_id'=>1,'day'=>'2013-7-2'));
        $this->assertEquals(round($daydata2['true_load_num'],5),round(80/1.44,5));
        $this->CI->db->query("truncate daydatas");
    }

    public function test_recalculate_month(){
        echo __METHOD__."\n";
        $this->CI->db->query("truncate monthdatas");
        $this->CI->db->query("insert into monthdatas (station_id,datetime,main_energy,dc_energy,ac_energy) values 
            (1,20130701000000,NULL,NULL,NULL),
            (1,20130801000000,10000,8000,2000)");
        $this->CI->recalculate_month();
        $monthdata1 = $this->CI->monthdata->findOneBy_sql(array('station_id'=>1,'datetime'=>'2013-7-1'));
        $this->assertEquals($monthdata1['true_load_num'],NULL);
        $monthdata2 = $this->CI->monthdata->findOneBy_sql(array('station_id'=>1,'datetime'=>'2013-8-1'));
        $this->assertEquals(round($monthdata2['true_load_num'],5),round(8000/1.44/31,5));
        $this->CI->db->query("truncate monthdatas");
    }

}





