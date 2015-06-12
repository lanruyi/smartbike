<?php

class CommonHelperTest extends CIUnit_TestCase {

    public function setUp() {
        parent::setUp();
        $this->CI->load->helper('common');
    }
    
    public function tearDown() {
        parent::tearDown();
    }

    public function test_h_batch_interval(){
        $this->assertEquals(h_batch_interval("2012-12-1","2013-9-1"),9);
        $this->assertEquals(h_batch_interval("2011-4-1","2013-8-1"),28);
    }

    //public function test_h_sharp_to_dot(){
        //$this->assertEquals(h_sharp_to_dot(""),"");
        //$this->assertEquals(h_sharp_to_dot("esg_xxxabc_efg"),"esg_xxxabc_efg");
        //$this->assertEquals(h_sharp_to_dot("esg_xxx#abc_efg"),"esg_xxx.abc_efg");
        //$this->assertEquals(h_sharp_to_dot("esgxxx#abc_efg"),"esgxxx.abc_efg");
        //$this->assertEquals(h_sharp_to_dot("esgxxx#abc#efg"),"esgxxx.abc.efg");
    //}


}





