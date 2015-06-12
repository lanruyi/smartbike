<?php

/**
 * @Esg Model
 */

class EsgModelTest extends CIUnit_TestCase
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
		$this->CI->load->model('esg');
        $this->CI->db->query("truncate esgs");
	}

	
	public function tearDown()
	{
		parent::tearDown();
        $this->CI->db->query("truncate esgs");
	}

    public function test_get_esg_by_esg_key(){
        $esg_id = $this->CI->esg->get_esg_by_esg_key("name","key1234567");
        $this->assertEquals($esg_id,1);
        $esg_id = $this->CI->esg->get_esg_by_esg_key("name","key34567");
        $this->assertEquals($esg_id,2);
        $esg_id = $this->CI->esg->get_esg_by_esg_key("name","key1234567");
        $this->assertEquals($esg_id,1);
        $this->CI->esg->update(1,array("fixed"=>ESC_ESG_FIXED));
        $esg_id = $this->CI->esg->get_esg_by_esg_key("name","key1234567");
        $this->assertEquals($esg_id,3);
    }
	
}
