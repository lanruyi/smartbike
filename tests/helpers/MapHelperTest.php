<?php

/**
 * @Map Helper
 */
class MapHelperTest extends CIUnit_TestCase {

    public function setUp() {
        $this->CI->load->helper('map');
    }
    
    public function tearDown() {
        parent::tearDown();
    }

    public function test_h_ll_inside_china() {
        $this->assertEquals(h_ll_inside_china(100, 55),false);
        $this->assertEquals(h_ll_inside_china(100, 1),false);
        $this->assertEquals(h_ll_inside_china(146, 30),false);
        $this->assertEquals(h_ll_inside_china(50, 30),false);
        $this->assertEquals(h_ll_inside_china(80, 25),true);
        $this->assertEquals(h_ll_inside_china(null, null),false); 
        $this->assertEquals(h_ll_inside_china("", ""),false); 
        $this->assertEquals(h_ll_inside_china(-100, -40),false); 
    }
    
    public function test_h_calDistance() {
        $this->assertEquals(h_calDistance("120.8473 ","32.05896 ","120.86","32.01"),true);
        $this->assertEquals(h_calDistance("120.8473","32.05896","120.86","32.01"),true);
        $this->assertEquals(h_calDistance("119.422103","32.064118","119.27","32.11"),true);
		$this->assertEquals(h_calDistance("","","119.27","32.11"),false);
		$this->assertEquals(h_calDistance("null","null","119.27","32.11"),false);
		$this->assertEquals(h_calDistance("null","null","null","null"),false);
		$this->assertEquals(h_calDistance("","","",""),false);
		$this->assertEquals(h_calDistance("0","0","0","0"),false);	
    }
    
    public function test_h_pointsDistance(){
        $this->assertEquals(h_pointsDistance(120.293383,31.570037,114.3162,30.581084),false); //无锡到武汉
        $this->assertEquals(h_pointsDistance(120.148872,33.379862,121.487899,31.249162),false); //盐城到上海的距离,全程314        
        $this->assertEquals(h_pointsDistance(120.460043,32.550127,120.86,32.01),true);
        $this->assertEquals(h_pointsDistance(null,null,120.86,32.01),false);
		$this->assertEquals(h_pointsDistance(null,null,null,null),false);
		$this->assertEquals(h_pointsDistance(0,0,null,null),false);
		$this->assertEquals(h_pointsDistance(array(),32.550127,120.86,32.01),false);
    }
    
    public function test_h_filterPoint(){
        $this->assertEquals(h_filterPoint('118.85712'),true);
        $this->assertEquals(h_filterPoint('31.68994'),true);
        $this->assertEquals(h_filterPoint('120.293383'),true);
        $this->assertEquals(h_filterPoint('120。148872'),false);
        $this->assertEquals(h_filterPoint('120@148872'),false);
        $this->assertEquals(h_filterPoint('32.05896'),true);
        $this->assertEquals(h_filterPoint('120°1232324'),false);
        $this->assertEquals(h_filterPoint('120'),true);
        $this->assertEquals(h_filterPoint('120.460043'),true);
		$this->assertEquals(h_filterPoint('null'),false);
		$this->assertEquals(h_filterPoint(''),false);
		$this->assertEquals(h_filterPoint('0'),false);
    }
}
