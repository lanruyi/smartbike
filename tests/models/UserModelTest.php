<?php

/**
 * @group Model
 */

class UserModelTest extends CIUnit_TestCase {

    protected $tables = array(
    );

    public function __construct($name = NULL, array $data = array(), $dataName = '') {
        parent::__construct($name, $data, $dataName);
    }

    public function setUp() {
        $this->CI->load->model(array('user'));
        parent::setUp();
    }

    public function tearDown() {
        parent::tearDown();
    }

    public function test_del_user(){
        $this->CI->db->query("truncate users");
        $this->CI->db->query("insert into users (id,recycle) values 
            (1,".ESC_NORMAL."),
            (2,".ESC_NORMAL.")");
        $this->CI->user->del_user(1);
        $query = $this->CI->db->query("select recycle from users");
        $this->assertEquals($query->result_array(),array(
            array("recycle"=>ESC_DEL),
            array("recycle"=>ESC_NORMAL)));
        $this->CI->user->del_user(2);
        $this->CI->db->query("truncate users");
    }


}
