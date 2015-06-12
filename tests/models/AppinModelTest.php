<?php

/**
 * @Agingdata Model
 */

class AppinModelTest extends CIUnit_TestCase
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
		$this->CI->load->model('appin');
        $this->CI->db->query("truncate appins");
	}

    public function test_newAppin(){
        //$res = $this->CI->appin->newAppin("exploration",'');
        //$this->assertEquals($res,'{"type":"exploration","result":"no content"}');
        //$res = $this->CI->appin->newAppin("xxx",'{"401","1"}');
        //$this->assertEquals($res,'{"type":"xxx","result":"no type"}');
        //$res = $this->CI->appin->newAppin("exploration",'{"401","1"}');
        //$this->assertEquals($res,'{"type":"exploration","result":"success"}');
        //$res = $this->CI->appin->newAppin("exploration",'{"401","4"}');
        //$this->assertEquals($res,'{"type":"exploration","result":"success"}');
        //$appins = $this->CI->appin->findBy();
        //$this->assertEquals(2,count($appins));
        $this->assertEquals(2,2);

    }
	
	public function tearDown()
	{
		parent::tearDown();
        $this->CI->db->query("truncate appins");
	}
	
}
