<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Temp_controller extends CI_Controller{

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('mid/mid_rom','mid/mid_data','station','blog','correct',
            'bug','temp','esgconf','command','daydata','monthdata','rom_update',
            'batch','contract','esg','area','project'));
    }

    function index(){
    }


    function contract_batch_calc(){
        $this->contract->generate_phase_num();
        $this->batch->generate_batch_num();
        $stations = $this->station->findBy(array("recycle"=>ESC_NORMAL));

        foreach($stations as $station){
            if($station['stage']>10){
                $phase_num = floor($station['stage']/10);
                $contract = $this->contract->findOneBy(array(
                    "phase_num"=>$phase_num,"project_id"=>$station['project_id']));
                if($contract){
                    $batch_num = $station['stage']%10;
                    $batch = $this->batch->findOneBy(array(
                        "batch_num"=>$batch_num,
                        "contract_id"=>$contract['id'],
                        "city_id"=>$station['city_id']));
                    if($batch){
                        $this->station->update($station['id'],array("batch_id"=>$batch['id']));
                    }else{
                        echo "no batch $batch_num!\n";
                    }
                }else{
                    echo "no contract project ".$station['project_id']." phase".$phase_num."!\n";
                }
            }
        }
        
    }

    function recalc_correct(){
        $this->db->select('id');
        $stations = $this->station->findBy_sql(array("recycle"=>ESC_NORMAL));
        foreach ($stations as $station){
            $this->correct->calc_last_correct($station['id']);
            echo ".";
        }
        echo "\nfinish!!";
        return;
    } 

    
    public function stopHighTmpCommand(){
        $bugs = $this->bug->findBy_sql(array('type'=>ESC_BUG__INDOOR_TMP_HIGH,'status'=>ESC_BUG_STATUS__OPEN,'arg >='=>36));
        $count = $this->temp->count(array('key'=>'gw'));
        if($count){
            echo "上次未执行完成的操作，请重新设置 \n";
            return;
        }
        //找出基站类型
        $stationIds = array();
        $params_array = array();
        $params = array();
        $_params['command'] = "st";
        $_params['arg'] = "[\"\",\"\",\"\",\"\","
            ."\"\",\"\",\"\",\"\","
            ."\"\",\"\",\"\",\"\","
            ."\"\",\"\",\"\",\"\","
            ."10,8e\"\",\"\","
            ."\"\",\"\",\"\",\"\","
            ."\"\",\"\",\"\",\"\","
            ."\"\",\"\",\"\",\"\"]";
        foreach($bugs as $bug){
            $station = $this->station->find_sql($bug['station_id']);
            $esgconf = $this->esgconf->findOneBy_sql(array('station_id'=>$bug['station_id']));
            if($esgconf['sys_mode'] ==1 &&($station['station_type']==ESC_STATION_TYPE_SAVING || $station['station_type']==ESC_STATION_TYPE_COMMON)){
                array_push($stationIds,$bug['station_id']);
            }
        }
        foreach($stationIds as $stationId){
            $_params['station_id'] = $stationId;
            $params_array[$stationId] = $_params;
        }
        if(!$params_array){
            echo '没有高温的基站！';
            return ;
            }
        $this->command->insert_array($params_array);
        $_params = array();
        $_params['key'] = 'gw';
        $_params['value'] = implode(",",$stationIds);
        $this->temp->insert($_params);
        echo "finish stopHighTmp! (".count($stationIds).") \n";
    }
    
    public function rebootStation() {
        $stations = array(4226, 4229, 4232, 4233, 4234); 
        foreach ($stations as $item) {
            $station = $this->station->find_sql($item);
            $this->command->newREBCommand($item);      
        }
        
    }
    
    public function resetCommand(){
        $temp = $this->temp->findOneBy_sql(array('key'=>'gw'));
        if(!$temp){
            echo '请先设置后重启 \n';
            exit;
        }
        $stationIds = explode(",",$temp['value']);
        $params_array = array();
        $_params = array();
        $_params['command'] = "st";
        $_params['arg'] = "[\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",1,\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"]";
        foreach($stationIds as $stationId){
            $_params['station_id'] = $stationId;
            $params_array[$stationId] = $_params;
        }
        $this->command->insert_array($params_array);
        $this->temp->del_sql($temp['id']);
        echo 'finish reset!\n';
    }

    //重启南通35°以上的 2012-8-7
    public function rebootHighTmpCommand(){
        $bugs = $this->bug->findBy_sql(array('city_id'=>42,'arg >='=>35,'type'=>ESC_BUG__INDOOR_TMP_HIGH,'status'=>ESC_BUG_STATUS__OPEN));
        foreach($bugs as $bug){
            $this->command->newREBCommand($bug['station_id'],null);
            echo '#';
        }
    } 


    // 2014-07-01 按照朱峰的邮件要求，电池转换效率由0.9改为0.85，相应的负载与直流能耗的
    // 关系由1.44变为1.51倍的关系
    public function recalculate_day(){
        $this->db->query("update daydatas set true_load_num = dc_energy/1.51 where dc_energy is not null");
    }

    public function recalculate_month(){
        $this->db->query("update monthdatas set true_load_num = dc_energy/1.51/day(LAST_DAY(datetime)) where dc_energy is not null");
    }



    //一段时间内异常的站点
    public function abnormalData($time,$to_time='now'){
        $all_stations = $this->station->findAllStations();
        $station_problem = array();
        foreach($all_stations as $station){
            $station_problem[$station['id']] = 0;
            $from_time = h_dt_compare($time,$station['create_time'])?$time:$station['create_time'];
            $fixdatas = $this->fixdata->findStationFixdata($station['id'],$from_time,$to_time);
            $fixdata_hash = array();
            foreach($fixdatas as $fixdata){
                $fixdata_hash[date('YmdHis',strtotime($fixdata['time']))] = $fixdata;
            }
            $_t = h_dt_start_time_of_day($from_time);
            $repair_backup = array();
            $past_fixdata = null;
            while(!h_dt_compare($_t,$to_time)){
                if(!isset($fixdata_hash[$_t])){
                    $_t = h_dt_add_day($_t,1);
                    continue;
                }
                if(1==$fixdata_hash[$_t]['energy_main_flag'] || 2==$fixdata_hash[$_t]['energy_main_flag']){
                    if($past_fixdata){
                        if($past_fixdata['energy_main'] >= $fixdata_hash[$_t]['energy_main']){
                            $station_problem[$station['id']] += 1;
                        }
                    }
                    $past_fixdata = $fixdata_hash[$_t];
                }
                $_t = h_dt_add_day($_t,1);
            }
        }
        foreach($station_problem as $station_id => $p){
            if($p){
                echo $station_id." (".$p.") \n";
            }
        }
    }
    
     public function all_data($datetime){
         header("Content-Type:text/html; charset=utf-8");
         if (strlen($datetime) != 14) {
             echo "日期长度不对，比如2014-05-05 12：00：00的数据，应该填写为20140505120000，总共14个字符";
             return;
         }
         
         if ($datetime > h_dt_format("now")) {
             //echo iconv("utf-8","gbk","日期不能大于当前时间");
             echo "日期不能大于当前时间";
             return;
         }

        $areas = $this->area->findBy();
        echo   "点击城市名称即可下载指定时间前一时刻该地市每个基站的数据(点击完后需等待10s-20s左右的查询时间)," ."<br>"
                . "如需下载2014-05-05 12:00:00的数据，URL的最后一部分应填写为20140505120000，总共14个字符:"
                ."<br>"."<br>";
        echo "<br><br>》 以下按照运营项目的城市进行导出<br>";
        foreach($areas as $area){
            if ($area['father_id'] === '0') {
                echo "<a href='/rake/temp/download_xls_recent_data/".$area['id']."/".$datetime."'>".$area['name_chn']."</a>&nbsp&nbsp";
            }
        }      
        //获取整个项目某个时刻的数据，未完成测试
        // 按整个项目进行导出
//        $projects = $this->project->findAliveProjects();
//        echo "<br><br> 》以下按照运营项目进行导出<br>";
//        foreach($projects as $project){
//           echo "<a href='/rake/temp/download_xls_recent_data/".$project['id']."/".$datetime."'>".$project['name_chn']."</a><br>";
//        }      
        
    }
    
    public function download_xls_recent_data($city_id = 48, $datetime){
        $stations = $this->station->findBy_sql(array("city_id" => $city_id, "recycle"=>ESC_NORMAL,"status != "=> ESC_STATION_STATUS_REMOVE),
                        array("have_box DESC","create_time"));
        $city =  $this->area->findOneBy(array("id" => $city_id));

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$city['name_chn'].'.csv');
        header('Cache-Control: max-age=0');

        $title = array('create_time'=>'采集时间','name_chn'=>'基站名',
                        'constuct_time'=>'建站时间',
                        'district_name_chn'=>'区县',
                        'alive'=>"在线",'status'=>'状态',
                        'load_num'=>'负载(A)',
                        'station_type'=>'基站类型',
                        'have_box'=>'是否有恒温柜',
                        'box_type'=>'恒温柜类型',
                        'indoor_tmp'=>'室内温度','outdoor_tmp'=>'室外温度',
                        'indoor_hum'=>'室内湿度',
                        'box_tmp'=>'恒温柜温度0','box_tmp_1'=>'恒温柜温度1','box_tmp_2'=>'恒温柜温度2',
                        'colds_0_on'=>'空1','colds_1_on'=>'空2',
                        'fan_0_on'=>'风机状态','address_chn'=>'地址');
        
        $num = 0;
        foreach($stations as $station) {
                $data = $this->mid_data->findOneData( $station['id'],$datetime, array("station_id" => $station['id'], "create_time <=" => $datetime), array("create_time DESC"));
                $datas[$num]['create_time'] =  $data['create_time'];
                $datas[$num]['name_chn'] = $station['name_chn'];
                $datas[$num]['constuct_time'] = $station['create_time'];  
                $datas[$num]['district_name_chn'] = $this->area->getCityNameChn($station['district_id']);
                $datas[$num]['alive'] =  h_alive_name_chn($station['alive']);    
                $datas[$num]['status'] = h_station_status_name_chn($station['status']);
                $datas[$num]['load_num']  = $station['load_num'];
                $datas[$num]['station_type']  = h_station_station_type_name_chn($station['station_type']);
                $datas[$num]['have_box'] = h_station_have_box_name_chn($station['have_box']);
                $datas[$num]['box_type'] = h_station_box_type_name_chn($station['box_type']);
                $datas[$num]['indoor_tmp'] = $data['indoor_tmp'];
                $datas[$num]['outdoor_tmp'] = $data['outdoor_tmp'];
                $datas[$num]['indoor_hum'] =  $data['indoor_hum'];
                $datas[$num]['box_tmp'] =  $data['box_tmp'];
                $datas[$num]['box_tmp_1'] =  $data['box_tmp_1'];
                $datas[$num]['box_tmp_2'] =  $data['box_tmp_2'];
                $datas[$num]['colds_0_on'] =  $data['colds_0_on'];
                $datas[$num]['colds_1_on'] =  $data['colds_1_on'];
                $datas[$num]['fan_0_on'] =  $data['fan_0_on'];    
                $datas[$num]['address_chn'] = $station['address_chn'];
                $num++;
        }

        // 打开PHP文件句柄，php://output 表示直接输出到浏览器
        $fp = fopen('php://output', 'a');

        // 输出Excel列名信息
        $head = array();
        foreach($title as $v){
        // CSV的Excel支持GBK编码，一定要转换，否则乱码
            $head[] = iconv('utf-8', 'gbk', $v);
        }

        // 将数据通过fputcsv写到文件句柄
        fputcsv($fp, $head);
        foreach($datas as $data){
            $i=0;
            foreach($title as $num=>$field){
                $row[$i] = iconv('utf-8', 'gbk//TRANSLIT//IGNORE', $data[$num]);
                $i++;
            }            
            fputcsv($fp, $row);
        }
    }




    public function open_close_fan_test_zhenhua(){
        $config_item = $this->temp->findOneBy(array("key"=>"open_close_fan_test_zhenhua"));
        if($config_item){
            $config = json_decode($config_item['value'],true);
            $stations = $config['stations'];
            $open_time  = $config['open_time'];
            $close_time = $config['close_time'];
            foreach($stations as $station_id=>$station){
                if($station['on'] == 0 && h_dt_diff('now',$station['time']) >= $config['close_time']*60){

                    $arg= "[\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",". /*16*/
                            "10,7,\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"]";
                    $this->command->newStCommand($station_id,$arg);
                    $config['stations'][$station_id]['on'] = 1;
                    $config['stations'][$station_id]['time'] = h_dt_now();
                
                }else if($station['on'] == 1 && h_dt_diff('now',$station['time']) >= $config['open_time']*60){

                    $arg= "[\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",". /*16*/
                            "10,8,\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"]";
                    $this->command->newStCommand($station_id,$arg);
                    $config['stations'][$station_id]['on'] = 0;
                    $config['stations'][$station_id]['time'] = h_dt_now();
                }
            }
            $this->temp->update($config_item['id'],array("value"=>json_encode($config)));
        }
    }


    public function update_rom_test_chuanqi(){
        //$this->db->query();
        $config_item = $this->temp->findOneBy(array("key"=>"update_rom_test_chuanqi"));
        if($config_item){
            $config = json_decode($config_item['value'],true);
            $rom_1_id = $config['rom_1_id'];
            $rom_2_id = $config['rom_2_id'];
            $station_ids = $config['station_ids'];

            $station_id_array = explode(",",$station_ids);
            foreach($station_id_array as $station_id){
                //判断是否不在升级
                $station = $this->station->find($station_id);
                if($station){
                    if($this->rom_update->isFinishedRomUpdate($station_id)){
                        $rom_go_id = $station['rom_id'] == $rom_1_id ? $rom_2_id:$rom_1_id;
                        $this->mid_rom->startRomUpdate($station_id,$rom_go_id);
                    }
                }
            }

        }
    }


    public function download_xls_adds(){
        $stations = $this->station->findBy(array("project_id"=>2,"city_id"=>48,"recycle"=>ESC_NORMAL));
        foreach($stations as $station){
            echo "<a href='/rake/temp/download_xls/".$station['id']."'>".$station['name_chn']."</a><br>";
        }
        echo "<br>";
        echo "<br>";
        $stations = $this->station->findBy(array("project_id"=>104,"city_id"=>58,"recycle"=>ESC_NORMAL));

        foreach($stations as $station){
            echo iconv("UTF-8","GB2312","<a href='/rake/temp/download_xls/".$station['id']."'>".$station['name_chn']."</a><br>");
        }

    }

    public function download_xls($station_id = 3471){
        $station = $this->station->find_sql($station_id);
        $this->db->where(array("day >="=>"20130801000000", "day <"=>"20131001000000"));
        $datas = $this->daydata->findBy_sql(array('station_id'=>$station['id']));
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$station['name_chn'].'.csv');
        header('Cache-Control: max-age=0');

        $title = array('id'=>'基站id','name_chn'=>'基站名','day'=>'时间','main_energy'=>'总能耗','dc_energy'=>'dc能耗','ac_energy'=>'ac能耗','true_load_num'=>'真实负载','load_num'=>'负载',
            'total_load'=>'档位','station_type'=>'基站类型','colds_num'=>'空调个数','building'=>'建筑','have_box'=>'有无恒温柜','create_time'=>'建站时间','address_chn'=>'地址');
        
        foreach($datas as $k=>$data){
            $datas[$k]['id'] = $station['id'];
            $datas[$k]['name_chn'] = $station['name_chn'];
            $datas[$k]['total_load'] = h_station_total_load_name_chn($station['total_load']);
            $datas[$k]['station_type'] = h_station_station_type_name_chn($station['station_type']);
            $datas[$k]['colds_num'] = $station['colds_num'];
            $datas[$k]['building'] = h_station_building_name_chn($station['building']);
            $datas[$k]['have_box'] = h_station_box_type_name_chn($station['have_box']);
            $datas[$k]['create_time'] = $station['create_time'];
            $datas[$k]['address_chn'] = $station['address_chn'];
        }

        // 打开PHP文件句柄，php://output 表示直接输出到浏览器
        $fp = fopen('php://output', 'a');

        // 输出Excel列名信息
        $head = array();
        foreach($title as $v){
        // CSV的Excel支持GBK编码，一定要转换，否则乱码
            $head[] = iconv('utf-8', 'gbk', $v);
        }

        // 将数据通过fputcsv写到文件句柄
        fputcsv($fp, $head);
        foreach($datas as $data){
            $i=0;
            foreach($title as $k=>$field){
                $row[$i] = iconv('utf-8', 'gbk', $data[$k]);
                $i++;
            }            
            fputcsv($fp, $row);
        }
    }





    public function updateStationOldEsgs(){
        $this->esg->where("station_id > 0");
        $esgs = $this->esg->findBy();
        foreach($esgs as $esg){
            $this->station->where(array("id"=>$esg['station_id']));
            $this->station->where("old_esg_id is null");
            $this->station->updateBy(array("old_esg_id"=>$esg['id']));
        }
    }
    
    //将stations表中的name_chn左右去空格
    public function rm_left_right_trim_station(){
        $stations=$this->station->findBy();
        foreach($stations as $station){
            if($station){
                $tri_station_name_chn=trim($station['name_chn']);
                $this->station->update_sql($station['id'],array('name_chn'=>$tri_station_name_chn));
                }
            }
            echo '去除左右空格完成！给个赞！亲！';
        }
}


