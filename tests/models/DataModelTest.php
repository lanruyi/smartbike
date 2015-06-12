<?php

/**
 * @group Model
 */

class DataModelTest extends CIUnit_TestCase
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
		$this->CI->load->model('data');
        $this->CI->db->query("truncate datas");
        $this->CI->db->query("truncate stations");
        $this->CI->db->query("truncate data_indexs");
	}

	public function tearDown()
	{
		parent::tearDown();
        $this->CI->db->query("truncate datas");
        $this->CI->db->query("truncate stations");
        $this->CI->db->query("truncate data_indexs");
	}


    public function test_insertJsonData(){
        $data_id = $this->CI->data->insertJsonData(1,'{"0-0-0":[45,35,4,8,22,1,1,"",1,"",80,90,"","","",1,500,67788,460,45645,"","","","","","","",""');
        $this->assertNull($data_id);
        $data_id = $this->CI->data->insertJsonData(1,'{"0-0-0":[45,35,4,8,22,1,1,"",1,"",80,90,"","","",1,500,67788,460,45645,"","","","","","","",""]}');
        $this->assertNotNull($data_id);
        $this->assertLessThanOrEqual($data_id,1);
        $data_id = $this->CI->data->insertJsonData(1,'{"2012-12-21 20:44:27":[45,35,4,8,22,1,1,0,2,"",80,90,"","","",1,500,67788,460,45645,"","","","","","","",""]}');
        $this->assertNotNull($data_id);
        $this->assertLessThanOrEqual($data_id,1);
        $data = $this->CI->data->find_sql($data_id);
        $this->assertNotNull($data);
        $this->assertEquals($data['indoor_tmp'],45);
        $this->assertEquals($data['energy_dc'],45645);
        $this->assertLessThan(5,strtotime("now")-strtotime($data['create_time']));
    }










	
	
}
