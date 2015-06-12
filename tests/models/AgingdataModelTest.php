<?php

/**
 * @Agingdata Model
 */

class AgingdataModelTest extends CIUnit_TestCase
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
		$this->CI->load->model('agingdata');
        $this->CI->db->query("truncate agingdatas");
	}

    public function test_insertJsonData(){
        $agingdata_id = $this->CI->agingdata->insertJsonData(1,'{"0-0-0":[45,35,4,8,22,1,1,"",1,"",80,90,"","","",1,500,67788,460,45645,"","","","","","","",""');
        $this->assertNull($agingdata_id);
        $agingdata_id = $this->CI->agingdata->insertJsonData(1,'{"0-0-0":[45,35,4,8,22,1,1,"",1,"",80,90,"","","",1,500,67788,460,45645,"","","","","","","",""]}');
        $this->assertNotNull($agingdata_id);
        $this->assertLessThanOrEqual($agingdata_id,1);
        $agingdata_id = $this->CI->agingdata->insertJsonData(1,'{"2012-12-21 20:44:27":[45,35,4,8,22,1,1,0,2,"",80,90,"","","",1,500,67788,460,45645,"","","","","","","",""]}');
        $this->assertNotNull($agingdata_id);
        $this->assertLessThanOrEqual($agingdata_id,1);
        $agingdata = $this->CI->agingdata->find_sql($agingdata_id);
        $this->assertNotNull($agingdata);
        $this->assertEquals($agingdata['indoor_tmp'],45);
        $this->assertLessThan(5,strtotime("now")-strtotime($agingdata['create_time']));
    }
	
	public function tearDown()
	{
		parent::tearDown();
        $this->CI->db->query("truncate agingdatas");
	}
	
}
