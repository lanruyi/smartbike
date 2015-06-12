<?php

/**
 * @Bug Helper
 */
class BugHelperTest extends CIUnit_TestCase {

    public function setUp() {
        $this->CI->load->model('bug');
        $this->CI->load->helper('bug');
    }
    
    public function tearDown() {
        parent::tearDown();
    }

    public function test_h_bug_is_serious_fault(){
        $res = h_bug_is_serious_fault(21);
        $this->assertEquals($res,true);
		$res = h_bug_is_serious_fault(ESC_BUG__INDOOR_TMP_HIGH);
        $this->assertEquals($res,true);
        $res = h_bug_is_serious_fault(2);
        $this->assertEquals($res,true);
		$res = h_bug_is_serious_fault("2");
        $this->assertEquals($res,true);
        $res = h_bug_is_serious_fault(9);
        $this->assertEquals($res,true);
        $res = h_bug_is_serious_fault(4);
        $this->assertEquals($res,true);
        $res = h_bug_is_serious_fault(5);
        $this->assertEquals($res,false);
		$res = h_bug_is_serious_fault(null);
        $this->assertEquals($res,false);
		$res = h_bug_is_serious_fault(array());
        $this->assertEquals($res,false);
		$res = h_bug_is_serious_fault('21ds');
        $this->assertEquals($res,false);
    }
    
    public function test_h_bug_time_desc(){
        $res = h_bug_time_desc(array("2012-05-04 6:12:21","2013-05-04 6:12:21"));
        $this->assertEquals($res,"2013-05-04 6:12:21");
        $res = h_bug_time_desc(array("2012-05-04 6:12:21","2012-05-04 6:12:22"));
        $this->assertEquals($res,"2012-05-04 6:12:22");
        $res = h_bug_time_desc(array("2012-05-04 6:12:21","2012-5-04 6:12:22"));
        $this->assertEquals($res,"2012-5-04 6:12:22");
        $res = h_bug_time_desc(array("2012-05-04 6:12:21","2012-5-4 6:12:22"));
        $this->assertEquals($res,"2012-5-4 6:12:22");
        $res = h_bug_time_desc(array("2012-5-04 6:12:21","2012-05-04 6:12:22"));
        $this->assertEquals($res,"2012-05-04 6:12:22");
		$res = h_bug_time_desc(array());
        $this->assertEquals($res,null);
		$res = h_bug_time_desc(null);
        $this->assertEquals($res,null);
    }

    public function test_h_bugs_type_name_chn_hash(){
        $res = h_bugs_type_name_chn_hash("2,3,5");
        $this->assertEquals($res, array("2"=>"失去连接","3"=>"485故障","5"=>"室外传感故障"));
        $res = h_bugs_type_name_chn_hash("5,2,3");
        $this->assertEquals($res, array("2"=>"失去连接","3"=>"485故障","5"=>"室外传感故障"));
        $res = h_bugs_type_name_chn_hash("");
        $this->assertEquals($res, array());
        $res = h_bugs_type_name_chn_hash(null);
        $this->assertEquals($res, array());
        $res = h_bugs_type_name_chn_hash("3");
        $this->assertEquals($res, array("3"=>"485故障"));
        $res = h_bugs_type_name_chn_hash(3);
        $this->assertEquals($res, array("3"=>"485故障"));
        $res = h_bugs_type_name_chn_hash("9993");
        $this->assertEquals($res, array("9993"=>"未知"));
    }

    public function test_h_bugs_type_name_chn(){
        $res = h_bugs_type_name_chn("2,3,5");
        $this->assertEquals($res, "失去连接,485故障,室外传感故障");
        $res = h_bugs_type_name_chn("2,5,3");
        $this->assertEquals($res, "失去连接,485故障,室外传感故障");
        $res = h_bugs_type_name_chn("");
        $this->assertEquals($res, "");
        $res = h_bugs_type_name_chn(null);
        $this->assertEquals($res, "");
        $res = h_bugs_type_name_chn(7865);
        $this->assertEquals($res, "未知");
        $res = h_bugs_type_name_chn("2,5,1,3");
        $this->assertEquals($res, "未知,失去连接,485故障,室外传感故障");
    }


}
