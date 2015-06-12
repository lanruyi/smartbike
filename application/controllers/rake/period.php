<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Period_controller extends CI_Controller{

    function __construct()
    {
        parent::__construct();
        $this->load->library(array('curl','email'));
        $this->load->model(array('mid/mid_data','area','esg','station','weather','cmail','data','project','command','esg_command'));
        set_time_limit(0);
    }

    function __destruct() {
    }

    public function checkDatatables(){
        $this->mid_data->checkDatatables();
    }

    public function overTimeCommand(){
        $this->command->overTime();
        $this->esg_command->overTime();
    }
    
     public function set_aging_cmd() {
        $esgs = $this->esg->findBy_sql(array("aging_status"=>ESC_ESG_AGING_ING, "alive"=>ESC_ONLINE));
        if(!$esgs) {
            return;
        }

        $insert_aray=array();
        foreach ($esgs as $esg) {
            $insert_aray[] = $this->esg_command->set_test_cmd($esg['id'], date('h'));
        }

        $this->esg_command->insert_batch_cmd($insert_aray);
    }

    public function go_switch_nplus1_sql(){
        $c_ids = array();
        $tommorrow = h_dt_start_time_of_tommorrow("now");
        //查出所有n+1的基站 依次执行操作
        $stations = $this->station->findAllNp1Stations_sql();
        foreach($stations as $station){
            //看明天是什么日子 0是基准日 1是基准日后的第一个节能日 这两天是需要换模式的
            $result = h_dt_np1_day_sql($tommorrow, $station['ns'], $station['ns_start']);
            //如果明天是基准日
            if($result == 0){
                $c_ids[] = $this->command->newStCommand_mode3($station['id']);
            }
            //如果明天是节能日
            if($result == 1){
                $c_ids[] = $this->command->newStCommand_mode1($station['id']);
            }
        } 
        log_message('error',count($c_ids)." stations switch the status");
        return $c_ids;
    }

    public function go_send_mails(){
        log_message('error','[sendmail]');        
        return;
        $cmails = $this->cmail->findAllWaitCmails();
        foreach($cmails as $cmail){
            $send_start = strtotime("now");
            //------------- send mail by ci email ------------------//
            $this->email->clear();
            $this->email->from($cmail['from_add'],'Xiang.Chen Semos');
            $this->email->to($cmail['to_add']);
            $this->email->subject($cmail['subject']);
            $this->email->message($cmail['content']);
            $this->email->send();
            //echo $this->email->print_debugger();
            //------------- send mail by ci email ------------------//
            $send_stop = strtotime("now");
            $this->cmail->update(array("time_consume"=>$send_stop-$send_start,
                "real_send_time"=>  h_dt_now(),
                "status"=>ESC_CMAIL_STATUS__SENT));
        }
    }

    /*
     * todo 有空写个测试
     http://m.weather.com.cn/data/101190201.html 
    */ 
    public function go_get_city_weather(){
        $_cities = $this->area->findBy(array("type"=>ESC_AREA_TYPE_CITY));
        foreach ($_cities as $_city){
            $_w_json = $this->curl->simple_get('http://m.weather.com.cn/data/'.$_city['weather_code'].'.html');
            $_w_obj = json_decode($_w_json); 
            if ($_w_obj === null){
                echo 'error<br>http://m.weather.com.cn/data/'.$_city['weather_code'].'.html<br>';
                echo $_w_json.'<br>';
                continue;
            }
            $_wd_obj = $_w_obj->weatherinfo;
            for($i=0;$i<6;$i++){
                $tempname    = "temp".($i+1);
                $weathername = "weather".($i+1);
                $windname    = "wind".($i+1);
                $_day = $this->parse_date_str($_wd_obj->date_y,$i);
                $_weather = $this->weather->findOneBy_sql(array('city_id'=>$_city['id'],'day'=>$_day->format('Ymdhis')));
                $_w_id = 0;
                if(!$_weather){
                    $this->weather->new_sql(array("city_id"=>$_city['id'],
                        "day"=>$this->parse_date_str($_wd_obj->date_y,$i)->format('Ymdhis')));
                    $_w_id = $this->db->insert_id();
                }else{
                    $_w_id = $_weather['id'];
                }
                $this->weather->update_sql($_w_id,array("high_tmp"=>$this->parse_temp_str($_wd_obj->$tempname,"high"),
                    "low_tmp"=>$this->parse_temp_str($_wd_obj->$tempname,"low"),
                    "weather"=>$_wd_obj->$weathername,
                    "fx"=>$_wd_obj->$windname,
                    "type"=>0));
            }
        }
    }
    private function parse_temp_str($str,$type){
        $_tmp = explode("℃",$str);
        if($type === "high") return $_tmp[0];
        if($type === "low") return substr($_tmp[1],1);
    }
    private function parse_date_str($str,$plus){
        $datetime = new DateTime();
        $str = preg_replace('/年|月|日/i','/',$str);
        $date = explode("/", $str); 
        //$str = preg_replace('/日/i','',$str);
        //var_dump($date);
        $datetime->setDate($date[0], $date[1], $date[2]); 
        $datetime->add(new DateInterval('P'.$plus.'D'));
        return $datetime;
    }


    public function make_all_esg_fixed(){
        $this->esg->make_all_esg_fixed();
    }


}









