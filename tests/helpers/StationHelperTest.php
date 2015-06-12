<?php

/**
 * @Map Helper
 */
class StationHelperTest extends CIUnit_TestCase {

    public function setUp() {
        $this->CI->load->helper('station');
        $this->CI->load->model('station');
    }

    public function tearDown() {
        parent::tearDown();
    }

    public function test_h_station_sim_judge() {
        $this->assertEquals(h_station_sim_judge('null'),false);
        $this->assertEquals(h_station_sim_judge(array()),false);
        $this->assertEquals(h_station_sim_judge('43h24h23ifsdj'),false);
        $this->assertEquals(h_station_sim_judge('fsdj3221232'),false);
        $this->assertEquals(h_station_sim_judge('22132211232'),false);
        $this->assertEquals(h_station_sim_judge('12132211232'),false);
        $this->assertEquals(h_station_sim_judge('13856789872'),true);
        $this->assertEquals(h_station_sim_judge(' 13856789872 '),true);
        $this->assertEquals(h_station_sim_judge(' 13856789 872 '),false);
        $this->assertEquals(h_station_sim_judge('121322112.2'),false);
        $this->assertEquals(h_station_sim_judge('1213221121.2'),false);
    }

    public function test_h_station_colds_exchange_command(){
        $this->assertEquals(h_station_colds_exchange_command(ESC_STATION_COLDS_FUNC_RELAY),0);
        //$this->assertEquals(h_station_colds_exchange_command(ESC_STATION_COLDS_FUNC_PLUSE),2);
        $this->assertEquals(h_station_colds_exchange_command(ESC_STATION_COLDS_FUNC_485),1);
        $this->assertEquals(h_station_colds_exchange_command(ESC_STATION_COLDS_FUNC_INFRARED),2);
        $this->assertEquals(h_station_colds_exchange_command(0),100);
    }

    public function test_h_station_box_exchange_command(){
        $this->assertEquals(h_station_box_exchange_command(ESC_STATION_BOX_TYPE_CHUNLAN),0);
        $this->assertEquals(h_station_box_exchange_command(ESC_STATION_BOX_TYPE_BANGYANG),1);
        $this->assertEquals(h_station_box_exchange_command(1024),100);

    }

}
