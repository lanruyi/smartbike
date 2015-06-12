<?php

class Mid_dataTestModel extends CIUnit_TestCase {

    protected $tables = array(
    );

    public function __construct($name = NULL, array $data = array(), $dataName = '') {
        parent::__construct($name, $data, $dataName);
    }

    public function setUp() {
        $this->CI->load->model(array('mid/mid_data','data'));
        parent::setUp();
        $this->CI->db->query("truncate np1stddays");
        $this->CI->db->query("truncate daydatas");
        $this->CI->db->query("truncate datas");
        $this->CI->db->query("truncate stations");
        $this->CI->db->query("truncate data_indexs");
        $this->CI->db->query("drop table IF EXISTS 20130901_1_datas");
        $this->CI->db->query("drop table IF EXISTS 20130901_2_datas");
        $this->CI->db->query("drop table IF EXISTS 20130901_0_datas");
        $this->CI->data->changeTableName("datas");
        $this->CI->cache->clean();
    }

    public function tearDown() {
        parent::tearDown();
        $this->CI->db->query("truncate np1stddays");
        $this->CI->db->query("truncate daydatas");
        $this->CI->db->query("truncate datas");
        $this->CI->db->query("truncate stations");
        $this->CI->db->query("truncate data_indexs");
        $this->CI->db->query("drop table IF EXISTS 20130901_1_datas");
        $this->CI->db->query("drop table IF EXISTS 20130901_2_datas");
        $this->CI->db->query("drop table IF EXISTS 20130901_0_datas");
        $this->CI->data->changeTableName("datas");
        $this->CI->cache->clean();
    }


    //public function test_autocheck(){
        //echo __METHOD__."\n";
        //$this->CI->db->query("insert into stations (id,project_id,load_num) values (1,2,30)");
        //$this->CI->db->query("insert into 20130901_2_datas (station_id,fan_0_on,colds_0_on,colds_1_on,power_dc,power_main,create_time) values 
            //(1, 1,1,1, 1800,1900,'20131211082300'),
            //(1, 1,1,0, 1800,1900,'20131211082400'),
            //(1, 1,0,0, 1800,1900,'20131211082500'),
            //(1, 0,0,0, 1800,1900,'20131211082600'),
            //(1, 0,0,0, 1800,1900,'20131211082700'),
            //(1, 0,0,0, 1800,1900,'20131211082800'),
            //(1, 1,0,0, 1800,1900,'20131211082900')");
        //echo $this->CI->autocheck(1,'20131211083000');
    //}

    public function test_autocheck(){
        echo __METHOD__."\n";
        $this->CI->db->query("insert into stations (id,project_id,load_num) values (1,2,30),(2,2,40),(3,2,50),(4,2,20),(5,2,30)");
        $this->CI->db->query(" INSERT INTO `data_indexs` (`id`,`from`,`to`,`project_id`,`table`) values 
            (1,'20130901000000','20251201000000',2,'20130901_2_datas')");
        $this->CI->mid_data->checkDataTables();
        //1正常 2dc小 3main小于dc 4main小 5main大
        $this->CI->db->query("insert into 20130901_2_datas (station_id,fan_0_on,colds_0_on,colds_1_on,power_dc,power_main,create_time) values 
            (1, 1,1,1, 1800,1900,".h_dt_sub_min('now',7)."),
            (1, 1,1,0, 1800,1900,".h_dt_sub_min('now',6)."),
            (1, 1,0,0, 1800,1900,".h_dt_sub_min('now',5)."),
            (1, 0,0,0, 4200,1900,".h_dt_sub_min('now',4)."),
            (1, 0,0,0, 1800,1900,".h_dt_sub_min('now',3)."),
            (1, 0,0,0, 1800,1900,".h_dt_sub_min('now',2)."),
            (1, 1,0,0, 1800,1900,".h_dt_sub_min('now',1)."),

            (2, 0,0,0, 1600,3600,".h_dt_sub_min('now',4)."),
            (2, 0,0,0, 1600,3600,".h_dt_sub_min('now',3)."),
            (2, 0,0,0, 1800,3600,".h_dt_sub_min('now',2)."),

            (3, 0,0,0, 3000,3600,".h_dt_sub_min('now',4)."),
            (3, 0,0,0, 3000,2800,".h_dt_sub_min('now',3)."),
            (3, 0,0,0, 3000,3600,".h_dt_sub_min('now',2)."),

            (4, 0,0,0, 1600,1200,".h_dt_sub_min('now',4)."),
            (4, 0,0,0, 1600,1600,".h_dt_sub_min('now',2)."),

            (5, 0,0,0, 1800,80000,".h_dt_sub_min('now',4)."),
            (5, 0,0,0, 1800,3600,".h_dt_sub_min('now',3)."),
            (5, 0,0,0, 1800,3600,".h_dt_sub_min('now',2)."),

            (7, 0,0,0, 1800,3600,".h_dt_sub_min('now').")");
        $this->assertEquals(null,$this->CI->mid_data->autocheck(1));
        $this->assertEquals('["dc_wrong"]',$this->CI->mid_data->autocheck(2));
        $this->assertEquals('["main_wrong"]',$this->CI->mid_data->autocheck(3));
        $this->assertEquals('["dc_wrong"]',$this->CI->mid_data->autocheck(4));
        $this->assertEquals('["main_wrong"]',$this->CI->mid_data->autocheck(5));
    }


    public function test_findLastStdDaydata(){
        echo __METHOD__."\n";
        $this->CI->db->query(" INSERT INTO `daydatas` (station_id,main_energy,day) values 
            (8,null,20130530000000), 
            (4,456,20130530000000)"); 
        $this->CI->db->query(" INSERT INTO `np1stddays` (station_id,datetime) values 
            (8,20130530000000), 
            (8,20130523000000), 
            (8,20130606000000), 
            (4,20130523000000), 
            (4,20130530000000), 
            (4,20130606000000)"); 
        $res = $this->CI->mid_data->findLastStdDaydata(4,"20130602000000");
        $this->assertEquals($res['main_energy'],456);
        $res = $this->CI->mid_data->findLastStdDaydata(8,"20130602000000");
        $this->assertEquals($res['main_energy'],null);
    }


    public function  test_findSavingDaydata_sql(){
        echo __METHOD__."\n";
        $this->CI->station->insert(array("station_type"=>ESC_STATION_TYPE_STANDARD));
        $res = $this->CI->mid_data->findSavingDaydata_sql(1,"20130308000000");
        $this->assertEquals("本站为基准站",$res['err']);

        $this->CI->station->insert(array("station_type"=>ESC_STATION_TYPE_SAVING));
        $res = $this->CI->mid_data->findSavingDaydata_sql(2,"20370308000000");
        $this->assertEquals("本日数据暂未统计",$res['err']);

        $this->CI->station->insert(array("station_type"=>ESC_STATION_TYPE_SAVING,"create_time"=>20130601000000));
        $res = $this->CI->mid_data->findSavingDaydata_sql(3,"20130318000000");
        $this->assertEquals("本日无数据(未建设)",$res['err']); 

        //$res = $this->CI->daydata->findSavingDaydata_sql(4,"20130318000000");
        //$this->assertEquals(" 本日数据统计有误",$res['err']); 
        //$res = $this->CI->daydata->findSavingDaydata_sql(5,"20130318000000");
        //$this->assertEquals(" 本日数据统计有误",$res['err']); 
        //$res = $this->CI->daydata->findSavingDaydata_sql(6,"20130318000000");
        //$this->assertEquals(" 本日数据统计有误",$res['err']); 
        //$res = $this->CI->daydata->findSavingDaydata_sql(7,"20130318000000");
        //$this->assertEquals(" 本日为基准日",$res['err']); 
        //$res = $this->CI->daydata->findSavingDaydata_sql(7,"20130310000000");
        //$this->assertEquals(" 往前找不到基准日",$res['err']); 
        //$res = $this->CI->daydata->findSavingDaydata_sql(7,"20130317000000");
        //$this->assertEquals(" 基准日统计数据有误",$res['err']); 
        //$res = $this->CI->daydata->findSavingDaydata_sql(7,"20130315000000");
        //$this->assertEquals(20,$res['std_ac_energy'] ); 
        //$this->assertEquals(2.00,$res['saving'] ); 
        //$this->assertEquals(10,$res['saving_p'] ); 
        //$res = $this->CI->daydata->findSavingDaydata_sql(8,"20130317000000");
        //$this->assertEquals( " 无可对比基准站",$res['err']); 
        //$res = $this->CI->daydata->findSavingDaydata_sql(9,"20130317000000");
        //$this->assertEquals( " 找不到基准站当天数据",$res['err']); 
        //$res = $this->CI->daydata->findSavingDaydata_sql(9,"20130318000000");
        //$this->assertEquals( " 基准站当天数据统计有误",$res['err']); 
        //$res = $this->CI->daydata->findSavingDaydata_sql(9,"20130316000000");
        //$this->assertEquals( " 基准站当天数据统计有误",$res['err']); 
        //$res = $this->CI->daydata->findSavingDaydata_sql(9,"20130315000000");
        //$this->assertEquals( " 基准站当天数据统计有误",$res['err']); 
        //$res = $this->CI->daydata->findSavingDaydata_sql(9,"20130301000000");
        //$this->assertEquals( 20,$res['std_ac_energy']);
        //$this->assertEquals( 70,$res['std_dc_energy']);
        //$this->assertEquals( 2.00,$res['saving']);
        //$this->assertEquals( 10.00,$res['saving_p']);
       
        //$this->assertEquals(0.0222,$res['contract_energy_saving_rate']); 
        //$this->assertEquals(0.0874,$res['contract_energy_saving_rate1']);
    }

    public function test_findLast(){
        echo __METHOD__."\n";
        $this->CI->db->query(" INSERT INTO `stations` (id,project_id,recycle,create_time,last_connect_time) values 
            (1,1,1,20130601000000,20131001000000),
            (2,2,1,20130601000000,20131001000000),
            (3,2,1,20130601000000,20131001000000),
            (4,3,1,20130601000000,20131001000000),
            (5,4,1,20130601000000,20131001000000)"); 
        $this->CI->db->query(" INSERT INTO `data_indexs` (`id`,`from`,`to`,`project_id`,`table`) values 
            (1,'20130901000000','20131101000000',1,'20130901_1_datas'),
            (2,'20130901000000','20131101000000',2,'20130901_2_datas'),
            (3,'20130901000000','20131101000000',0,'20130901_0_datas')"); 
        $this->CI->mid_data->checkDataTables();
        $this->CI->db->query(" INSERT INTO `20130901_1_datas` 
            (`station_id`, `energy_main`, `energy_dc`, `create_time`) VALUES
            (1, 505.00, 315.00,  '2013-10-01 00:05:00') ");
        $this->CI->db->query(" INSERT INTO `20130901_2_datas` 
            (`station_id`, `energy_main`, `energy_dc`, `create_time`) VALUES
            (2, 305.00, 205.00,  '2013-10-01 00:00:00'),
            (3, 505.00, 315.00,  '2013-10-01 00:05:00')");
        $this->CI->db->query(" INSERT INTO `20130901_0_datas` 
            (`station_id`, `energy_main`, `energy_dc`, `create_time`) VALUES
            (4, 510.00, 348.00,  '2013-10-01 00:15:00'),
            (5, 600.00, 390.00,  '2013-10-01 00:30:00')");
        $data = $this->CI->mid_data->findLast(1);
        $this->assertEquals($data['energy_main'],505); 
        $data = $this->CI->mid_data->findLast(2);
        $this->assertEquals($data['energy_main'],305); 
        $data = $this->CI->mid_data->findLast(4);
        $this->assertEquals($data['energy_main'],510); 
    }



    public function test_findRecentLast(){
        echo __METHOD__."\n";
        $this->CI->db->query(" INSERT INTO `stations` (id,project_id,recycle,create_time,last_connect_time) values 
            (2,1,1,20130601000000,20131001000000),
            (3,1,1,20130601000000,20131001000000),
            (4,3,1,20130601000000,20131001000000),
            (5,4,1,20130601000000,20131001000000)"); 
        $this->CI->db->query(" INSERT INTO `data_indexs` (`id`,`from`,`to`,`project_id`,`table`) values 
            (1,'20130901000000','20251201000000',1,'20130901_1_datas'),
            (3,'20130901000000','20251201000000',0,'20130901_0_datas')"); 
        $this->CI->mid_data->checkDataTables();
        $this->CI->db->query(" INSERT INTO `20130901_1_datas` 
            (`station_id`, `energy_main`, `energy_dc`, `create_time`) VALUES
            (2, 305.00, 205.00,  '".h_dt_sub_min('now',8)."'),
            (3, 505.00, 315.00,  '".h_dt_sub_min('now',15)."')");
        $this->CI->db->query(" INSERT INTO `20130901_0_datas` 
            (`station_id`, `energy_main`, `energy_dc`, `create_time`) VALUES
            (4, 510.00, 205.00,  '".h_dt_sub_min('now',9)."'),
            (5, 600.00, 390.00,  '2013-10-01 00:30:00')");
        $data = $this->CI->mid_data->findRecentLast(2);
        $this->assertEquals($data['energy_main'],305); 
        $data = $this->CI->mid_data->findRecentLast(3);
        $this->assertEquals($data,null); 
        $data = $this->CI->mid_data->findRecentLast(4);
        $this->assertEquals($data['energy_main'],510); 
    }


    public function test_errorSensorIndoorBroken(){
        echo __METHOD__."\n";
        $this->CI->db->query(" INSERT INTO `datas` 
            (`station_id`, `indoor_tmp`, `indoor_hum`, `create_time`) VALUES
            (1, null, 25.0,  ".h_dt_sub_min("now",1)."),
            (1, null, null,  ".h_dt_sub_min("now",2)."),
            (1, 35.0, 25.0,  ".h_dt_sub_min("now",3)."),
            (1, null, 25.0,  ".h_dt_sub_min("now",4)."),
            (2, 35.0, null,  ".h_dt_sub_min("now",2)."),
            (2, null, 25.0,  ".h_dt_sub_min("now",3)."),
            (2, 35.0, 25.0,  ".h_dt_sub_min("now",4)."),
            (3, 55.0, 35.0,  ".h_dt_sub_min("now",5).")");
        $bugs = $this->CI->mid_data->errorSensorIndoorBroken();
        $this->assertEquals(count($bugs),1);
    }

    public function test_errorSensorOutdoorBroken(){
        echo __METHOD__."\n";
        $this->CI->db->query(" INSERT INTO `datas` 
            (`station_id`, `outdoor_tmp`, `outdoor_hum`, `create_time`) VALUES
            (1, null, 25.0,  ".h_dt_sub_min("now",1)."),
            (1, null, null,  ".h_dt_sub_min("now",2)."),
            (1, 35.0, null,  ".h_dt_sub_min("now",3)."),
            (1, null, 25.0,  ".h_dt_sub_min("now",4)."),
            (1, 35.0, 25.0,  ".h_dt_sub_min("now",5)."),
            (3, null, 25.0,  ".h_dt_sub_min("now",1)."),
            (3, null, null,  ".h_dt_sub_min("now",2)."),
            (3, null, null,  ".h_dt_sub_min("now",3)."),
            (3, null, 25.0,  ".h_dt_sub_min("now",4)."),
            (3, 35.0, 25.0,  ".h_dt_sub_min("now",5)."),
            (2, 35.0, null,  ".h_dt_sub_min("now",2)."),
            (2, null, null,  ".h_dt_sub_min("now",3)."),
            (2, 35.0, null,  ".h_dt_sub_min("now",4)."),
            (3, 55.0, null,  ".h_dt_sub_min("now",5).")");
        $bugs = $this->CI->mid_data->errorSensorOutdoorBroken();
        $this->assertEquals(count($bugs),2);
        //测试有个站没有装外温感的情况
        $this->CI->db->query(" INSERT INTO `stations` (id,load_num,equip_with_outdoor_sensor,project_id,recycle) values 
            (2,16,1,2,1),
            (3,77,2,4,1)"); 
        $bugs = $this->CI->mid_data->errorSensorOutdoorBroken();
        $this->assertEquals(count($bugs),1);
    }

    public function test_errorSmartMeterBroken(){
        echo __METHOD__."\n";
        $this->CI->db->query(" INSERT INTO `datas` 
            (`station_id`, `power_main`,`power_dc`,`energy_main`,`energy_dc`, `create_time`) VALUES
            (1, 25, 25, 25, 25,   ".h_dt_sub_min("now",1)."),
            (1, 25, 25, 25, null, ".h_dt_sub_min("now",2)."),
            (1, 25, 25, null, 25, ".h_dt_sub_min("now",3)."),
            (1, 25, null, 25, 25, ".h_dt_sub_min("now",4)."),
            (2, 25, null, 25, 25, ".h_dt_sub_min("now",2)."),
            (2, 25, 25, 25, 25,   ".h_dt_sub_min("now",3)."),
            (2, 25, 25, 25, 25,   ".h_dt_sub_min("now",4)."),
            (3, 25, 25, 25, 25,   ".h_dt_sub_min("now",5).")");
        $bugs = $this->CI->mid_data->errorSmartMeterBroken();
        $this->assertEquals(count($bugs),1);
    }

    public function test_errorNoPower(){
        echo __METHOD__."\n";
        $this->CI->db->query(" INSERT INTO `datas` 
            (`station_id`, `power_main`,`power_dc`,`energy_main`,`energy_dc`, `create_time`) VALUES
            (1, 0, 45, 45, 45,   ".h_dt_sub_min("now",1)."),
            (1, -100, 45, 45, 45, ".h_dt_sub_min("now",2)."),
            (1, 0, 45, 45, 45, ".h_dt_sub_min("now",3)."),
            (1, 0, 43, 45, 45, ".h_dt_sub_min("now",4)."),
            (2, 0, 44, 45, 45, ".h_dt_sub_min("now",2)."),
            (2, 0, 45, 45, 45,   ".h_dt_sub_min("now",3)."),
            (2, 45, 45, 25, 25,   ".h_dt_sub_min("now",4)."),
            (3, 45, 45, 25, 25,   ".h_dt_sub_min("now",5).")");
        $bugs = $this->CI->mid_data->errorNoPower();
        $this->assertEquals(count($bugs),1);
    }

    public function test_errorSmartMeterReverse(){
        echo __METHOD__."\n";
        $this->CI->db->query(" INSERT INTO `datas` 
            (`station_id`, `power_main`,`power_dc`,`energy_main`,`energy_dc`, `create_time`) VALUES
            (1, 0, 45, 45, 45,   ".h_dt_sub_min("now",1)."),
            (1, -151, 45, 45, 45, ".h_dt_sub_min("now",2)."),
            (1, -150, 45, 45, 45, ".h_dt_sub_min("now",3)."),
            (1, -150, 43, 45, 45, ".h_dt_sub_min("now",4)."),
            (2, 0, 44, 45, 45, ".h_dt_sub_min("now",2)."),
            (2, 0, 45, 45, 45,   ".h_dt_sub_min("now",3)."),
            (2, 0, 45, 25, 25,   ".h_dt_sub_min("now",4)."),
            (3, 0, 45, 25, 25,   ".h_dt_sub_min("now",5).")");
        $bugs = $this->CI->mid_data->errorSmartMeterReverse();
        $this->assertEquals(count($bugs),1);
    }

    public function test_errorSensorBoxBroken(){
        echo __METHOD__."\n";
        $this->CI->db->query(" INSERT INTO `datas` 
            (`station_id`, `box_tmp`,`create_time`) VALUES
            (1, 0,    ".h_dt_sub_min("now",1)."),
            (1, null, ".h_dt_sub_min("now",2)."),
            (1, null, ".h_dt_sub_min("now",3)."),
            (1, null, ".h_dt_sub_min("now",4)."),
            (2, null, ".h_dt_sub_min("now",2)."),
            (2, null, ".h_dt_sub_min("now",3)."),
            (2, null, ".h_dt_sub_min("now",4)."),
            (2, 45,   ".h_dt_sub_min("now",4)."),
            (3, null, ".h_dt_sub_min("now",4)."),
            (3, 45,   ".h_dt_sub_min("now",5).")");
        $bugs = $this->CI->mid_data->errorSensorBoxBroken();
        $this->assertEquals(count($bugs),2);
        //测试有个站没有恒温柜的情况
        $this->CI->db->query(" INSERT INTO `stations` (id,have_box,project_id,recycle) values 
            (2,".ESC_HAVE_BOX_NONE.",2,1),
            (3,".ESC_HAVE_BOX.",4,1)"); 
        $bugs = $this->CI->mid_data->errorSensorBoxBroken();
        $this->assertEquals(count($bugs),1);
    }

    public function test_errorSensorColds0Broken(){
        echo __METHOD__."\n";
        $this->CI->db->query(" INSERT INTO `datas` 
            (`station_id`, `colds_0_tmp`,`create_time`) VALUES
            (1, 0,    ".h_dt_sub_min("now",1)."),
            (1, null, ".h_dt_sub_min("now",2)."),
            (1, null, ".h_dt_sub_min("now",3)."),
            (1, null, ".h_dt_sub_min("now",4)."),
            (2, null, ".h_dt_sub_min("now",2)."),
            (2, null, ".h_dt_sub_min("now",3)."),
            (2, null, ".h_dt_sub_min("now",4)."),
            (2, 45,   ".h_dt_sub_min("now",4)."),
            (3, null, ".h_dt_sub_min("now",4)."),
            (3, 45,   ".h_dt_sub_min("now",5).")");
        $bugs = $this->CI->mid_data->errorSensorColds0Broken();
        $this->assertEquals(count($bugs),2);
    }

    public function test_errorBoxHighTemp(){
        echo __METHOD__."\n";
        $this->CI->db->query(" INSERT INTO `datas` 
            (`station_id`, `box_tmp`,`create_time`) VALUES
            (1, 32, ".h_dt_sub_min("now",1)."),
            (1, 32, ".h_dt_sub_min("now",2)."),
            (1, 32, ".h_dt_sub_min("now",3)."),
            (1, 21, ".h_dt_sub_min("now",4)."),
            (2, 32, ".h_dt_sub_min("now",2)."),
            (2, 21, ".h_dt_sub_min("now",3)."),
            (2, 21, ".h_dt_sub_min("now",4)."),
            (2, 50, ".h_dt_sub_min("now",4)."),
            (3, 55, ".h_dt_sub_min("now",4)."),
            (3, 45, ".h_dt_sub_min("now",5).")");
        $bugs = $this->CI->mid_data->errorBoxHighTemp();
        $this->assertEquals(count($bugs),1);
    }


    public function test_errorSmartMeterBroken2(){
        echo __METHOD__."\n";
        $this->CI->db->query(" INSERT INTO `datas` 
            (`station_id`, `power_main`,`power_dc`,`create_time`) VALUES
            (1, 20,  145, ".h_dt_sub_min("now",1)."),
            (1, 20,  145, ".h_dt_sub_min("now",2)."),
            (1, 20,  145, ".h_dt_sub_min("now",3)."),
            (1, 20,  143, ".h_dt_sub_min("now",4)."),
            (2, 20,  144, ".h_dt_sub_min("now",2)."),
            (2, 20,  145, ".h_dt_sub_min("now",3)."),
            (2, 245, 145, ".h_dt_sub_min("now",4)."),
            (3, 245, 145, ".h_dt_sub_min("now",5).")");
        $bugs = $this->CI->mid_data->errorSmartMeterBroken2();
        $this->assertEquals(count($bugs),1);
    }


    public function test_errorSensorColds1Broken(){
        echo __METHOD__."\n";
        $this->CI->db->query(" INSERT INTO `datas` 
            (`station_id`, `colds_1_tmp`,`create_time`) VALUES
            (1, 0,    ".h_dt_sub_min("now",1)."),
            (1, null, ".h_dt_sub_min("now",2)."),
            (1, null, ".h_dt_sub_min("now",3)."),
            (1, null, ".h_dt_sub_min("now",4)."),
            (2, null, ".h_dt_sub_min("now",2)."),
            (2, null, ".h_dt_sub_min("now",3)."),
            (2, null, ".h_dt_sub_min("now",4)."),
            (2, 45,   ".h_dt_sub_min("now",4)."),
            (3, null, ".h_dt_sub_min("now",4)."),
            (3, 45,   ".h_dt_sub_min("now",5).")");
        $bugs = $this->CI->mid_data->errorSensorColds1Broken();
        $this->assertEquals(count($bugs),2);
        //测试有个站只有一台空调的情况
        $this->CI->db->query(" INSERT INTO `stations` (id,colds_num,project_id,recycle) values 
            (2,1,2,1),
            (3,2,4,1)"); 
        $bugs = $this->CI->mid_data->errorSensorColds1Broken();
        $this->assertEquals(count($bugs),1);
    }

    public function test_error485Die(){
        echo __METHOD__."\n";
        $this->CI->db->query(" INSERT INTO `datas` 
            (`station_id`,`indoor_tmp`,`indoor_hum`,`outdoor_tmp`,`outdoor_hum`,`colds_0_tmp`,
             `colds_1_tmp`,`power_main`,`power_dc`,`energy_main`,`energy_dc`,`create_time`) VALUES
            (1, null, null, null, null, null, null, null, null, null, null, ".h_dt_sub_min("now",1)."),
            (1, null, null, null, null, null, null, null, null, null, null, ".h_dt_sub_min("now",2)."),
            (1, null, null, null, null, null, null, null, null, null, null, ".h_dt_sub_min("now",3)."),
            (1, null, null, null, null, null, null, null, null, null, null, ".h_dt_sub_min("now",4)."),
            (2, null, null, null, null, null, null, null, null, null, null, ".h_dt_sub_min("now",2)."),
            (2, 0,    null, null, null, null, null, null, null, null, null, ".h_dt_sub_min("now",3)."),
            (2, null, 2,    null, null, null, null, null, null, null, null, ".h_dt_sub_min("now",4)."),
            (2, null, null, null, null, null, null, null, null, null, null, ".h_dt_sub_min("now",4)."),
            (3, null, null, null, null, null, null, null, null, null, null, ".h_dt_sub_min("now",4)."),
            (3, null, null, null, null, null, null, null, null, null, null, ".h_dt_sub_min("now",5).")");
        $bugs = $this->CI->mid_data->error485Die();
        $this->assertEquals(count($bugs),1);
    }

    public function test_errorIndoorHighTemp(){
        echo __METHOD__."\n";
        $this->CI->db->query(" INSERT INTO `datas` 
            (`station_id`, `indoor_tmp`,`create_time`) VALUES
            (1, 38, ".h_dt_sub_min("now",1)."),
            (1, 38, ".h_dt_sub_min("now",2)."),
            (1, 39, ".h_dt_sub_min("now",3)."),
            (1, 28, ".h_dt_sub_min("now",4)."),
            (2, 31, ".h_dt_sub_min("now",2)."),
            (2, 31, ".h_dt_sub_min("now",3)."),
            (2, 31, ".h_dt_sub_min("now",4)."),
            (2, 28, ".h_dt_sub_min("now",4)."),
            (3, 31, ".h_dt_sub_min("now",2)."),
            (3, 31, ".h_dt_sub_min("now",3)."),
            (3, 31, ".h_dt_sub_min("now",4)."),
            (3, 28, ".h_dt_sub_min("now",4)."),
            (4, 27, ".h_dt_sub_min("now",4)."),
            (4, 27, ".h_dt_sub_min("now",4)."),
            (4, 45, ".h_dt_sub_min("now",5).")");
        $bugs = $this->CI->mid_data->errorIndoorHighTemp();
        $this->assertEquals(count($bugs),1);
        //测试有个站没装恒温柜 有个站是基准站
        $this->CI->db->query(" INSERT INTO `stations` (id,have_box,station_type,project_id,recycle) values 
            (2,".ESC_HAVE_BOX_NONE.",".ESC_STATION_TYPE_SAVING.",  2,1),
            (3,".ESC_HAVE_BOX.",".ESC_STATION_TYPE_STANDARD.",4,1)"); 
        $bugs = $this->CI->mid_data->errorIndoorHighTemp();
        $this->assertEquals(count($bugs),3);
    }

    public function test_errorConnectWeak(){
        echo __METHOD__."\n";
        $this->CI->db->query(" INSERT INTO `datas` 
            (`station_id`,`create_time`) VALUES
            (1, ".h_dt_sub_min("now",1)."),
            (1, ".h_dt_sub_min("now",2)."),
            (1, ".h_dt_sub_min("now",3)."),
            (1, ".h_dt_sub_min("now",4)."),
            (1, ".h_dt_sub_min("now",5)."),
            (2, ".h_dt_sub_min("now",2)."),
            (2, ".h_dt_sub_min("now",3)."),
            (2, ".h_dt_sub_min("now",4)."),
            (2, ".h_dt_sub_min("now",4)."),
            (4, ".h_dt_sub_min("now",2)."),
            (4, ".h_dt_sub_min("now",3)."),
            (4, ".h_dt_sub_min("now",4)."),
            (4, ".h_dt_sub_min("now",4)."),
            (3, ".h_dt_sub_min("now",4)."),
            (3, ".h_dt_sub_min("now",4)."),
            (3, ".h_dt_sub_min("now",5).")");
        $bugs = $this->CI->mid_data->errorConnectWeak();
        $this->assertEquals(count($bugs),3);
    }

    public function test_cleanDupBugs(){
        echo __METHOD__."\n";
        $bugs[ESC_BUG__NO_POWER]              = array("2"=>"","3"=>"","4"=>""); 
        $bugs[ESC_BUG__SMART_METER_BROKEN_2]  = array("1"=>"","2"=>"","3"=>""); 

        $bugs[ESC_BUG__485_DIE]               = array("12"=>"","13"=>"","14"=>""); 
        $bugs[ESC_BUG__SENSOR_INDOOR_BROKEN]  = array("12"=>"","31"=>"","11"=>""); 
        $bugs[ESC_BUG__SENSOR_OUTDOOR_BROKEN] = array("12"=>"","31"=>"","11"=>""); 
        $bugs[ESC_BUG__SMART_METER_BROKEN]    = array("12"=>"","31"=>"","11"=>""); 
        $bugs[ESC_BUG__SENSOR_BOX_BROKEN]     = array("12"=>"","32"=>"","11"=>""); 
        $bugs[ESC_BUG__SENSOR_COLDS0_BROKEN]  = array("12"=>"","31"=>"","11"=>""); 
        $bugs[ESC_BUG__SENSOR_COLDS1_BROKEN]  = array("12"=>"","31"=>"","11"=>"");

        $res_bugs = $this->CI->mid_data->cleanDupBugs($bugs);
        $this->assertEquals($res_bugs[ESC_BUG__SMART_METER_BROKEN_2],array("1"=>""));
        $this->assertEquals($res_bugs[ESC_BUG__SENSOR_COLDS0_BROKEN],array("31"=>"","11"=>""));
        $this->assertEquals($res_bugs[ESC_BUG__SENSOR_BOX_BROKEN],array("32"=>"","11"=>""));

    }


    public function test_getBugs(){
        echo __METHOD__."\n";
        $this->CI->db->query(" INSERT INTO `datas` 
            (`station_id`, `power_main`,`power_dc`,`create_time`) VALUES
            (1, 20,  155, ".h_dt_sub_min("now",1)."),
            (1, 20,  155, ".h_dt_sub_min("now",2)."),
            (1, 20,  155, ".h_dt_sub_min("now",3)."),
            (1, 20,  153, ".h_dt_sub_min("now",4)."),
            (2, 45,  154, ".h_dt_sub_min("now",2)."),
            (2, 45,  155, ".h_dt_sub_min("now",3)."),
            (2, 45,  155, ".h_dt_sub_min("now",4)."),
            (3, 245, 145, ".h_dt_sub_min("now",5).")");
        $bugs = $this->CI->mid_data->getBugs();
        $this->assertEquals($bugs[ESC_BUG__SMART_METER_BROKEN_2],array("2"=>""));
        $this->assertEquals(count($bugs[ESC_BUG__SENSOR_INDOOR_BROKEN]),2);
    }

    public function test_singleColdsOutCtrl(){
        echo __METHOD__."\n";
        $this->CI->db->query("insert into stations (id,alive,recycle,have_box,air_volume) values 
            (4,".ESC_ONLINE.",1,".ESC_HAVE_BOX.",".ESC_STATION_VOLUME_3000."),
            (3,".ESC_ONLINE.",1,".ESC_HAVE_BOX.",".ESC_STATION_VOLUME_3000."),
            (2,".ESC_ONLINE.",1,".ESC_HAVE_BOX_NONE.",".ESC_STATION_VOLUME_1700."),
            (1,".ESC_ONLINE.",1,".ESC_HAVE_BOX_NONE.",".ESC_STATION_VOLUME_1700.")");
        $this->CI->db->query(" INSERT INTO `datas` 
            (`station_id`,`colds_0_on`, `colds_1_on`,`fan_0_on`,`power_main`,`power_dc`,`create_time`) VALUES
            (1, 0,0,0, 300, 155, 20130801060100),
            (1, 0,0,0, 300, 155, 20130801060200),
            (1, 0,0,0, 300, 155, 20130801060300),
            (1, 0,0,0, 300, 155, 20130801060400),
            (1, 0,0,0, 300, 153, 20130801060500),
            (1, 0,0,0, 300, 153, 20130801060600),
            (1, 0,0,0, 300, 153, 20130801060700),
            (1, 0,0,0, 300, 153, 20130801060800),
            (1, 0,0,0, 300, 153, 20130801060900),
            (1, 0,0,0, 300, 153, 20130801061000),
            (1, 0,0,0, 300, 153, 20130801061100),
            (1, 0,0,0, 300, 153, 20130801061200),
            (1, 0,0,0, 300, 153, 20130801061300),
            (1, 0,0,0, 300, 153, 20130801060000)");
        $bug = $this->CI->mid_data->singleColdsOutCtrl(1,$this->CI->data->findBy(array("station_id"=>1)));
        $this->assertEquals(ESC_BUG__HAS_OTHER_EQP,$bug['type']);

        $this->CI->db->query(" INSERT INTO `datas` 
            (`station_id`,`colds_0_on`, `colds_1_on`,`fan_0_on`,`power_main`,`power_dc`,`create_time`) VALUES
            (2, 0,0,0, 300, 255, 20130801060100),
            (2, 0,0,0, 300, 255, 20130801060200),
            (2, 0,0,0, 300, 255, 20130801060300),
            (2, 0,0,0, 300, 255, 20130801060400),
            (2, 0,0,0, 300, 253, 20130801060500),
            (2, 0,0,0, 300, 253, 20130801060600),
            (2, 0,0,0, 300, 253, 20130801060700),
            (2, 0,0,0, 300, 253, 20130801060800),
            (2, 0,0,0, 300, 253, 20130801060900),
            (2, 0,0,0, 300, 253, 20130801061000),
            (2, 0,0,0, 300, 253, 20130801061100),
            (2, 0,0,0, 300, 253, 20130801061200),
            (2, 0,0,0, 300, 253, 20130801061300),
            (2, 0,0,0, 300, 253, 20130801060000)");
        $bug = $this->CI->mid_data->singleColdsOutCtrl(2,$this->CI->data->findBy(array("station_id"=>2)));
        $this->assertEquals(0,$bug);

        $this->CI->db->query(" INSERT INTO `datas` 
            (`station_id`,`colds_0_on`, `colds_1_on`,`fan_0_on`,`power_main`,`power_dc`,`create_time`) VALUES
            (3, 0,0,1, 900, 55, 20130801060100),
            (3, 0,0,1, 900, 55, 20130801060200),
            (3, 0,0,1, 900, 55, 20130801060300),
            (3, 0,0,1, 900, 55, 20130801060400),
            (3, 0,0,1, 900, 53, 20130801060500),
            (3, 0,0,1, 900, 53, 20130801060600),
            (3, 0,0,1, 900, 53, 20130801060700),
            (3, 0,0,1, 900, 53, 20130801060800),
            (3, 0,0,1, 900, 53, 20130801060900),
            (3, 0,0,1, 900, 53, 20130801061000),
            (3, 0,0,1, 900, 53, 20130801061100),
            (3, 0,0,1, 900, 53, 20130801061200),
            (3, 0,0,1, 900, 53, 20130801061300),
            (3, 0,0,1, 900, 53, 20130801060000)");
        $bug = $this->CI->mid_data->singleColdsOutCtrl(3,$this->CI->data->findBy(array("station_id"=>3)));
        $this->assertEquals(ESC_BUG__HAS_OTHER_EQP,$bug["type"]);

        $this->CI->db->query(" INSERT INTO `datas` 
            (`station_id`,`colds_0_on`, `colds_1_on`,`fan_0_on`,`power_main`,`power_dc`,`create_time`) VALUES
            (4, 0,0,1, 600, 55, 20130801060100),
            (4, 0,0,1, 600, 55, 20130801060200),
            (4, 0,0,1, 600, 55, 20130801060300),
            (4, 0,0,1, 600, 55, 20130801060400),
            (4, 0,0,1, 600, 53, 20130801060500),
            (4, 0,0,1, 600, 53, 20130801060600),
            (4, 0,0,1, 600, 53, 20130801060700),
            (4, 0,0,1, 600, 53, 20130801060800),
            (4, 0,0,1, 600, 53, 20130801060900),
            (4, 0,0,1, 600, 53, 20130801061000),
            (4, 0,0,1, 600, 53, 20130801061100),
            (4, 0,0,1, 600, 53, 20130801061200),
            (4, 0,0,1, 600, 53, 20130801061300),
            (4, 0,0,1, 600, 53, 20130801060000)");
        $bug = $this->CI->mid_data->singleColdsOutCtrl(4,$this->CI->data->findBy(array("station_id"=>4)));
        $this->assertEquals(0,$bug);


        $this->CI->db->query(" INSERT INTO `datas` 
            (`station_id`,`colds_0_on`, `colds_1_on`,`fan_0_on`,`power_main`,`power_dc`,`create_time`) VALUES
            (2, 0,0,0, 2200, 155, 20130801060101),
            (2, 0,0,0, 2200, 155, 20130801060201),
            (2, 0,0,0, 2200, 155, 20130801060301),
            (2, 0,0,0, 2200, 155, 20130801060401),
            (2, 0,0,0, 2200, 153, 20130801060001)");
        $bug = $this->CI->mid_data->singleColdsOutCtrl(2,$this->CI->data->findBy(array("station_id"=>2)));
        $this->assertEquals(ESC_BUG__COLDS_OUT_CTRL,$bug["type"]);

        $this->CI->db->query(" INSERT INTO `datas` 
            (`station_id`,`colds_0_on`, `colds_1_on`,`fan_0_on`,`power_main`,`power_dc`,`create_time`) VALUES
            (4, 0,0,1, 2600, 55, 20130801060101),
            (4, 0,0,1, 2600, 55, 20130801060201),
            (4, 0,0,1, 2600, 55, 20130801060301),
            (4, 0,0,1, 2600, 55, 20130801060401),
            (4, 0,0,1, 2600, 53, 20130801060001)");
        $bug = $this->CI->mid_data->singleColdsOutCtrl(4,$this->CI->data->findBy(array("station_id"=>4)));
        $this->assertEquals(ESC_BUG__COLDS_OUT_CTRL,$bug["type"]);

        $errors = $this->CI->mid_data->errorColdsOutCtrl(array(1,2,3,4),$this->CI->data->findBy());
        $this->assertEquals(array_keys($errors[ESC_BUG__COLDS_OUT_CTRL]),array(2,4));
    } 













}
