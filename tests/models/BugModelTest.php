<?php

class BugModelTest extends CIUnit_TestCase {


    private $_pcm;
    
    public function __construct($name = NULL, array $data = array(), $dataName = '') {
        parent::__construct($name, $data, $dataName);
    }

    public function setUp() {
        $this->CI->load->model('bug');
        $this->bug = $this->CI->bug;
        parent::setUp();
        $this->CI->db->query("truncate bugs");
        $this->CI->db->query("truncate stations");
    }
    public function tearDown() {
        parent::tearDown();
        $this->CI->db->query("truncate bugs");
        $this->CI->db->query("truncate stations");
    }



    public function test_closeAll(){
        echo __METHOD__."\n";
        $this->CI->db->query("insert into bugs (station_id,status,type) values 
            (1, ".ESC_BUG_STATUS__OPEN.",23),
            (2, ".ESC_BUG_STATUS__OPEN.",23),
            (3, ".ESC_BUG_STATUS__OPEN.",23),
            (4, ".ESC_BUG_STATUS__OPEN.",23),
            (5, ".ESC_BUG_STATUS__OPEN.",23),
            (6, ".ESC_BUG_STATUS__OPEN.",23),
            (7, ".ESC_BUG_STATUS__OPEN.",23)");
        $this->bug->closeAll(23);
        $bugs = $this->bug->findBy(array("status"=>ESC_BUG_STATUS__OPEN));
        $this->assertEquals(0,count($bugs)); 
        $bugs = $this->bug->findBy(array("status"=>ESC_BUG_STATUS__CLOSED));
        $this->assertEquals(7,count($bugs)); 
    }
    
    public function test_openBugs(){
        echo __METHOD__."\n";
        $this->CI->db->query("insert into bugs (station_id,status,type) values 
            (1, ".ESC_BUG_STATUS__OPEN.",23),
            (2, ".ESC_BUG_STATUS__OPEN.",23),
            (3, ".ESC_BUG_STATUS__OPEN.",23),
            (4, ".ESC_BUG_STATUS__OPEN.",23),
            (5, ".ESC_BUG_STATUS__OPEN.",23),
            (6, ".ESC_BUG_STATUS__OPEN.",23),
            (7, ".ESC_BUG_STATUS__OPEN.",23)");
        $this->bug->openBugs(array("6"=>"","7"=>"","8"=>"","9"=>""),23);
        $this->assertEquals(9,count($this->bug->findBy()));
    }


    public function test_openAndCloseBugs(){
        echo __METHOD__."\n";
        $this->CI->db->query("insert into bugs (station_id,status,type) values 
            (1, ".ESC_BUG_STATUS__OPEN.",23),
            (2, ".ESC_BUG_STATUS__OPEN.",23),
            (3, ".ESC_BUG_STATUS__OPEN.",23),
            (4, ".ESC_BUG_STATUS__OPEN.",23),
            (5, ".ESC_BUG_STATUS__OPEN.",23),
            (6, ".ESC_BUG_STATUS__OPEN.",23),
            (7, ".ESC_BUG_STATUS__OPEN.",23)");
        $this->bug->openAndCloseBugs(array("6"=>"","7"=>"","8"=>"","9"=>""),23);
        $bugs = $this->bug->findBy(array("status"=>ESC_BUG_STATUS__OPEN));
        $this->assertEquals(4,count($bugs));
    }


}

