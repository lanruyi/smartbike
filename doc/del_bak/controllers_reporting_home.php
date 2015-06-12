<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home_controller extends Backend_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('mid/mid_energy','data','area','project','station','daydata','savpair'));
        $this->load->helper(array('project','bug','report'));        
    }
    
    public function index(){
        //获得用户选择的项目
        $conditions = array();
        $conditions['project_id'] = $this->input->get('project_id')?$this-> input ->get('project_id'):4;
        $conditions['city_id'] = $this-> input ->get('city_id') ? $this-> input ->get('city_id'):40;
        $conditions['time_type'] = $this->input->get('time_type')?$this->input->get('time_type'):ESC_DAY;        
        $conditions['datetime'] = $this->input->get('datetime')? $this-> input ->get('datetime'): h_dt_readable_day("yesterday");
        $conditions['datetime'] = (ESC_DAY==$conditions['time_type'])?$conditions['datetime']: h_dt_date_str(h_dt_start_time_of_month($conditions['datetime']));
        
        $conditions['saving_func'] = ESC_SAV_STD_FUN_B;//以后重构
        $this->dt['conditions'] = $conditions;
        
        //获取项目名称供下拉菜单显示
        $this->dt['projects'] = $this->project->findBy_sql(array("is_product"=>1,"type"=>1));
        $this->dt['cities'] = $this->area->getCities_sql($conditions['project_id']);
        $this->dt['prj_cities'] = json_encode($this->project->getEachProjectCities_sql());
        $this->dt['project_name_chn'] = $this->project->getProjectNameChn($conditions['project_id']);
        $this->dt['city_name_chn'] = $this->area->getCityNameChn($conditions['city_id']);
        $this->dt['datetime_disp'] = (ESC_MONTH==$conditions['time_type'])?h_dt_date_str_no_day($conditions['datetime']):h_dt_date_str_no_time($conditions['datetime']);
        $time_type_array = h_report_time_type_array();
        $this->dt['time_type_disp'] =  $time_type_array[$conditions['time_type']];
        
        $this->dt['building_type_zhuan'] = ESC_BUILDING_ZHUAN;
        $this->dt['building_type_ban'] = ESC_BUILDING_BAN;
        
        $this->dt['sav_station_num'] = $this->saving->getOneKindStationNum(ESC_STATION_TYPE_SAVING,$conditions);
        $this->dt['std_station_num'] = $this->saving->getOneKindStationNum(ESC_STATION_TYPE_STANDARD,$conditions);
        $this->dt['com_station_num'] = $this->saving->getOneKindStationNum(ESC_STATION_TYPE_COMMON,$conditions);
        
        $this->dt['normal_sav_station_num'] = $this->saving->getOneKindStationNum(ESC_STATION_TYPE_SAVING,$conditions+array('error'=>null));
        $this->dt['normal_com_station_num'] = $this->saving->getOneKindStationNum(ESC_STATION_TYPE_COMMON,$conditions+array('error'=>null));
        
        $this->dt['sav_station_energy_save'] = $this->saving->getOneKindStationEnergySave(ESC_STATION_TYPE_SAVING,$conditions);
        $this->dt['com_station_energy_save'] = $this->saving->getOneKindStationEnergySave(ESC_STATION_TYPE_COMMON,$conditions);
        
        $this->load->view('templates/backend_header',$this->dt);
        $this->load->view('reporting/submenu'); 
        $this->load->view('reporting/home/menu'); 
        $this->load->view('reporting/table/sum'); 
        
        $this->load->view('templates/backend_footer');
    }
    
    public function set_sav_pairs(){
        $conditions = array();
        $conditions['project_id'] = $this->input->get('project_id')?$this->input->get('project_id'):4;
        $conditions['city_id'] = $this->input->get('city_id')?$this->input->get('city_id'):40;
        $conditions['datetime'] = $this->input->get('datetime')?$this->input->get('datetime'):h_dt_readable_day("yesterday");
        $conditions['building_type'] = $this->input->get('building')?$this->input->get('building'):ESC_BUILDING_ZHUAN;
        $conditions['datetime'] = h_dt_date_str(h_dt_start_time_of_month($conditions['datetime']));
        $this->dt['conditions'] = $conditions;
        
        $this->dt['projects'] = $this->project->findBy_sql(array("is_product"=>1,"type"=>1));
        $this->dt['cities'] = $this->area->getCities_sql($conditions['project_id']);

        $this->dt['prj_cities'] = json_encode($this->project->getEachProjectCities_sql());
        $this->dt['city_name_chn'] = $this->area->getCityNameChn($conditions['city_id']);
  
        $this->dt['backurl'] = $_SERVER["REQUEST_URI"];
        
        $pair_num = 4;
        $this->dt['pair_num'] = $pair_num;
        $this->dt['total_load_chn_array'] = h_station_total_load_array();
       
        //现有数据
        $this->dt['stations_pair_disp'] = $this->savpair->getDisplaySavPairs($conditions);
        //备选项
        $this->dt['station_select_array'] = $this->savpair->stationSelectArray($conditions);
        
        
        $this->load->view('templates/backend_header',$this->dt);
        $this->load->view('reporting/submenu'); 
        $this->load->view('reporting/home/set_sav_pairs'); 
        $this->load->view('templates/backend_footer');   

    }
    
    
    public function insert_to_savpair(){
        //$this->output->enable_profiler();
        //return;
        $conditions['project_id'] = $this->input->post('project_id');
        $conditions['city_id'] = $this->input->post('city_id');
        $conditions['datetime'] = $this->input->post('datetime');
        $conditions['building_type'] = $this->input->post('building_type'); 
        
        $saving_funcs = $this->project->getProjectSavingFunc($conditions['project_id']);
        
        //清除savpairs和savpairdatas中的数据
        $this->savpair->delSomeSavpairsandSavpairdatas($conditions);
        $this->savpair->initSavpairandSavpairdatas($conditions,$this->input->post("savpairs"),$saving_funcs);
        
        $this->loadleveldata->delSomeLoadleveldatas($conditions);         
        $this->loadleveldata->initLoadLevelDatas($conditions,$saving_funcs); 
        
        $this->saving->delSomeSavingDatas($conditions);
        $this->saving->initSavingDatas($conditions,$saving_funcs);
        
        redirect($this->input->post('backurl'));
    }

  
}
