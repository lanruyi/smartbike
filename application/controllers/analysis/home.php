<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home_controller extends Backend_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('data', 'station', 'area', 'project','daydata',
            'mid/mid_data','mid/mid_energy','savpair','t_optional_pair'));
    }

    public function index() {
        $this->dt['title'] = "基站最新数据";
        $this->dt['backurlstr'] = urlencode($_SERVER["REQUEST_URI"]);

        //获取所有城市和项目用于 页面上的下拉菜单显示    
        $this->dt['cities'] = $this->area->findby_sql(array('type'=>ESC_AREA_TYPE_CITY));
        $this->dt['projects'] = $this->project->findby_sql(array());

        //获取项目id和城市id 如果没有 给于默认值
        $project_id = $this->input->get('project_id') ? $this->input->get('project_id') : 4;
        $city_id = $this->input->get('city_id') ? $this->input->get('city_id') : 40;

        //同时把这两个值传给页面 用以显示下拉菜单的默认值
        $this->dt['project_id'] = $project_id;
        $this->dt['city_id'] = $city_id;

        //查出项目和城市 包含的所有基站(注意recycle = ESC_NORMAL)    
        $query = $this->db->query("select * from stations 
            where project_id=? and city_id = ? and recycle = ?", array($project_id, $city_id, ESC_NORMAL));
        $stations = $query->result_array();

        //查出每个站最新一条数据 拼在一个数组里 
        $result_datas = array();
        foreach ($stations as $station) {
            $query = $this->db->query("select * from datas 
                where station_id = ? order by create_time desc limit 1 ", array($station['id']));
            $datas = $query->result_array();
            if ($datas) {
                array_push($result_datas, $datas[0]);
            }
        }
        $this->dt['result_datas'] = $result_datas;

        //把所有数据的station_id转化为基站名station_name_chn
        foreach ($this->dt['result_datas'] as &$data) {
            $station = $this->station->find_sql($data['station_id']);
            $data['station_name_chn'] = $station['name_chn'];
        }

        $this->load->view('templates/analysis_header', $this->dt);
        $this->load->view('analysis/menu');
        $this->load->view('analysis/home/index');
        $this->load->view('templates/footer');
    }
  
    
    public function energy2(){
       //获取项目名称供下拉菜单显示
        $this->dt["projects"]  = $this->project->findBy_sql(array("is_product"=>1));
        
         //获得用户选择的项目
         $project_id = $this-> input ->get('project_id')?$this-> input ->get('project_id'):4;//江苏联通
         $project_date =  $this-> input ->get('projectdate')?h_dt_datetime_str_db($this-> input ->get('projectdate')): h_dt_readable_day("yesterday");
         $station_type = $this-> input ->get('station_type')?$this-> input ->get('station_type'):ESC_STATION_TYPE_STANDARD;//2
         $building = $this->input-> get('building')?$this->input->get('building'):ESC_BUILDING_ZHUAN;//1
                
         $ac_energy = $this->input->get('ac_energy');
         $dc_energy = $this->input->get('dc_energy');
         $sum_energy = $this->input->get('sum_energy');
         
         //  three checkbox
         $disp_mark = $this->input->get('disp_mark') ? $this->input->get('disp_mark') :"1-1-1";
         $this->dt['disp_mark_array'] = explode('-',$disp_mark);
         
        //显示给用户看的
         //时间
         $project_date_disp = $this->input->get("projectdate") ? $this->input->get("projectdate") : h_dt_readable_day("yesterday");
         $this->dt['project_select_date']=$project_date_disp;
         //项目名称
         $this->dt['project_id']= $project_id;
         $this->dt['project_name']=$this->project->getProjectNameChn($project_id);
        //基站类型
         $this->dt['station_type'] = $station_type;
         $temp = h_station_station_type_array();
         $this->dt['station_type_name'] = $temp[$station_type];
         //建筑类型
         $this->dt['building'] = $building;
         $temp =  h_station_building_array();
         $this->dt['building_name']=$temp[$building];

         
        //过滤出某一项目，某一能量级，某一基站类型的所有基站
        $stations_array = $this ->station->findBy_sql(array("project_id"=>$project_id,
                                                      "station_type"=>$station_type,
                                                      "building"=>$building,
                                                      "recycle"=>1),array("load_num"));
       
        //按照total_load进行分组
        $stations_group_by_total_load =  $this->station->group_by_total_load($stations_array);
        
        foreach($stations_group_by_total_load as $total_load =>$station_group){
            $data = array();
            //在以上基础下，过滤出某一天的基站的main_engergy,ac_energy,dc_energy
             foreach($station_group as $station){
                 $station_energy = $this->station->get_station_energy($station["id"],$project_date);
                $data[$station['id']]['main_energy'] = $station_energy ? $station_energy['main_energy']:0;
                $data[$station['id']]['ac_energy'] = $station_energy ? $station_energy['ac_energy']:0;
                $data[$station['id']]['dc_energy'] = $station_energy ? $station_energy['dc_energy']:0;
            //查找基站名与城市名称
                $data[$station['id']]['station_name_chn'] = $this->station->getStationNameChn($station["id"]);
                $data[$station['id']]['city_name'] = $this->area->getCityNameChn($station['city_id']);
                }
                $final_data[$total_load] = $data;
        }
       
        $this->dt['energy_level'] = h_station_total_load_array();
        $this->dt['result_datas'] = $final_data;
        
        $this->load->view('templates/analysis_header', $this->dt);
        $this->load->view('analysis/menu');  
        $this->load->view('analysis/home/energy2');
        $this->load->view('templates/footer');
        }
    


    function del_optinal_pair($pair_id){
        $this->t_optional_pair->del($pair_id);
        $this->session->set_flashdata('flash_succ', '删除成功!');
        redirect(urldecode($this->input->get('backurl')), 'location');
    }

    function add_optinal_pair(){
        //todo ============
        $sav_name_chn = $this->input->post("sav_name_chn");
        $std_name_chn = $this->input->post("std_name_chn");
        $project_id = $this->input->post("optional_project_id");
        $city_id = $this->input->post("optional_city_id");
        $sav_station = $this->station->findOneBy(array(
            "project_id" => $project_id, "city_id" => $city_id,"recycle"=>ESC_NORMAL,
            "name_chn"=> $sav_name_chn));
        $std_station = $this->station->findOneBy(array(
            "project_id" => $project_id, "city_id" => $city_id,"recycle"=>ESC_NORMAL,
            "name_chn"=> $std_name_chn));
        if($sav_station && $std_station){
            $this->t_optional_pair->insert(array(
                "project_id" => $project_id, "city_id" => $city_id,
                "building_type" => $std_station['building'], 
                "total_load" => $std_station['total_load'],
                "sav_station_id" => $sav_station['id'],
                "std_station_id" => $std_station['id']
            ));
            $this->session->set_flashdata('flash_succ', '成功!');
        }else{
            $this->session->set_flashdata('flash_err', '添加失败!');
        }
        redirect(urldecode($this->input->post('backurl')), 'location');
    }

    function optional_energy_compare(){
        //获取项目名称供下拉菜单显示
        $this->dt['projects'] = $this->project->findBy_sql(array("is_product"=>1));
        $this->dt['cities'] = $this->area->findBy_sql(array('type'=>ESC_AREA_TYPE_CITY));
           
        //获得用户选择的项目
        $project_id = $this->input->get('project_id')?$this->input->get('project_id'):4;
        $datetime   = h_dt_start_time_of_day($this->input->get('date')? $this->input->get('date'):"-1 day");
        $city_id    = $this->input->get('city_id') ? $this->input->get('city_id'):40;
        $this->dt['city_id'] = $city_id;    
        $this->dt['project_id'] = $project_id;
        $this->dt['datetime'] = $datetime; 

        //找出节能对
        $save_pairs = $this->t_optional_pair->findBy(
            array("project_id"=>$project_id,"city_id"=>$city_id),
            array("building_type asc","total_load asc"));       
        $pairs = array();
        foreach($save_pairs as $save_pair){
            $pair = $save_pair;
            $pair['std'] = $this->station->find($save_pair['std_station_id']);
            $pair['sav'] = $this->station->find($save_pair['sav_station_id']);
            $pair['std_daydata'] = $this->daydata->findOneBy(array("station_id"=>$save_pair['std_station_id'],"day"=>$datetime));
            $pair['sav_daydata'] = $this->daydata->findOneBy(array("station_id"=>$save_pair['sav_station_id'],"day"=>$datetime));
            $pair['rate'] = $this->mid_energy->calcDaySaveRate_JiangSu(
                $save_pair['std_station_id'],$save_pair['sav_station_id'],$datetime);
            $pairs[] = $pair;
        }

        $this->dt['pairs'] = $pairs;

        $this->load->view('templates/analysis_header', $this->dt);
        $this->load->view('analysis/menu');  
        $this->load->view('analysis/home/optional_energy_compare');
        $this->load->view('templates/footer');
    }

    function energy_compare(){
        //获取项目名称供下拉菜单显示
        $this->dt['projects'] = $this->project->findBy_sql(array("is_product"=>1));
        $this->dt['cities'] = $this->area->findBy_sql(array('type'=>ESC_AREA_TYPE_CITY));
           
        //获得用户选择的项目
        $project_id = $this->input->get('project_id')?$this->input->get('project_id'):4;
        $datetime   = h_dt_start_time_of_day($this->input->get('date')? $this->input->get('date'):"-1 day");
        $city_id    = $this->input->get('city_id') ? $this->input->get('city_id'):40;
        $this->dt['city_id'] = $city_id;    
        $this->dt['project_id'] = $project_id;
        $this->dt['datetime'] = $datetime; 

        //找出节能对
        $save_pairs = $this->savpair->findBy(
            array("project_id"=>$project_id,"city_id"=>$city_id,"datetime"=>h_dt_start_time_of_month($datetime)),
            array("building_type asc","total_load asc"));       
        $pairs = array();
        foreach($save_pairs as $save_pair){
            $pair = array();
            $pair['std'] = $this->station->find($save_pair['std_station_id']);
            $pair['sav'] = $this->station->find($save_pair['sav_station_id']);
            $pair['std_daydata'] = $this->daydata->findOneBy(array("station_id"=>$save_pair['std_station_id'],"day"=>$datetime));
            $pair['sav_daydata'] = $this->daydata->findOneBy(array("station_id"=>$save_pair['sav_station_id'],"day"=>$datetime));
            $pair['rate'] = $this->mid_energy->calcDaySaveRate_JiangSu(
                $save_pair['std_station_id'],$save_pair['sav_station_id'],$datetime);
            $pairs[] = $pair;
        }

        $this->dt['pairs'] = $pairs;

        $this->load->view('templates/analysis_header', $this->dt);
        $this->load->view('analysis/menu');  
        $this->load->view('analysis/home/energy_compare');
        $this->load->view('templates/footer');
    }

    function energy_consumption_sorted(){
        //获取项目名称供下拉菜单显示
        $this->dt['projects'] = $this->project->findBy_sql(array("is_product"=>1));
        $this->dt['cities'] = $this->area->findBy_sql(array('type'=>ESC_AREA_TYPE_CITY));
           
        //获得用户选择的项目
        $this->dt['project_id'] = $this-> input ->get('project_id')?$this-> input ->get('project_id'):4;
        $this->dt['city_id'] = $this-> input ->get('city_id') ? $this-> input ->get('city_id'):40;
        $this->dt['date'] =  $this-> input ->get('date')? $this-> input ->get('date'): h_dt_readable_day("yesterday");
        $this->dt['algorithm'] =  $this->input->get('algorithm')? $this->input->get('algorithm'):"rate1";

        //找出节能站
        $saving_station_array = $this->station->findBy_sql(array("project_id"=>$this->dt['project_id'],
                                                                 "city_id"=>$this->dt['city_id'],
                                                                 "station_type"=> ESC_STATION_TYPE_SAVING,
                                                                 "recycle"=>ESC_NORMAL),array("load_num"));       

        $standard_station_array = array();
        $saving_daydata_array = array();
        $saving_rates_array = array();
        $saving_rates1_array = array(); 
        $dc_energy_array = array();
        $std_dc_energy_array = array();

        foreach($saving_station_array as $station){
            $saving_daydata_array[$station["id"]] = $this->mid_data->findSavingDaydata_sql($station["id"],h_dt_date_str_db($this->dt['date'])); 
            $standard_station_array[$station["id"]] = $this->station->find_single_standard_station_sql($station);
           
              if(!$saving_daydata_array[$station["id"]]['err']){
                $saving_rates_array[$station["id"]] = $saving_daydata_array[$station["id"]]['contract_energy_saving_rate'];        
                $saving_rates1_array[$station["id"]] = $saving_daydata_array[$station["id"]]['contract_energy_saving_rate1'];

                $true_dc_load_num = round($saving_daydata_array[$station["id"]]['dc_energy'] * 0.67,1);//一天的能耗*1000/24/62
                $color = $true_dc_load_num > $station["load_num"]?"red":"black";
                $dc_energy_array[$station["id"]] = "<font color=".$color.">".$true_dc_load_num."</font>";
                
                
                $true_std_dc_load_num = round($saving_daydata_array[$station["id"]]['std_dc_energy'] * 0.67,1);
                $color = $true_std_dc_load_num < $standard_station_array[$station["id"]]["load_num"]?"red":"black";
                $std_dc_energy_array[$station["id"]] = "<font color=".$color.">".$true_std_dc_load_num."</font>";
            }else{
              
                $saving_rates_array[$station["id"]] = "未知";        
                $saving_rates1_array[$station["id"]] ="未知";
                $dc_energy_array[$station["id"]] = "未知";
                $std_dc_energy_array[$station["id"]] = "未知";
            }
           
        }
        asort($saving_rates_array);
        asort($saving_rates1_array);
        $sorted_by_rate_stations_array=array();
        $sorted_by_rate1_stations_array=array();

        foreach($saving_rates_array as $station_id =>$saving_rate ){
            $sorted_by_rate_stations_array[$station_id]=  $this->station->find_sql($station_id);
        }
        foreach($saving_rates1_array as $station_id =>$saving_rate ){
            $sorted_by_rate1_stations_array[$station_id]=  $this->station->find_sql($station_id);
        }    
       
        $this->dt['stations'] = $this->dt['algorithm']=="rate"? $sorted_by_rate_stations_array:$sorted_by_rate1_stations_array; 

        $this->dt['saving_daydata_array'] = $saving_daydata_array;
        $this->dt['standard_station_array'] = $standard_station_array; 
        $this->dt['dc_energy_array']= $dc_energy_array;
        $this->dt['std_dc_energy_array']= $std_dc_energy_array;

        $this->load->view('templates/analysis_header', $this->dt);
        $this->load->view('analysis/menu');  
        $this->load->view('analysis/home/energy_consumption_sorted');
        $this->load->view('templates/footer');
    }

    function energy_sav_vs_std(){
        //获取项目名称供下拉菜单显示
        $this->dt['projects'] = $this->project->findBy_sql(array("is_product"=>1));
        $this->dt['cities'] = $this->area->findBy_sql(array('type'=>ESC_AREA_TYPE_CITY));

        //获得用户选择的项目
        $project_id = $this-> input ->get('project_id')?$this-> input ->get('project_id'):4;
        $city_id = $this-> input ->get('city_id') ? $this-> input ->get('city_id'):40;
        $date =  $this-> input ->get('date')? $this-> input ->get('date'): h_dt_readable_day("yesterday");
        $building= $this->input-> get('building')?$this->input->get('building'):ESC_BUILDING_ZHUAN;//1

        $this->dt['project_id']=$project_id;
        $this->dt['project_name']=  $this->project->getProjectNameChn($project_id);     

        $this->dt['city_id']=$city_id;
        $this->dt['city_name'] = $this->area->getCityNameChn($city_id);

        $this->dt['building_type_chn'] = h_station_building_name_chn($building);
        $this->dt['building'] = $building;

        $this->dt['project_select_date']=$date;
        
        $ac_energy = $this->input->get('ac_energy');
        $dc_energy = $this->input->get('dc_energy');
        $sum_energy = $this->input->get('sum_energy');

        //  three checkbox
        $disp_mark = $this->input->get('disp_mark') ? $this->input->get('disp_mark') :"1-1-1";
        $this->dt['disp_mark_array'] = explode('-',$disp_mark);
        $this->dt['date'] =$date;

        //过滤出某一项目，某一城市，某一建筑类型的所有基准站
        $stations_array = $this->station->findBy_sql(array("project_id"=>$project_id,"city_id"=>$city_id,
            "building"=>$building,"station_type"=>ESC_STATION_TYPE_STANDARD,"recycle"=>ESC_NORMAL));

        //按照total_load进行分组
        $stations_group_by_total_load = $this->station->group_by_total_load($stations_array);
      
        foreach($stations_group_by_total_load as $total_load =>$station_group){
            $data = array();
            //在以上基础下，过滤出某一天的基站的main_engergy,ac_energy,dc_energy
            foreach($station_group as $station){
                
                $energy =  $this->station->get_station_energy($station['id'],$date);
                //var_dump($energy);
                $data[$station['id']]['main_energy'] = $energy ? $energy['main_energy']:0;
                $data[$station['id']]['ac_energy'] = $energy ? $energy['ac_energy']:0;
                $data[$station['id']]['dc_energy'] = $energy ? $energy['dc_energy']:0;
                //查找基站名
                $data[$station['id']]['station_name_chn'] =  $this->station->getStationNameChn($station["id"]);
            }
            $final_data[$total_load]["std_station"] = $data;
        }
        //过滤出某一项目，某一城市，某一建筑类型的所有标杆站
        $stations_array = $this->station->findBy_sql(array("project_id"=>$project_id,"city_id"=>$city_id,
            "building"=>$building,"station_type"=>ESC_STATION_TYPE_SAVING,"recycle"=>ESC_NORMAL));

        //按照total_load进行分组
        $stations_group_by_total_load =  $this->station->group_by_total_load($stations_array);
       

        foreach($stations_group_by_total_load as $total_load =>$station_group){
            $data = array();
            //在以上基础下，过滤出某一天的基站的main_engergy,ac_energy,dc_energy
            foreach($station_group as $station){
                $energy = $energy =  $this->station->get_station_energy($station['id'],$date);
                $data[$station['id']]['main_energy'] = $energy ? $energy['main_energy']:0;
                $data[$station['id']]['ac_energy'] = $energy ? $energy['ac_energy']:0;
                $data[$station['id']]['dc_energy'] = $energy ? $energy['dc_energy']:0;
                //查找基站名
                $data[$station['id']]['station_name_chn'] =  $this->station->getStationNameChn($station["id"]);
                //查找对应基准站
                 $std_station = $this->station->find_single_standard_station_sql($this->station->find_sql($station['id']));
                 $data[$station['id']]['std_station_id'] = $std_station["id"];
                 $data[$station['id']]['std_station_name_chn'] = $this->station->getStationNameChn($std_station["id"]);
            }
            $final_data[$total_load]["saving_station"] = $data;

        }
       
        $this->dt["final_data"] = $final_data;
        $this->dt['energy_level'] = h_station_total_load_array();
        //生成页面
        $this->load->view('templates/analysis_header', $this->dt);
        $this->load->view('analysis/menu');  
        $this->load->view('analysis/home/energy_sav_vs_std');
        $this->load->view('templates/footer');
    }


    public function test_dc_error(){
        $this->dt['title'] = 'DC负载错误的普通站';
        $this->dt['projects'] = $this->project->findBy();
        $this->dt['cities'] = $this->input->get('project_id')?$this->area->findProjectCities($this->input->get('project_id')):$this->area->findBy(array('type'=>ESC_AREA_TYPE_CITY));
        $project_id = $this->input->get('project_id')?$this->input->get('project_id'):4;
        $city_id    = $this->input->get('city_id')?$this->input->get('city_id'):40;
        $this->dt['project_id'] = $project_id;
        $this->dt['city_id'] = $city_id;
        $this->dt['city'] = $this->area->find_sql($city_id);


        $this->dt['sort_stations'] = array("3"=>"4","2"=>"16","7"=>1);
        ksort($this->dt['sort_stations']);
        $this->dt['disp_stations'] = array(
            "3" => array('name_chn'=>"Ast3",'load_num'=>"7",'load_num_1'=>"8",
                        'delta_1'=>"1",'load_num_7'=>"11.27897",'delta_7'=>"4.27897",'load_num_15'=>"9",'delta_15'=>"2"),
            "7" => array('name_chn'=>"Ast7",'load_num'=>"10",'load_num_1'=>"8",
                        'delta_1'=>"-2",'load_num_7'=>"11",'delta_7'=>"1",'load_num_15'=>"9",'delta_15'=>"-1"),
            "2" => array('name_chn'=>"Ast2",'load_num'=>"18",'load_num_1'=>"1",
                        'delta_1'=>"-17",'load_num_7'=>"2",'delta_7'=>"-16",'load_num_15'=>"3",'delta_15'=>"-15")
        );

        $this->load->view('templates/analysis_header', $this->dt);  
        $this->load->view('analysis/menu');
        $this->load->view('analysis/home/dc_error');
        $this->load->view('templates/footer');
    }

    public function dc_error(){
        $this->dt['title'] = 'DC负载错误的基站';
        $this->dt['projects'] = $this->project->findBy(array());
        $this->dt['cities'] = $this->input->get('project_id')?$this->area->findProjectCities($this->input->get('project_id')):$this->area->findBy(array('type'=>ESC_AREA_TYPE_CITY));

        $project_id = $this->input->get('project_id')?$this->input->get('project_id'):4;
        $city_id    = $this->input->get('city_id')?$this->input->get('city_id'):40;
        $this->dt['project_id'] = $project_id;
        $this->dt['city_id'] = $city_id;

        $this->dt['city'] = $this->area->find($city_id);
        $select_str = "id,name_chn,load_num,building,station_type,status";
        $this->db->select($select_str);
        $common_stations = $this->station->findBy(array("project_id"=>$project_id,"city_id"=>$city_id,"recycle"=>ESC_NORMAL,"station_type"=>ESC_STATION_TYPE_COMMON));
        $this->db->select($select_str);
        $saving_stations = $this->station->findBy(array("project_id"=>$project_id,"city_id"=>$city_id,"recycle"=>ESC_NORMAL,"station_type"=>ESC_STATION_TYPE_SAVING));
        $this->db->select($select_str);
        $standard_stations = $this->station->findBy(array("project_id"=>$project_id,"city_id"=>$city_id,"recycle"=>ESC_NORMAL,"station_type"=>ESC_STATION_TYPE_STANDARD));

        $stations = array_merge($saving_stations,$standard_stations,$common_stations);



        $station_ids = h_array_to_id_array($stations);

        $load_num_1s  = $this->daydata->get_n_day_load_num(1,$station_ids); 
        $load_num_7s  = $this->daydata->get_n_day_load_num(7,$station_ids); 
        $load_num_15s = $this->daydata->get_n_day_load_num(15,$station_ids); 

        $disp_stations = array();
        $sort_stations = array();

        foreach($stations as $station){
            $station_id = $station['id'];

            $s = array();
            $s += $station;
            $s['load_num_1']  = isset($load_num_1s[$station_id])  ? $load_num_1s[$station_id]:null; 
            $s['delta_1']     = isset($load_num_1s[$station_id])  ? $load_num_1s[$station_id] - $station['load_num']:null; 

            $s['load_num_7']  = isset($load_num_7s[$station_id])  ? $load_num_7s[$station_id]:null; 
            $s['delta_7']     = isset($load_num_7s[$station_id])  ? $load_num_7s[$station_id] - $station['load_num']:null; 

            $s['load_num_15'] = isset($load_num_15s[$station_id]) ? $load_num_15s[$station_id]:null; 
            $s['delta_15']    = isset($load_num_15s[$station_id]) ? $load_num_15s[$station_id] - $station['load_num']:null; 
            $disp_stations[$station_id] = $s;

            $delta7 = isset($load_num_7s[$station_id])? abs($load_num_7s[$station_id] - $station['load_num']) : 0;
            $sort_stations[$station_id] = $delta7;
        }

        arsort($sort_stations); 

        $this->dt['sort_stations'] = $sort_stations;
        $this->dt['disp_stations'] = $disp_stations;

        $this->load->view('templates/analysis_header', $this->dt);  
        $this->load->view('analysis/menu');
        $this->load->view('analysis/home/dc_error');
        $this->load->view('templates/footer');
    }

    public function energy_sort($cur_page = 1){
        $this->dt['title']="能耗排序";

        $project_id = $this->input->get("project_id")?$this->input->get("project_id"):4;
        $city_id    = $this->input->get("city_id");
        $building   = $this->input->get("building")?$this->input->get("building"):ESC_BUILDING_BAN;
        $load_level = $this->input->get("total_load")?$this->input->get("total_load"):ESC_TOTAL_LOAD_20A30A;
        $datetime = h_dt_format($this->input->get("date")?$this->input->get("date"):"-1 day");

        $per_page = $this->input->get("per_page")?$this->input->get("per_page"):20;

        $this->dt['project_id'] = $project_id;
        $this->dt['city_id']    = $city_id;
        $this->dt['datetime']   = $datetime;
        $this->dt['building']   = $building;
        $this->dt['load_level'] = $load_level;
        $this->dt['projects']   = $this->project->findBy(array());
        $this->dt['cities']     = $this->area->findBy(array());
        
        //找出需要进行能耗排序的站点
        if($city_id){
            $param['city_id'] = $city_id; 
        }
        $param['project_id'] = $project_id; 
        $param['total_load'] = $load_level; 
        $param['building']   = $building; 
        $this->station->where("station_type in (".ESC_STATION_TYPE_SAVING.",".ESC_STATION_TYPE_COMMON.")");
        $stations = $this->station->findBy($param);
        
        if(!$stations){ exit("no stations");}


        $conditions = array("day "=>$datetime);

        $this->daydata->where("station_id in (".implode(",",h_array_to_id_array($stations)).")"); 
        $config['total_rows'] = $this->daydata->pagination_num($conditions);

        $config['base_url'] = '/analysis/home/energy_sort';
        $config['suffix'] = "?".$_SERVER['QUERY_STRING'];
        $config['first_url'] = $config['base_url'].$config['suffix'];
        $config['per_page'] = $per_page; 
        $this->pagination->initialize($config); 

        $orders = array("xxx desc");
        $this->dt['pagination'] = $this->pagination->create_links();
        $this->dt['filter_num_str'] = h_filter_num_str($config['total_rows'],$cur_page,$per_page);

        $this->daydata->select("station_id,main_energy,load_num,(main_energy/load_num) as xxx");
        $this->daydata->where("station_id in (".implode(",",h_array_to_id_array($stations)).")"); 
        $daydatas = $this->daydata->pagination($conditions,$orders,$per_page,$cur_page);
        foreach($daydatas as $key => $daydata){
            $station = $this->station->find($daydata['station_id']);
            $daydatas[$key]['station'] = $station;
            $daydatas[$key]['city'] = $this->area->find($station['city_id']);
        }
        
        $this->dt['daydatas'] = $daydatas;

        $this->load->view('templates/analysis_header', $this->dt);  
        $this->load->view('analysis/menu');
        $this->load->view('analysis/home/energy_sort');
        $this->load->view('templates/footer');
    }




}
