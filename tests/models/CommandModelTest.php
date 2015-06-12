<?php

/**
 * @Command Model
 */

class CommandModelTest extends CIUnit_TestCase
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
		$this->CI->load->model('command');
        $this->CI->db->query("truncate commands");
	}
	public function tearDown()
	{
        $this->CI->db->query("truncate commands");
		parent::tearDown();
	}

    ////////////////// 发出命令
    public function test_newUrcCommand(){
        $command_id = $this->CI->command->newUrcCommand(null);
        $this->assertNull($command_id);
        $command_id = $this->CI->command->newUrcCommand(2);
        $this->assertNotNull($command_id);
        $this->assertLessThanOrEqual($command_id,1);
        $command = $this->CI->command->find_sql($command_id);
        $this->assertNotNull($command);
        $this->assertEquals($command['command'],'urc');
        $this->assertEquals($command['station_id'],2);
    }

    public function test_newStCommand(){
        $command_id = $this->CI->command->newStCommand(2,'[""]');
        $this->assertNotNull($command_id);
        $this->assertLessThanOrEqual($command_id,1);
        $command = $this->CI->command->find_sql($command_id);
        $this->assertNotNull($command);
        $this->assertEquals($command['command'],'st');
        $this->assertEquals($command['station_id'],2);
        $this->assertEquals($command['arg'],'[""]');
    }

    public function test_finishGSCommand(){
        $this->CI->command->new_sql(array('station_id'=>2,'command'=>'gs','status'=>ESC_COMMAND_STATUS__CLOSED));
        $command_id = $this->CI->command->new_sql(array('station_id'=>2,'command'=>'gs'));
        $command = $this->CI->command->find_sql($command_id);
        $this->assertEquals($command['status'],ESC_COMMAND_STATUS__OPEN);
        $command_update_id = $this->CI->command->finishGSCommand(2);
        $this->assertEquals($command_id,$command_update_id);
        $command = $this->CI->command->find_sql($command_id,true);
        $this->assertEquals($command['status'],ESC_COMMAND_STATUS__CLOSED);
    }


    public function test_findActiveGSCommand(){
        $this->CI->command->new_sql(array('station_id'=>2,'command'=>'gs','status'=>ESC_COMMAND_STATUS__READ));
        $command = $this->CI->command->findActiveGSCommand(2);
        $this->assertEquals($command['command'],'gs');
    }

    public function test_getCommandJsonOfStation(){
        $this->CI->command->new_sql(array('station_id'=>2,'command'=>'gs','status'=>ESC_COMMAND_STATUS__CLOSED));
        $command_id = $this->CI->command->newGSCommand(2);
        $res = $this->CI->command->getCommandJsonOfStation(2);
        $this->assertEquals($res,'[["2","gs",""]]');
    }
	
    public function test_overTime(){
        $this->CI->db->query("insert into commands (station_id,create_time,command,status) values
            (1,".h_dt_sub_min("now",70).",'gs',".ESC_COMMAND_STATUS__OPEN."),
            (2,".h_dt_sub_min("now",68).",'gp',".ESC_COMMAND_STATUS__READ."),
            (3,".h_dt_sub_min("now",50).",'gs',".ESC_COMMAND_STATUS__OPEN."),
            (4,".h_dt_sub_min("now",52).",'gp',".ESC_COMMAND_STATUS__READ."),
            (8,".h_dt_sub_min("now",80).",'urc',".ESC_COMMAND_STATUS__CLOSED.")");
        $this->CI->command->overTime();
        $c = $this->CI->command->find(1);
        $this->assertEquals($c['status'],ESC_COMMAND_STATUS__OVERTIME);
        $c = $this->CI->command->find(2);
        $this->assertEquals($c['status'],ESC_COMMAND_STATUS__OVERTIME2);
        $c = $this->CI->command->find(3);
        $this->assertEquals($c['status'],ESC_COMMAND_STATUS__OPEN);
        $c = $this->CI->command->find(4);
        $this->assertEquals($c['status'],ESC_COMMAND_STATUS__READ);
        $c = $this->CI->command->find(5);
        $this->assertEquals($c['status'],ESC_COMMAND_STATUS__CLOSED);
    }
	
}

