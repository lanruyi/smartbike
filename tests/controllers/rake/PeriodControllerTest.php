<?php
/********************************
[TEST Controller Period]
./../../../application/controllers/rake/period.php

********************************/

/**
 * @group Controller
 */

class PeriodControllerTest extends CIUnit_TestCase
{

    public function __construct($name = NULL, array $data = array(), $dataName = '') {
        parent::__construct($name, $data, $dataName);
    }

	public function setUp()
	{
		parent::setUp();
		// Set the tested controller
		$this->CI = set_controller('rake/period');
        $this->CI->load->model(array('station','command'));
        $this->CI->db->query("truncate stations");
        $this->CI->db->query("truncate commands");
	}

	public function tearDown() {
		parent::tearDown();
        $this->CI->db->query("truncate stations");
        $this->CI->db->query("truncate commands");
	}


    public function test_go_switch_nplus1_sql(){
        echo __METHOD__."\n";
        $day = h_dt_start_time_of_day('now');
        $this->CI->db->query("insert into stations (ns,ns_start,recycle,station_type) values 
            (3,".h_dt_add_day($day,0).",".ESC_NORMAL.",".ESC_STATION_TYPE_NPLUSONE."),
            (5,".h_dt_add_day($day,5+1).",".ESC_NORMAL.",".ESC_STATION_TYPE_NPLUSONE."),
            (8,".h_dt_sub_day($day,8+1).",".ESC_NORMAL.",".ESC_STATION_TYPE_NPLUSONE."),
            (3,".h_dt_sub_day($day,3).",".ESC_NORMAL.",".ESC_STATION_TYPE_NPLUSONE."),
            (6,".h_dt_add_day($day,6+1+1).",".ESC_NORMAL.",".ESC_STATION_TYPE_NPLUSONE."),
            (9,".h_dt_add_day($day,1).",".ESC_NORMAL.",".ESC_STATION_TYPE_NPLUSONE.")");
        $this->CI->go_switch_nplus1_sql(); 
        $cs = $this->CI->command->findBy_sql(array());
        $this->CI->db->query("truncate stations");
        $this->CI->db->query("truncate commands");
        $res = json_decode($cs[0]['arg']);
        $this->assertEquals(1, $res['16']);
        $res = json_decode($cs[1]['arg']);
        $this->assertEquals(1, $res['16']);
        $res = json_decode($cs[2]['arg']);
        $this->assertEquals(1, $res['16']);
        $res = json_decode($cs['3']['arg']);
        $this->assertEquals(3, $res['16']);
        $res = json_decode($cs['4']['arg']);
        $this->assertEquals(3, $res['16']);
        $res = json_decode($cs['5']['arg']);
        $this->assertEquals(3, $res['16']);
    }

	

}
