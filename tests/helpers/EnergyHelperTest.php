<?php

class EnergyTimeHelperTest extends CIUnit_TestCase {

    public function setUp() {
        $this->CI->load->helper('energy');
    }

    public function tearDown() {
        parent::tearDown();
    }

    public function test_h_e_jiangsu_save_energy(){
        $res = h_e_jiangsu_save_energy(100,0.2);
        $this->assertEquals($res,25); 
    }

    public function test_h_e_jiangsu_save_rate(){
        $res = h_e_jiangsu_save_rate(0, 80, 22, 25);
        $this->assertEquals($res,0); 
        $res = h_e_jiangsu_save_rate(100, 0, 20, 25);
        $this->assertEquals($res,0); 
        $res = h_e_jiangsu_save_rate(100, 80, 20, 20);
        $this->assertEquals($res,0.2); 
        $res = h_e_jiangsu_save_rate(100, 80, 0, 20);
        $this->assertEquals($res,0.2); 
        $res = h_e_jiangsu_save_rate(100, 80, 22, 20);
        $this->assertEquals($res,0.12); 
    }

}

