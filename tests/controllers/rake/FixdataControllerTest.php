<?php

/**
 * @Station Model
 */
class FixdataControllerTest extends CIUnit_TestCase {

    public function __construct($name = NULL, array $data = array(), $dataName = '') {
        parent::__construct($name, $data, $dataName);
    }

    public function tearDown() {
        parent::tearDown();
        $this->CI->db->query("truncate datas");
        $this->CI->db->query("truncate projects");
        $this->CI->db->query("truncate fixdatas");
        $this->CI->db->query("truncate daydatas");
        $this->CI->db->query("truncate monthdatas");
        $this->CI->db->query("truncate stations");
        $this->CI->db->query("truncate data_indexs");
        $this->dropDataTable("20130901_1_datas");
        $this->dropDataTable("20130901_2_datas");
        $this->dropDataTable("20130901_0_datas");
    }

    public function setUp() {
        parent::setUp();
        $this->CI = set_Controller("rake/fixdata");
        $this->CI->db->query("truncate datas");
        $this->CI->db->query("truncate projects");
        $this->CI->db->query("truncate fixdatas");
        $this->CI->db->query("truncate daydatas");
        $this->CI->db->query("truncate monthdatas");
        $this->CI->db->query("truncate stations");
        $this->CI->db->query("truncate data_indexs");
        $this->dropDataTable("20130901_1_datas");
        $this->dropDataTable("20130901_2_datas");
        $this->dropDataTable("20130901_0_datas");
    }


    public function test_makeFixDatasNmins(){
        echo __METHOD__."\n";
        $this->CI->mid_data->createDataTable("20130901_1_datas");
        $this->CI->db->query(" INSERT INTO `20130901_1_datas` 
            (`station_id`, `energy_main`, `energy_dc`, `create_time`) VALUES
            (1, 505.00, 315.00,  '2013-10-01 00:22:00'),
            (2, 505.00, 315.00,  '2013-10-01 00:05:00') ");
        $this->CI->data->changeTableName("20130901_1_datas");
        $datas = $this->CI->makeFixDatasNmins("20131001000000",30);
        $this->assertEquals(count($datas),2);
        $this->dropDataTable("20130901_1_datas");
    }


    public function test_fixOneDay(){
        echo __METHOD__."\n";
        $this->CI->db->query(" INSERT INTO `stations` (id,load_num,project_id,recycle,create_time) values 
            (1,20,1,1,20130601000000),
            (2,16,2,1,20130601000000),
            (3,20,2,1,20130601000000),
            (4,20,3,1,20130601000000),
            (5,77,4,1,20130601000000)"); 
        $this->CI->db->query(" INSERT INTO `data_indexs` (`id`,`from`,`to`,`project_id`,`table`) values 
            (1,'20130901000000','20141201000000',1,'20130901_1_datas'),
            (2,'20130901000000','20141201000000',2,'20130901_2_datas'),
            (3,'20130901000000','20141201000000',0,'20130901_0_datas')"); 
        $this->CI->mid_data->checkDataTables();
        $this->CI->db->query(" INSERT INTO `20130901_1_datas` 
            (`station_id`, `energy_main`, `energy_dc`, `create_time`) VALUES
            (2, 505.00, 315.00,  '2013-10-01 00:05:00') ");

        $this->CI->db->query(" INSERT INTO `20130901_2_datas` 
            (`station_id`, `energy_main`, `energy_dc`, `create_time`) VALUES
            (2, 305.00, 205.00,  '2013-10-01 00:00:00'),
            (3, 505.00, 315.00,  '2013-10-01 00:05:00')");

        $this->CI->db->query(" INSERT INTO `20130901_0_datas` 
            (`station_id`, `energy_main`, `energy_dc`, `create_time`) VALUES
            (4, 510.00, 348.00,  '2013-10-01 00:15:00'),
            (5, 600.00, 390.00,  '2013-10-01 00:30:00')");
        $this->CI->fixOneDay("20131001000000");
        $fixdatas = $this->CI->fixdata->findBy();
        $this->assertEquals(count($fixdatas),5);
        $this->assertEquals($fixdatas[0]['station_id'],2);


        $this->CI->db->query("drop table IF EXISTS 20130901_1_datas");
        $this->CI->db->query("drop table IF EXISTS 20130901_2_datas");
        $this->CI->db->query("drop table IF EXISTS 20130901_0_datas");
    }




    public function test_doCalcOneDay(){
        echo __METHOD__."\n";
        $this->CI->db->query(" INSERT INTO `stations` (id,load_num,recycle,create_time) values 
            (333,20,1,20130601000000),
            (658,16,1,20130601000000),
            (657,20,1,20130601000000),
            (555,20,1,20130601000000),
            (2250,77,1,20130601000000)"); 
        $this->CI->db->query(" INSERT INTO `fixdatas` 
            (`station_id`, `energy_main`, `energy_dc`, `energy_main_flag`, `energy_dc_flag`, `time`) VALUES
            (2250, 305.00, 205.00, 0, 0, '2013-07-08 00:00:00'),
            (2250, 505.00, 315.00, 0, 0, '2013-07-09 00:00:00'),
            (657, 500.00, 320.00, 0, 0, '2013-07-08 00:00:00'),
            (657, 510.00, 348.00, 0, 0, '2013-07-09 00:00:00'),
            (333, 10.00, 48.00, 0, 0, '2013-07-08 00:00:00'),
            (333, 10.00, 48.00, 0, 0, '2013-07-09 00:00:00'),
            (658, 500.00, 320.00, 0, 0, '2013-07-08 00:00:00'),
            (658, 600.00, 390.00, 0, 0, '2013-07-09 00:00:00')
            ");
        $this->CI->doCalcOneDay("2013-07-08 00:00:00");
        $this->CI->judgeOneDaydata("2013-07-08 00:00:00");
        $query = $this->CI->db->query("select * from daydatas");
        $hash = h_array_to_hash($query->result_array(),"station_id");
        $this->assertEquals($hash['2250']['main_energy'],200);
        $this->assertEquals($hash['2250']['dc_energy'],110);
        $this->assertEquals($hash['2250']['calc_type'],3);
        $this->assertEquals($hash['2250']['true_load_num'],76.388889);
        $this->assertEquals($hash['555']['calc_type'],1);
        //这个站点的总能耗为10 小于最低值 负载20A*1.44*0.75 = 21
        $this->assertEquals($hash['657']['main_energy'],10);
        $this->assertEquals($hash['657']['calc_type'],22);
        //这个站点的总能耗为100 和20A的负载不匹配 但和真实负载匹配 
        $this->assertEquals($hash['658']['main_energy'],100);
        $this->assertEquals($hash['658']['calc_type'],4);
        //总能耗有问题的
        $this->assertEquals($hash['333']['calc_type'],1);

    }



    public function test_initNp1stdday(){
        echo __METHOD__."\n";
        $day = h_dt_start_time_of_day('now');
        $this->CI->db->query("insert into stations (ns,ns_start,recycle,station_type) values 
            (1,".h_dt_add_day($day,0).",".ESC_NORMAL.",".ESC_STATION_TYPE_STANDARD."),
            (3,".h_dt_add_day($day,0).",".ESC_NORMAL.",".ESC_STATION_TYPE_NPLUSONE."),
            (5,".h_dt_add_day($day,5+1).",".ESC_NORMAL.",".ESC_STATION_TYPE_NPLUSONE."),
            (8,".h_dt_sub_day($day,8+1).",".ESC_NORMAL.",".ESC_STATION_TYPE_NPLUSONE."),
            (3,".h_dt_sub_day($day,3).",".ESC_NORMAL.",".ESC_STATION_TYPE_NPLUSONE."),
            (6,".h_dt_add_day($day,6+1+1).",".ESC_NORMAL.",".ESC_STATION_TYPE_NPLUSONE."),
            (9,".h_dt_add_day($day,1).",".ESC_NORMAL.",".ESC_STATION_TYPE_NPLUSONE.")");
        $this->CI->initNp1stdday($time_str = "now");
        $hash = h_array_to_hash($this->CI->np1stdday->findBy_sql(array()),"station_id");
        $this->assertEquals(count($hash),3);
    }



    public function testcalcOneMonthData(){
        echo __METHOD__."\n";
        $this->CI->db->query(" INSERT INTO `stations` (id,recycle,create_time) values 
            (657,1,20130601000000),
            (658,1,20130601000000),
            (2250,1,20130601000000)"); 
        $this->CI->db->query(" INSERT INTO `daydatas` (station_id,main_energy,day,calc_type) values 
            (657,251,20130710000000,3), 
            (657,251,20130711000000,4), 
            (657,251,20130712000000,3), 
            (657,251,20130713000000,3), 
            (657,251,20130714000000,3), 
            (657,251,20130715000000,3), 
            (657,251,20130716000000,3), 
            (657,251,20130717000000,3), 
            (657,251,20130718000000,3), 
            (657,251,20130720000000,3), 
            (657,251,20130721000000,3), 
            (657,251,20130722000000,3), 
            (657,251,20130723000000,3), 
            (657,251,20130724000000,3), 
            (657,251,20130725000000,3), 
            (657,251,20130726000000,3), 
            (657,251,20130727000000,3), 
            (657,251,20130728000000,3), 
            (658,456,20130530000000,3)"); 

        $this->CI->calcOneMonthData("2013-07-03");

        $res = $this->CI->monthdata->findOneBy_sql(array("station_id"=>657));
        $this->assertEquals($res['main_energy'],7781);
    }

    function test_basic(){
        echo __METHOD__."\n";
        $this->CI->go_0010();
        $this->CI->go_0600();
    }


    //=========================================================
    
    private function dropDataTable($name){
        $this->CI->db->query("drop table IF EXISTS ".$name);
    }


}





