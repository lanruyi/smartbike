<?php

/**
 * @Station Model
 */
class TFanControllerTest extends CIUnit_TestCase {

    public $c;
    protected $tables = array(
    );

    public function __construct($name = NULL, array $data = array(), $dataName = '') {
        parent::__construct($name, $data, $dataName);
    }

    public function tearDown() {
        parent::tearDown();
        $this->CI->db->query("truncate datas");
        $this->CI->db->query("truncate stations");
        $this->CI->db->query("truncate projects");
        $this->CI->db->query("truncate t_fandaydatas");
    }

    public function setUp() {
        $this->CI = set_controller("rake/t_fandaydata");
        parent::setUp();
        $this->CI->db->query("truncate datas");
        $this->CI->db->query("truncate stations");
        $this->CI->db->query("truncate projects");
        $this->CI->db->query("truncate t_fandaydatas");
    }

    //public function test_one_day(){
        //$this->CI->db->query(" INSERT INTO `projects` (id,is_product) values (4,1)"); 
        //for($i=0;$i<800;$i++){
            //$this->CI->db->query(" INSERT INTO `stations` (id,project_id,recycle,create_time) values 
                //(".($i+1).",4,1,20130601000000)"); 
        //}
        //$this->CI->one_day("20130820000000");
    //}

    public function test_some_station_one_day(){
        echo __METHOD__."\n";
        for($i=0;$i<800;$i++){
            $this->CI->db->query(" INSERT INTO `datas` (`station_id`, `fan_0_on`, `create_time`) VALUES
                (1, 1,    '2013-07-08 12:00:00'),
                (2, 0,    '2013-07-08 12:00:00'),
                (3, 1,    '2013-07-08 12:00:00'),
                (4, null,    '2013-07-08 12:00:00'),
                (5, null,    '2013-07-08 12:00:00'),
                (6, 1,    '2013-07-08 12:00:00')");
        }

        $this->CI->db->query(" INSERT INTO `datas` 
            (`station_id`, `fan_0_on`, `create_time`) VALUES
            (1, 0,    '2013-07-08 00:02:56'),
            (1, 1,    '2013-07-08 00:03:56'),
            (1, null, '2013-07-08 00:04:56'), 
            (1, 0,    '2013-07-08 00:05:56'),
            (1, 1,    '2013-07-08 00:06:56'),
            (1, null, '2013-07-08 00:07:56'), 

            (2, 0,    '2013-07-08 00:02:56'),
            (2, 0,    '2013-07-08 00:03:56'),
            (2, 0,    '2013-07-08 00:04:56'), 

            (3, 1,    '2013-07-08 00:02:56'),
            (3, 1,    '2013-07-08 00:03:56'),
            (3, 1,    '2013-07-08 00:04:56'), 

            (4, null, '2013-07-08 00:02:56'),
            (4, null, '2013-07-08 00:03:56'),
            (4, null, '2013-07-08 00:04:56'), 


            (5, 1,    '2013-07-08 00:02:56'),
            (5, 1,    '2013-07-08 00:03:56'),
            (5, null, '2013-07-08 00:04:56'), 

            (6, 1,    '2013-07-08 00:02:56'),
            (6, 0,    '2013-07-08 00:03:56'),
            (6, 0,    '2013-07-08 00:04:56'), 
            (6, 0,    '2013-07-08 07:03:00') ");
        $res=$this->CI->some_station_one_day(array(1,2,3,4,5,6),'20130708000000');
        $true_res = array("1"=>802,"2"=>0,"3"=>803,"4"=>0,"5"=>2,"6"=>801);
        foreach($res as $station){
            $this->assertEquals($station['fan_total'], $true_res[$station['station_id']]);
        }

    }

}





