<?php

/**
 * @datetime Helper
 */
class DateTimeHelperTest extends CIUnit_TestCase {

    public function setUp() {
        $this->CI->load->helper('datetime');
    }

    public function tearDown() {
        parent::tearDown();
    }



    public function test_h_dt_diff(){
        $this->assertEquals(h_dt_diff("",20131001000000),-1380556800);
        $this->assertEquals(h_dt_diff(null,20131002000000),-1380556800-86400);
        $this->assertEquals(h_dt_diff(20131001000000,""),1380556800);
        $this->assertEquals(h_dt_diff(20131002000000,null),1380556800+86400);
        $this->assertEquals(h_dt_diff("",null),0);
        $this->assertEquals(h_dt_diff(20131002000000,20131001000000),86400);
    }

    public function test_h_dt_add_month(){
        $res = h_dt_add_month("2012-3-1 00:00:00",3);
        $this->assertEquals($res, "20120601000000");
        $res = h_dt_add_month("2012-3-6 12:50:13",2);
        $this->assertEquals($res, "20120506125013");
        $res = h_dt_add_month("2012-2-1 12:50:13",1);
        $this->assertEquals($res, "20120301125013");
    }

    public function test_h_dt_start_time_of_hour() {
        $res = h_dt_start_time_of_hour("2012-3-6 12:50:13");
        $this->assertEquals($res, "20120306120000");
        $res = h_dt_start_time_of_hour("asdfa");
        $this->assertEquals($res, "");
    }

    public function test_h_dt_stop_time_of_hour() {
        $res = h_dt_stop_time_of_hour("2012-6-6 01:01:01");
        $this->assertEquals($res, "20120606015959");
        $res = h_dt_stop_time_of_hour("dj7uexxx");
        $this->assertEquals($res, "");
    }

    public function test_h_dt_start_time_of_day() {
        $res = h_dt_start_time_of_day("2012-6-6 01:01:01");
        $this->assertEquals($res, "20120606000000");
        $res = h_dt_start_time_of_day("2012-11-11 11:11:11");
        $this->assertEquals($res, "20121111000000");
        $res = h_dt_start_time_of_day("sdfess");
        $this->assertEquals($res, "");
    }

    public function test_h_dt_stop_time_of_day() {
        $res = h_dt_stop_time_of_day("2012-6-6 01:01:01");
        $this->assertEquals($res, "20120606235959");
        $res = h_dt_stop_time_of_day("2012-11-11 11:11:11");
        $this->assertEquals($res, "20121111235959");
        $res = h_dt_stop_time_of_day("sdfess");
        $this->assertEquals($res, "");
    }

    public function test_h_dt_start_time_of_month() {
        $res = h_dt_start_time_of_month("2012-3-6 12:50:13");
        $this->assertEquals($res, "20120301000000");
        $res = h_dt_start_time_of_month("asdfa");
        $this->assertEquals($res, "");
    }

    public function test_h_dt_stop_time_of_month() {
        $res = h_dt_stop_time_of_month("2012-4-6 12:50:13");
        $this->assertEquals($res, "20120430235959");
        $res = h_dt_stop_time_of_month("2012-2-6 12:50:13");
        $this->assertEquals($res, "20120229235959");
        $res = h_dt_stop_time_of_month("2011-2-6 12:50:13");
        $this->assertEquals($res, "20110228235959");
        $res = h_dt_stop_time_of_month("asdfa");
        $this->assertEquals($res, "");
    }

    //下个月的开始时间
    public function test_h_dt_next_month() {
        $res = h_dt_next_month("2011-2-6 12:50:13");
        $this->assertEquals($res, "20110301000000");
        $res = h_dt_next_month("2012-12-6 12:50:13");
        $this->assertEquals($res, "20130101000000");
        $res = h_dt_next_month("ddddddds");
        $this->assertEquals($res, "");
    }

    //上个月的开始时间
    public function test_h_dt_prev_month() {
        $res = h_dt_prev_month("2011-2-6 12:50:13");
        $this->assertEquals($res, "20110101000000");
        $res = h_dt_prev_month("2012-1-6 12:50:13");
        $this->assertEquals($res, "20111201000000");
        $res = h_dt_prev_month("ddddddds");
        $this->assertEquals($res, "");
    }

    //假如每行执行时间为1ms 有1/1000测试失败可能
    public function test_h_dt_now(){
        //用另外一种方法算出现在的时间 进行比较测试
        $now = new DateTime();
        $res = h_dt_now();
        $this->assertEquals($res,$now->format("YmdHis"));
    }
    
    //假如每行执行时间为1ms 有1/1000测试失败可能
    public function test_h_dt_yesterday(){
        //用另外一种方法算出昨天的时间 进行比较测试
        $t = new DateTime("-1 day");
        $res = h_dt_yesterday();
        $this->assertEquals($res,$t->format("YmdHis"));
    }
    
    //是否是今天
    public function test_h_dt_is_today() {
        $now = new DateTime();
        $res = h_dt_is_today($now->format("YmdHis"));
        $this->assertEquals($res,true);
        
//        $this->assertEquals($res,false);
//        
//        $this->assert($res, "20110206000000");
//        $res = h_dt_is_today("2012-1-6 12:50:13");
//        $this->assertEquals($res, "20111201000000");
//        $res = h_dt_is_today("ddddddds");
//        $this->assertEquals($res, "");
    }

    public function test_h_np1_day_sql() {
        $res = h_dt_np1_day_sql('20121216230000', 6, '2012-12-16');
        $this->assertEquals($res, 0);
        $res = h_dt_np1_day_sql('20121216230000', 6, '2012-12-09');
        $this->assertEquals($res, 0);
        $res = h_dt_np1_day_sql('20121215000000', 6, '2012-12-22');
        $this->assertEquals($res, 0);
        $res = h_dt_np1_day_sql('20121216230000', 6, '2012-12-15');
        $this->assertEquals($res, 1);
        $res = h_dt_np1_day_sql('20121215230000', 6, '2012-12-09');
        $this->assertEquals($res, 6);
    }

    //第二天的开始时间
    public function test_h_dt_start_time_of_tommorrow() {
        $res = h_dt_start_time_of_tommorrow('y2012-12-12');
        $this->assertEquals($res, "20121213000000");
        $res = h_dt_start_time_of_tommorrow('f20ss12-12-12 00:00:00');
        $this->assertEquals($res, "");
        $res = h_dt_start_time_of_tommorrow('10asdfasdf');
        $this->assertEquals($res, "");
        $res = h_dt_start_time_of_tommorrow("");
        $this->assertEquals($res, "");
        $res = h_dt_start_time_of_tommorrow('asdfasdf');
        $this->assertEquals($res, "");
        $res = h_dt_start_time_of_tommorrow('20121216235011');
        $this->assertEquals($res, 20121217000000);
        $res = h_dt_start_time_of_tommorrow('20121231235011');
        $this->assertEquals($res, 20130101000000);
    }


    public function test_h_dt_is_today_or_future(){
        $now = new DateTime();
        $res = h_dt_is_today_or_future($now->format("Ymd000000"));
        $this->assertEquals($res, true);
        $res = h_dt_is_today_or_future($now->format("Ymd235959"));
        $this->assertEquals($res, true);
        $now = new DateTime("-1 day");
        $res = h_dt_is_today_or_future($now->format("Ymd000000"));
        $this->assertEquals($res, false);
        $res = h_dt_is_today_or_future($now->format("Ymd235959"));
        $this->assertEquals($res, false);
        $now = new DateTime("+1 day");
        $res = h_dt_is_today_or_future($now->format("Ymd000000"));
        $this->assertEquals($res, true);
        $res = h_dt_is_today_or_future($now->format("Ymd235959"));
        $this->assertEquals($res, true);
        $now = new DateTime("+10 day");
        $res = h_dt_is_today_or_future($now->format("Ymd000000"));
        $this->assertEquals($res, true);
        $res = h_dt_is_today_or_future($now->format("Ymd235959"));
        $this->assertEquals($res, true);
        $res = h_dt_is_today_or_future("20370308000000");
        $this->assertEquals($res, true);
    }

    function test_h_dt_is_first_day_of_month(){
        $this->assertEquals(h_dt_is_first_day_of_month(20120701001000),true);
        $this->assertEquals(h_dt_is_first_day_of_month(20130708001000),false);
    }


    function test_h_dt_past_days_of_month(){
        $this->assertEquals(h_dt_past_days_of_month('20120808000000'),31);
        $this->assertEquals(h_dt_past_days_of_month('30000808000000'),0);
        $this->assertEquals(h_dt_past_days_of_month('now'),h_dt_format('now','d')+0);
    }

    //function test_h_dt_interval_month(){
        //$this->assertEquals(h_dt_interval_month('2013-5-2','2013-6-2'),1);
        //$this->assertEquals(h_dt_interval_month('2013-5-2','2013-6-1'),0);
        //$this->assertEquals(h_dt_interval_month('2013-5-2','2013-4-1'),-1);
        //$this->assertEquals(h_dt_interval_month('',''),'');
        //$this->assertEquals(h_dt_interval_month('2013-5-2',''),'');
        //$this->assertEquals(h_dt_interval_month('','2013-5-2'),'');
        //$this->assertEquals(h_dt_interval_month('fs','2013-5-2'),'');
        //$this->assertEquals(h_dt_interval_month('11111111111111111','2013-5-2'),'');
        //$this->assertEquals(h_dt_interval_month('-----------------','2013-5-2'),'');
    //}

    function test_h_dt_diff_mins(){
        $this->assertEquals(h_dt_diff_mins("20131001000000","20130930233000"),30);
        $this->assertEquals(h_dt_diff_mins("20131010000000","20130930233000"),30+9*1440);
        $this->assertEquals(h_dt_diff_mins("now","20130930233000"),floor((strtotime("now") - strtotime("20130930233000"))/60));
    }

}
