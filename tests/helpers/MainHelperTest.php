<?php

class MainHelperTest extends CIUnit_TestCase {

    public function setUp() {
        $this->CI->load->helper('main');
    }
    
    public function tearDown() {
        parent::tearDown();
    }

    public function test_h_array_safe() {
        $test = array("a"=>1);
        $this->assertEquals(h_array_safe($test,"a"),1);
        $this->assertEquals(h_array_safe($test,"b"),null);
    }
    

    public function test_h_round2(){
        $this->assertEquals((string)h_round2(123.3033)==="123.30",true);
        $this->assertEquals((string)h_round2(123.0033)==="123.00",true);
    }
   
    public function test_h_array_sort(){
        $array = array(
            "3"=>array('name'=>'手机','brand'=>'诺基亚','price'=>1050),
            "6"=>array('name'=>'笔记本电脑','brand'=>'lenovo','price'=>4300),
            "4"=>array('name'=>'剃须刀','brand'=>'飞利浦','price'=>3100)
        );
        //升序
        $asc_array = array(
            "3"=>array('name'=>'手机','brand'=>'诺基亚','price'=>1050),
            "4"=>array('name'=>'剃须刀','brand'=>'飞利浦','price'=>3100),
            "6"=>array('name'=>'笔记本电脑','brand'=>'lenovo','price'=>4300)
        );
        $this->assertEquals(h_array_sort($array,"price"),$asc_array);
        $desc_array = array(
            "6"=>array('name'=>'笔记本电脑','brand'=>'lenovo','price'=>4300),
            "4"=>array('name'=>'剃须刀','brand'=>'飞利浦','price'=>3100),
            "3"=>array('name'=>'手机','brand'=>'诺基亚','price'=>1050)
        );
        //降序
        $this->assertEquals(h_array_sort($array,"price","desc"),$desc_array);

    }


    public function test_h_power_to_month_energy(){
        $energy = h_power_to_month_energy(200,"2014-2-1 12:00:00");
        $this->assertEquals($energy,134.4);
        $energy = h_power_to_month_energy(null,"2014-2-1 12:00:00");
        $this->assertEquals($energy,0);
        $energy = h_power_to_month_energy(-1,"2014-2-1 12:00:00");
        $this->assertEquals($energy,0);
    }

}
