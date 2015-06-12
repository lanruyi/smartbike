<?php

class DataHelperTest extends CIUnit_TestCase {

    public function setUp() {
        parent::setUp();
        $this->CI->load->helper('data');
    }
    
    public function tearDown() {
        parent::tearDown();
    }

    public function test_h_data_min_box_tmp(){
        $this->assertEquals(h_data_min_box_tmp("","",""),"");
        $this->assertEquals(h_data_min_box_tmp("",0,""),0);
        $this->assertEquals(h_data_min_box_tmp("",5,""),5);
        $this->assertEquals(h_data_min_box_tmp("","",7),7);
        $this->assertEquals(h_data_min_box_tmp("",3,7),3);
        $this->assertEquals(h_data_min_box_tmp(2,"",7),2);
        $this->assertEquals(h_data_min_box_tmp(10,"",7),7);
        $this->assertEquals(h_data_min_box_tmp(10,"4",7),4);
    }
}




