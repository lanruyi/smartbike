<?php

/**
 * @group Controller
 */

class WebserviceControllerTest extends CIUnit_TestCase
{

	protected $tables = array(
        "stations" => "stations",
	);

	public function setUp(){
        $this->CI = set_controller('webservice');
		$this->CI->load->model('station');
        $this->CI->db->query("truncate commands");
        $this->CI->db->query("truncate esgs");
        $this->CI->db->query("truncate esgconfs");
		parent::setUp();
	}

    public function tearDown(){
        $this->CI->db->query("truncate commands");
        $this->CI->db->query("truncate esgs");
        $this->CI->db->query("truncate esgconfs");
    }
	
	public function testcreateNewEsg(){
        echo __METHOD__."\n";
        $this->assertEquals(
            $this->CI->createNewEsg(''),
            null
        );
        $this->assertEquals(
            $this->CI->createNewEsg('{"name":"xx","key":"o'),
            null
        );
        $this->assertEquals(
            $this->CI->createNewEsg('{"name":"xx"}'),
            "{error:no name or no key}"
        );
        $this->assertEquals(
            $this->CI->createNewEsg('{}'),
            "{error:no name or no key}"
        );
        $this->assertEquals(
            $this->CI->createNewEsg('{"name":"xx","key":"oo"}'),
            '{"station_id":1}'
        );
        $this->assertEquals(
            $this->CI->createNewEsg('{"name":"xx","key":"ooo"}'),
            '{"station_id":2}'
        );
        $this->assertEquals(
            $this->CI->createNewEsg('{"name":"xx2","key":"oo"}'),
            '{"station_id":1}'
        );
	}

    public function testgetFinishes(){
        echo __METHOD__."\n";
        $this->CI->db->query("insert into commands (id,status) values (21,1),(22,1),(23,1)");
        $this->CI->getFinishes('{"21":"success","22":"success"}');
        $query = $this->CI->db->query("select id,status from commands where id in (21,23)");
        $this->assertEquals( 
            $query->result_array(),
            array(array('id'=>21,'status'=>2),array('id'=>23,'status'=>1))
        );
    }


    public function testgetSettingsOld(){
        echo __METHOD__."\n";
        $this->CI->getSettingsOld(1,11,'{1a');
        $this->CI->getSettingsOld(1,11,'{123:123}');
        $this->CI->getSettingsOld(1,11,'{"s":["100","","","","","","","","","","","","","","","","","","","","","","","","","","","","","3"],"p":["2012090321",""]}');
        $query = $this->CI->db->query("select id,update_duration,in_out_distance from esgconfs");
        $this->assertEquals( 
            $query->row_array(),
            array('id'=>1,'update_duration'=>100,'in_out_distance'=>3)
        );
        $this->CI->getSettingsOld(1,11,'{"s":["120","","","","","","","","","","","","","","","","","","","","","","","","","","","","","4"]}');
        $query = $this->CI->db->query("select id,update_duration,in_out_distance  from esgconfs");
        $this->assertEquals( 
            $query->row_array(),
            array('id'=>1,'update_duration'=>120,'in_out_distance'=>4)
        );
    }

    public function getSettings(){
        $this->CI->getSettings(1,'{1a');
        $this->CI->getSettings(1,'{123:123}');
        $this->CI->getSettings(1,'["100","","","","","","","","","","","","","","","","","","","","","","","","","","","","","3"]');
        $query = $this->CI->db->query("select id,update_duration,in_out_distance  from esgconfs");
        $this->assertEquals( 
            $query->row_array(),
            array('id'=>1,'update_duration'=>100,'in_out_distance'=>3)
        );
    }

    public function testgetDatas(){
        echo __METHOD__."\n";
        $query = $this->CI->db->query("truncate datas");
        $this->CI->getDatas(1,'{"2013-04-08 16:02:14":[45,35,4,8,22,1,1,0,2,"",80,90,"","","",1,500,67788,460,45645,"","","","","","","",""]}');
        $this->CI->getDatas(1,'[45,35,4,8,22,1,1,0,2,"",80,90,"","","",1,500,67788,460,45645,"","","","","","","",""]',2);
        $query = $this->CI->db->query("select count(*) num from datas");
        $this->assertEquals($query->row_array(),array('num'=>2));
    }

    public function testgetEsgDatas(){
        echo __METHOD__."\n";
        $query = $this->CI->db->query("truncate agingdatas");
        $this->CI->getEsgDatas(1,'{"2013-04-08 16:02:14":[45,35,4,8,22,1,1,0,2,"",80,90,"","","",1,500,67788,460,45645,"","","","","","","",""]}');
        $this->CI->getEsgDatas(1,'[45,35,4,8,22,1,1,0,2,"",80,90,"","","",1,500,67788,460,45645,"","","","","","","",""]',2);
        $query = $this->CI->db->query("select count(*) num from agingdatas");
        $this->assertEquals($query->row_array(),array('num'=>2));
    }

    public function testgetProperties(){
        echo __METHOD__."\n";
        $query = $this->CI->db->query("truncate properties");
        $this->CI->getProperties(1,11,'{"p01":"v431_120812","p02":"1.0","p02":"1.0","p03":"1.0","p04":"1.0","p05":"1.0","p06":"1.0","p07":"1.0","p08":"1.0","p09":"1.0"}');
        $this->CI->getProperties(2,12,'{"p01":"v431_120812","p02":"1.0","p02":"1.0","p03":"1.0","p05":"1.0","p06":"1.0","p07":"1.0","p08":"1.0","p09":"1.0"}');
        $query = $this->CI->db->query("select count(*) num from properties");
        $this->assertEquals($query->row_array(),array('num'=>2));
        $this->CI->getProperties(2,12,'{"p01":"v431_120812","p02":"1.0","p02":"1.0","p03":"1.0","p04":"1.0","p05":"1.0","p06":"1.0","p07":"1.0","p08":"1.0","p09":"1.0","p10":12347}');
        $query = $this->CI->db->query("select count(*) num from properties");
        $this->assertEquals($query->row_array(),array('num'=>2));
    }


}

