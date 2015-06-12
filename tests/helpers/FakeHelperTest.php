<?php

/**
 * @datetime Helper
 */
class FakeHelperTest extends CIUnit_TestCase {

    public function setUp() {
        $this->CI->load->helper('fake');
    }

    public function tearDown() {
        parent::tearDown();
    }


    public function testh_fake_JsBoxTmp(){
        $result = h_fake_JsBoxTmp("[[1349020800000,null],[1349020808000,33],[1349021881000,29],[1349021881000,25],[1349021881000,30],[1349107199000,null]]");
        $this->assertEquals($result, "[[1349020800000,null],[1349020808000,27],[1349021881000,25],[1349021881000,25],[1349021881000,24],[1349107199000,null]]");
        $result = h_fake_JsBoxTmp("$%^&*");
        $this->assertEquals($result, "");
    }



}
