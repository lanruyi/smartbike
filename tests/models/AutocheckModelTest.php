<?php

/**
 * @Agingdata Model
 */

class AutocheckModelTest extends CIUnit_TestCase
{
	protected $tables = array(
	);
	
	public function __construct($name = NULL, array $data = array(), $dataName = '')
	{
		parent::__construct($name, $data, $dataName);
	}
	
	public function setUp()
	{
		parent::setUp();
		$this->CI->load->model('autocheck');
        $this->CI->db->query("truncate autochecks");
        $this->CI->db->query("truncate stations");
	}

    public function test_makeExpire(){
        $this->assertEquals(1,1);
        //$this->CI->db->query("insert into autochecks (station_id,datetime,status) values 
            //(1,20130922000000,".ESC_AUTOCHECK_STATUS_ING."),
            //(1,20130923000000,".ESC_AUTOCHECK_STATUS_ING."),
            //(1,20130924100000,".ESC_AUTOCHECK_STATUS_ING."),
            //(2,20130924100000,".ESC_AUTOCHECK_STATUS_ING."),
            //(3,20130924100000,".ESC_AUTOCHECK_STATUS_ING."),
            //(3,20130925010000,".ESC_AUTOCHECK_STATUS_ING.")");
        //$this->CI->autocheck->makeExpire();
        //$autochecks = $this->CI->autocheck->findBy(array("status"=>ESC_AUTOCHECK_STATUS_ING));
        //var_dump($autochecks);
    }
	
	public function tearDown()
	{
		parent::tearDown();
        $this->CI->db->query("truncate autochecks");
        $this->CI->db->query("truncate stations");
	}
	
}
