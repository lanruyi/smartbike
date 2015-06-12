/********************************
[Controller Station]
./../models/Entities/Station.php 
./../models/station.php
./../../tests/controllers/StationControllerTest.php
********************************/

class Station_controller extends Frontend_Controller{

    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('station','statistics'));
        $this->load->model(array('statistics','data','station','warning','weather','area'));
    }

    public function index(){
        redirect('/station/realtime/16', 'location');
    }

    public function home(){
        $viewdata['title'] = "index";
		
		$current['city_id'] = $this->input->get("city_id");
		
		$viewdata['current'] = $current;
		
		$this->load->view('templates/frontend_header', $viewdata);
		$this->load->view('frontend/stations/home');
        $this->load->view('templates/frontend_footer');
    }

    public function station_list(){


        $viewdata['title'] = "station";
        $viewdata['cities'] = $this->area->findAllCities();
        $current_con = array();
        if($this->input->get("city_id"))   $current_con['city_id'] = $this->input->get("city_id");
        if($this->input->get("total_load"))   $current_con['total_load'] = $this->input->get("total_load");
        if($this->input->get("building"))   $current_con['building'] = $this->input->get("building");
        if($this->input->get("station_type"))   $current_con['station_type'] = $this->input->get("station_type");
        $viewdata['current_con'] = $current_con;

        $stations = $this->station->findBy(array("project"=>$this->current_project,'recycle'=>ESC_NORMAL)+$current_con,array("display_order"=>"desc"));
        $viewdata['stations'] = $stations;

        $this->load->view('templates/frontend_header', $viewdata);
        $this->load->view('frontend/stations/menu');
        $this->load->view('frontend/stations/station_list');
        $this->load->view('templates/frontend_footer');
    }


    public function station_map(){

        $viewdata['title'] = "Map";

        $viewdata['cities'] = $this->project->getCities($this->current_project);
        $current_con = array();
        if($this->input->get("city_id"))   $current_con['city_id'] = $this->input->get("city_id");
        if($this->input->get("total_load"))   $current_con['total_load'] = $this->input->get("total_load");
        if($this->input->get("building"))   $current_con['building'] = $this->input->get("building");
        if($this->input->get("station_type"))   $current_con['station_type'] = $this->input->get("station_type");
        $viewdata['current_con'] = $current_con;

        //rewrite by DQL later
        if(!$project = $this->current_project){
        	echo "no current project";return;
		}

		// end /////////////////
        
        $stations = $this->station->findBy(array("project"=>$project,'recycle'=>ESC_NORMAL)+$current_con);

        $viewdata['stations'] = $stations;

        $this->load->view('templates/frontend_header', $viewdata);
        $this->load->view('frontend/stations/menu');
        $this->load->view('frontend/stations/map');
        $this->load->view('templates/frontend_footer');
    }

	public function station_sort(){

		$viewdata['title'] = "Sort";
        $viewdata['cities'] = $this->area->findBy(array("type"=>0));
        $current_con = array();
        if($this->input->get("city_id"))   $current_con['city_id'] = $this->input->get("city_id");
        if($this->input->get("total_load"))   $current_con['total_load'] = $this->input->get("total_load");
        if($this->input->get("building"))   $current_con['building'] = $this->input->get("building");
        if($this->input->get("station_type"))   $current_con['station_type'] = $this->input->get("station_type");
        $viewdata['current_con'] = $current_con;
 
        //rewrite by DQL later
        if(!$project = $this->current_project){
        	echo "no current project";return;
		}
        
        $stations = $this->station->findBy(array("project"=>$project,'recycle'=>ESC_NORMAL)+$current_con);
        
        $viewdata['stations'] = $stations;
		
		$debug = $this->input->get('debug')?1:0; //for test
		$_statistic_style = $this->input->get("style")?$this->input->get("style"):'d';
		$_statistic_duration = $this->input->get("duration")?$this->input->get("duration"):0;
		$viewdata['statistic_style'] = $_statistic_style;
		$viewdata['statistic_duration'] = $_statistic_duration;
		       
        $sort_con = array();
		$sort_con['energy_main'] = $this->input->get("energy_main");
		$sort_con['energy_ac'] = $this->input->get("energy_ac");
		$sort_con['energy_dc'] = $this->input->get("energy_dc");
		$sort_con['ac_sav'] = $this->input->get("ac_sav");
		$sort_con['ac_sav_rate'] = $this->input->get("ac_sav_rate");			
		$sort_con['ac_main_rate'] = $this->input->get("ac_main_rate");
		$viewdata['sort_con'] = $sort_con;        
		$viewdata['sort_datas'] = $this->get_sort_datas($stations,$this->input->get("station_type"),$sort_con,$_statistic_style,$_statistic_duration);
		
        $this->load->view('templates/frontend_header', $viewdata);
        $this->load->view('frontend/stations/menu');
        $this->load->view('frontend/stations/sort');
        $this->load->view('templates/frontend_footer');		
	}

	private function get_sort_datas($stations,$type,$sort_con,$_statistic_style,$_statistic_duration){
		$sort_datas['station_name'] = array();
		foreach ($sort_con as $key => $value) {
			$sort_datas[$key] = array();
		}
		$statistic_timestr = h_statistic_datepicker($_statistic_style,$_statistic_duration);
		$ptime = new DateTime($statistic_timestr);
		
		foreach ($stations as $key => $station) {
			if($_statistic_style=='d'){
				$statistic = $this->statistics->findStatistics($station,$ptime->format('r'),ESC_STATISTICS_TYPE__DAY);
				if($type==ESC_STATION_TYPE_SAVING){
					$std_station = $this->station->find_single_standard_station($station);
					$std_statistic = $this->statistics->findStatistics($std_station,$ptime->format('r'),ESC_STATISTICS_TYPE__DAY);						
				}
			}
			if($_statistic_style=='m'){
				$statistic = $this->statistics->findStatistics($station,$ptime->format('r'),ESC_STATISTICS_TYPE__MONTH);
				if($type==ESC_STATION_TYPE_SAVING){
					$std_station = $this->station->find_single_standard_station($station);
					$std_statistic = $this->statistics->findStatistics($std_station,$ptime->format('r'),ESC_STATISTICS_TYPE__MONTH);
				}
			}
			array_push($sort_datas['station_name'],$station->getNameChn());
			array_push($sort_datas['energy_main'],$statistic->getMainEnergy());
			array_push($sort_datas['energy_ac'],$statistic->getAcEnergy());
			array_push($sort_datas['energy_dc'],$statistic->getDcEnergy());
			array_push($sort_datas['ac_main_rate'],h_statistics_ac_main_rate($statistic->getMainEnergy(),$statistic->getAcEnergy()));
			$ac_sav = null;
			$ac_sav_rate = null;
			if($type==ESC_STATION_TYPE_SAVING){
				if($std_statistic){
					$ac_sav = ($std_statistic->getAcEnergy()!=null&&$statistic->getAcEnergy()!=null)?($std_statistic->getAcEnergy()-$statistic->getAcEnergy()):null;
					$ac_sav_rate = h_statistics_ac_sav_rate($statistic->getAcEnergy(),$std_statistic->getAcEnergy());					
				}
			}
			array_push($sort_datas['ac_sav'],$ac_sav);
			array_push($sort_datas['ac_sav_rate'],$ac_sav_rate);
		}
		return $sort_datas = h_sort_page_order_by($sort_con,$sort_datas);
		// return $sort_datas;	
	}

   public function station_mstatistic(){
   		$viewdata['title'] = "Month";
        if(!$project = $this->current_project){ echo "no current project";return; }	
		$time_str = $this->input->get('time')?$this->input->get('time'):h_dt_date_str_no_day("");
		$time = new DateTime($time_str);
		$viewdata['time_input'] = $time->format("Y-m");
		$viewdata['es_project_statistic'] = array();	
		$viewdata['es_building_zhuan'] = array();
		$viewdata['es_building_ban'] = array();
		$viewdata['info'] = array();
		$statistics = array();
		$building_zhuan = array();
		$building_ban = array();
		$dql = "select count(s.id) from Entities\Station s where s.station_type in (1,4) and s.project_id=".$project->getId()." and s.recycle=0";
		$query = $this->doctrine->em->createQuery($dql);
	    $count = $query->getSingleScalarResult();		
		$infos = array(array('type'=>'项目所有基站','ac_value'=>'','save_num'=>$count));
						
		$total_loads = h_station_total_load_array();
		$buildings = h_station_building_array();
		foreach ($total_loads as $key1 => $total_load) {
			foreach ($buildings as $key2 => $building) {
				$lb_data = "null";
				
				$sav_station = $this->station->findOneBy(array('station_type'=>ESC_STATION_TYPE_SAVING,'total_load'=>$key1,'building'=>$key2,'project'=>$project,'recycle'=>ESC_NORMAL));
				$std_station = $this->station->findOneBy(array('station_type'=>ESC_STATION_TYPE_STANDARD,'total_load'=>$key1,'building'=>$key2,'project'=>$project,'recycle'=>ESC_NORMAL));
				if($sav_station&&$std_station){
					$dql = "select count(s.id) from Entities\Station s where s.station_type in (1,4) and s.total_load=".$key1." and s.building=".$key2.
							" and s.project_id=".$project->getId()." and s.recycle=".ESC_NORMAL;
					$query = $this->doctrine->em->createQuery($dql);
	       		    $count = $query->getSingleScalarResult();	
					
					// project
					$datas = $this->statistics->findProjectMonthStatisticslist_hc($sav_station,$std_station,$time_str,"getAcEnergy",$count);
					foreach ($datas as $key => $data) {
						if(!$statistics){ $statistics = $datas;}
						else{ $statistics[$key] = array($data[0],($statistics[$key][1]+$data[1])?$statistics[$key][1]+$data[1]:"null"); }
					}
					// load_building
					$lb_data = $this->statistics->findLoadBuildingMonthStatisticslist_hc($sav_station,$std_station,$time_str,"getAcEnergy");	
					$lb_type = h_station_total_load_name_chn($key1)." ".h_station_building_name_chn($key2);
					array_push($infos, array('type'=>$lb_type,'ac_value'=>($lb_data?$lb_data*$count:''),'save_num'=>$count));
					$infos[0]['ac_value'] += $lb_data?($lb_data*$count):'';
				}
				if($key2 === ESC_BUILDING_ZHUAN){ array_push($building_zhuan, $lb_data?$lb_data:"null"); }
				if($key2 === ESC_BUILDING_BAN){ array_push($building_ban, $lb_data?$lb_data:"null"); }	
			}
		}

		// 'es_project_statistic'
		$str_array = array();
		foreach ($statistics as $key => $statistic) {
			array_push($str_array,'['.implode(',',$statistic).']');
		}
		if($str_array){ $viewdata['es_project_statistic'] = '['.implode(',',$str_array).']'; }
		
		// 'es_total_load_building'
		if($building_zhuan){ $viewdata['es_building_zhuan'] = '['.implode(',',$building_zhuan).']'; }
		if($building_ban){ $viewdata['es_building_ban'] = '['.implode(',',$building_ban).']'; }
		
		$viewdata['infos'] = $infos;

        $this->load->view('templates/frontend_header',$viewdata);
        $this->load->view('frontend/stations/station_mstatistic');
        $this->load->view('templates/frontend_footer');		
	
   }	
        
   public function month_statistics($station_id=16){
        $_station = $this->station->find($station_id);
        if(!$_station){echo "no ".$station_id." sta!";return;}
		if($_station->getRecycle()==ESC_DEL){echo $station_id." sta deleted!";return;}
        $viewdata['title'] = "statistics";
        $viewdata['station_info'] = $this->get_station_info($_station);
        $stations = $this->station->findBy(array("project"=>$this->current_project,'recycle'=>ESC_NORMAL),array("display_order"=>"desc"));
        $viewdata['stations'] = $stations;
        $viewdata['station'] = $_station;
        $time_str = $this->input->get('time')?$this->input->get('time'):h_dt_date_str_no_day("");
	    $viewdata['time_disp'] = $time_str;


        if(ESC_STATION_TYPE_SAVING == $_station->getStationType() || ESC_STATION_TYPE_COMMON == $_station->getStationType()){ 
            //todo:  要找匹配的
            $std_station = $this->station->find_single_standard_station($_station);
            $slist = $this->statistics->findMonthSavingStatisticsList($_station,$std_station,h_dt_date_str($time_str."-01 00:00:00"));
            $viewdata['slist'] = $slist;
            $stotal = $this->statistics->findMonthSavingStatistic($_station,$std_station,h_dt_date_str($time_str."-01 00:00:00"));
            $viewdata['stotal'] = $stotal;
        }else if(ESC_STATION_TYPE_STANDARD == $_station->getStationType()){
            $slist = $this->statistics->findMonthStatisticslist($_station,h_dt_date_str($time_str."-01 00:00:00")); 
            $viewdata['slist'] = $slist;
        }else if(ESC_STATION_TYPE_NPLUSONE== $_station->getStationType()){
            $slist = $this->statistics->findMonth6P1SavingStatisticsList($_station,h_dt_date_str($time_str."-01 00:00:00"));
            $viewdata['slist'] = $slist;
            $stotal = $this->statistics->findMonth6P1SavingStatistic($_station,h_dt_date_str($time_str."-01 00:00:00"));
            $viewdata['stotal'] = $stotal;
        }
        
        
        $this->load->view('templates/frontend_header',$viewdata);
        $this->load->view('frontend/station/menu');
        $this->load->view('frontend/station/month_statistics');
        $this->load->view('templates/frontend_footer');
    }
        
        
    public function station_warning(){

        $data['title'] = "warning";
        $data['cities'] = $this->project->getCities($this->current_project);
        $current_con = array();
        if($this->input->get("city_id"))   $current_con['city_id'] = $this->input->get("city_id");
        if($this->input->get("total_load"))   $current_con['total_load'] = $this->input->get("total_load");
        if($this->input->get("building"))   $current_con['building'] = $this->input->get("building");
        if($this->input->get("station_type"))   $current_con['station_type'] = $this->input->get("station_type");
        $data['current_con'] = $current_con;

        if(!$project = $this->current_project){
        	echo "no current project";return;
		}

        //todo:rewrite
        $stations = $this->station->findBy(array("project"=>$project,'recycle'=>ESC_NORMAL)+$current_con,array("display_order"=>"desc"));
		
		$_stations = array();
        foreach($stations as $station){
        	$warnings = $this->warning->findBy(array("station"=>$station,"status"=>ESC_WARNING_STATUS__OPEN),array("id"=>"desc"));
        	if(count($warnings)){
        		$_stations[$station->getId()]['station'] = $station;
				$_stations[$station->getId()]['warnings'] = array();
				foreach ($warnings as $warning){
                	array_push($_stations[$station->getId()]['warnings'],$warning);
           		}
        	}
        }	
		$data['stations'] = $_stations;

        $this->load->view('templates/frontend_header', $data);
        $this->load->view('frontend/stations/menu');
        $this->load->view('frontend/stations/station_warning');
        $this->load->view('templates/frontend_footer');
    }

    public function warning($station_id=16){
    	$data['title'] = "warning";
        $_station = $this->station->find($station_id);
        if(!$_station){echo "no ".$station_id." sta!";return;}
		if($_station->getRecycle()==ESC_DEL){echo $station_id." sta deleted!";return;}
        
        $stations = $this->station->findBy(array("project"=>$this->current_project,'recycle'=>ESC_NORMAL),array("display_order"=>"desc"));
        $data['stations'] = $stations;
        $data['station_info'] = $this->get_station_info($_station);
        $data['station'] = $_station;

		$data['warnings_open'] = $this->warning->findBy(array("station_id"=>$station_id,"status"=>ESC_WARNING_STATUS__OPEN),array("id"=>"desc"));
		$data['warnings_closed'] = $this->warning->findBy(array("station_id"=>$station_id,"status"=>ESC_WARNING_STATUS__CLOSED),array("id"=>"desc"));

        $this->load->view('templates/frontend_header',$data);
        $this->load->view('frontend/station/menu');
        $this->load->view('frontend/station/warning');
        $this->load->view('templates/frontend_footer');
    }
	
    public function realtime($station_id=16){
        $viewdata['title'] = "real time";
        $_station  = $this->station->find($station_id);
        if(!$_station){echo "no ".$station_id." sta!";return;}
		if($_station->getRecycle()==ESC_DEL){echo $station_id." sta deleted!";return;}

        $_time_str = $this->input->get("time")? $this->input->get("time"):h_dt_date_str_db("");
        $_time_disp = $this->input->get("time")? $this->input->get("time"):  h_dt_date_str_no_time("");
        $_city     = $this->area->find($_station->getCityId());
        $_weathers = $this->weather->get_future_6_days_weather($_city->getId());
        $_datas = $this->data->findDayList($_station,$_time_str);

        $stations = $this->station->findBy(array("project"=>$this->current_project,'recycle'=>ESC_NORMAL),array("display_order"=>"desc"));
        $viewdata['stations'] = $stations;

        $viewdata['station'] = $_station;
        $viewdata['city'] = $_city;
        $viewdata['time_disp'] = $_time_disp;
        $viewdata['station_info'] = $this->get_station_info($_station);


        $data_array=array();
        $params=array("indoor_tmp","outdoor_tmp","box_tmp","colds_0_tmp","colds_1_tmp","indoor_hum","outdoor_hum","colds_0_on","colds_1_on","fan_0_on","power_main","power_dc");
        foreach($params as $param){ $data_array[$param] = array('['.h_dt_str_to_js_unix_time(h_dt_start_time_of_day($_time_str)).',null]'); }

        $_data = null;
        $tmp_on=array("colds_0_on"=>null,"colds_1_on"=>null,"fan_0_on"=>null);
        foreach($_datas as $key => $_data){
            //todo: comparess switchon
            if($_data->getColds0On() != $tmp_on['colds_0_on']){ 
                array_push($data_array['colds_0_on'],'['.$_data->getCreateTimeJSUnix().','.($tmp_on['colds_0_on']?$tmp_on['colds_0_on']+1.5:"null").']');
                array_push($data_array['colds_0_on'],'['.$_data->getCreateTimeJSUnix().','.($_data->getColds0On()?$_data->getColds0On()+1.5:"null").']');
                $tmp_on['colds_0_on'] = $_data->getColds0On();
            }

            if($_data->getColds1On() != $tmp_on['colds_1_on']){ 
                array_push($data_array['colds_1_on'],'['.$_data->getCreateTimeJSUnix().','.($tmp_on['colds_1_on']?$tmp_on['colds_1_on']:"null").']');
                array_push($data_array['colds_1_on'],'['.$_data->getCreateTimeJSUnix().','.($_data->getColds1On()?$_data->getColds1On():"null").']');
                $tmp_on['colds_1_on'] = $_data->getColds1On();
            }

            if($_data->getFan0On() != $tmp_on['fan_0_on']){ 
                array_push($data_array['fan_0_on'],'['.$_data->getCreateTimeJSUnix().','.($tmp_on['fan_0_on']?$tmp_on['fan_0_on']+3:"null").']');
                array_push($data_array['fan_0_on'],'['.$_data->getCreateTimeJSUnix().','.($_data->getFan0On()?$_data->getFan0On()+3:"null").']');
                $tmp_on['fan_0_on'] = $_data->getFan0On();
            }

            ///////////////////////

            if($key%8 != 0) continue;
            array_push($data_array['indoor_tmp'],'['.$_data->getCreateTimeJSUnix().','.($_data->getIndoorTmp()?$_data->getIndoorTmp():"null").']');
            array_push($data_array['outdoor_tmp'],'['.$_data->getCreateTimeJSUnix().','.($_data->getOutdoorTmp()?$_data->getOutdoorTmp():"null").']');
            array_push($data_array['indoor_hum'],'['.$_data->getCreateTimeJSUnix().','.($_data->getIndoorHum()?$_data->getIndoorHum():"null").']');
            array_push($data_array['outdoor_hum'],'['.$_data->getCreateTimeJSUnix().','.($_data->getOutdoorHum()?$_data->getOutdoorHum():"null").']');
            array_push($data_array['box_tmp'],'['.$_data->getCreateTimeJSUnix().','.($_data->getBoxTmp()?$_data->getBoxTmp():"null").']');
            array_push($data_array['colds_0_tmp'],'['.$_data->getCreateTimeJSUnix().','.($_data->getColds0Tmp()?$_data->getColds0Tmp():"null").']');
            array_push($data_array['colds_1_tmp'],'['.$_data->getCreateTimeJSUnix().','.($_data->getColds1Tmp()?$_data->getColds1Tmp():"null").']');
            array_push($data_array['power_main'],'['.$_data->getCreateTimeJSUnix().','.($_data->getPowerMain()?$_data->getPowerMain():"null").']');
            array_push($data_array['power_dc'],'['.$_data->getCreateTimeJSUnix().','.($_data->getPowerDc()?$_data->getPowerDc():"null").']');
        }
        if($_data){
            array_push($data_array['colds_0_on'],'['.$_data->getCreateTimeJSUnix().','.($_data->getColds0On()?$_data->getColds0On()+1.5:"null").']');
            array_push($data_array['colds_1_on'],'['.$_data->getCreateTimeJSUnix().','.($_data->getColds1On()?$_data->getColds1On():"null").']');
            array_push($data_array['fan_0_on'],'['.$_data->getCreateTimeJSUnix().','.($_data->getFan0On()?$_data->getFan0On()+3:"null").']');
        }
        foreach($params as $param){ array_push($data_array[$param],'['.h_dt_str_to_js_unix_time(h_dt_stop_time_of_day($_time_str)).',null]'); }
        foreach($params as $param){ $viewdata[$param.'_list'] = '['.implode(',',$data_array[$param]).']'; }

        $dc_ac_pie = $this->statistics->findDayDcAcPercentage($_station,$_time_str);
        $viewdata['dc_ac_pie'] = $dc_ac_pie;
        $viewdata['dc_ac_pie_str'] = '[{name:"dc",y:'.$dc_ac_pie['dc_p'].',color:"'.h_hc_colors(0).'"},{name:"ac",y:'
                                                    .$dc_ac_pie['ac_p'].',color:"'.h_hc_colors(1).'"}]';

        $switchon_pie = $this->statistics->findDaySwitchonPercentage($_station,$_time_str);
        $viewdata['switchon_pie'] = $switchon_pie;
        $viewdata['switchon_pie_str'] = '[{name:"只开风机",y:'.$switchon_pie['fan_on_p'].',color:"'.h_hc_colors(0).'"},{name:"一台空调",y:'
                                    .$switchon_pie['colds_on_1_p'].',color:"'.h_hc_colors(1).'"},{name:"两台空调",y:'
                                    .$switchon_pie['colds_on_2_p'].',color:"'.h_hc_colors(2).'"},{name:"设备全关",y:'
                                    .$switchon_pie['all_off_p'].',color:"'.h_hc_colors(3).'"}]';

		$energy_ac_column_hc_array = $this->statistics->findDayStatisticslist_hc($_station,$_time_str,"getAcEnergy");
        $viewdata['energy_ac_column_list'] = '['.implode(',',$energy_ac_column_hc_array).']';

        if(ESC_STATION_TYPE_NPLUSONE == $_station->getStationType()){
                $std_energy_ac_column_hc_array = $this->statistics->findDay6P1Statisticslist_hc($_station,$_time_str,"getAcEnergy");
                $viewdata['std_energy_ac_column_list'] = '['.implode(',',$std_energy_ac_column_hc_array).']';

                $saving_pie = $this->statistics->findDay6P1SavingPercentage($_station,$_time_str);
                $viewdata['saving_pie'] = $saving_pie;
                $viewdata['saving_pie_str'] = '[{name:"节约",y:'.$saving_pie['saving_p'].',color:"'.h_hc_colors(0).'"},{name:"节能站",y:'
                    .$saving_pie['saving_station_p'].',color:"'.h_hc_colors(1).'"}]';

        }else if(ESC_STATION_TYPE_SAVING == $_station->getStationType() ||
                ESC_STATION_TYPE_COMMON == $_station->getStationType()){
            //todo:  要找匹配的
            $std_station = $this->station->find_single_standard_station($_station);
            $viewdata['std_station'] = $std_station;
            if($std_station){
                $std_energy_ac_column_hc_array = $this->statistics->findDayStatisticslist_hc($std_station,$_time_str,"getAcEnergy");
                $viewdata['std_energy_ac_column_list'] = '['.implode(',',$std_energy_ac_column_hc_array).']';
                    
                $saving_pie = $this->statistics->findDaySavingPercentage($_station,$std_station,$_time_str);
                $viewdata['saving_pie'] = $saving_pie;
                $viewdata['saving_pie_str'] = '[{name:"节约",y:'.$saving_pie['saving_p'].',color:"'.h_hc_colors(0).'"},{name:"节能站",y:'
                    .$saving_pie['saving_station_p'].',color:"'.h_hc_colors(1).'"}]';

            }else{
                $viewdata['std_energy_ac_column_list'] = '['.implode(',',array()).']';
                $viewdata['saving_pie'] = null;
                $viewdata['saving_pie_str'] = '[{name:"节约",y:0,color:"'.h_hc_colors(0).'"},{name:"节能站",y:0,color:"'.h_hc_colors(1).'"}]';
            }
        }else{ // stand
        }

        $this->load->view('templates/frontend_header',$viewdata);
        $this->load->view('frontend/station/menu');
        $this->load->view('frontend/station/realtime');
        $this->load->view('templates/frontend_footer');
    }

    public function month($station_id=16){
        $viewdata['title'] = "month";

        $_station  = $this->station->find($station_id);
        if(!$_station){echo "no ".$station_id." sta!";return;}
		if($_station->getRecycle()==ESC_DEL){echo $station_id." sta deleted!";return;}

        $_time_str = $this->input->get("time")? $this->input->get("time"):h_dt_date_str_db("");
        $_city     = $this->area->find($_station->getCityId());

        $stations = $this->station->findBy(array("project"=>$this->current_project,'recycle'=>ESC_NORMAL),array("display_order"=>"desc"));
        $viewdata['stations'] = $stations;

        $viewdata['station'] = $_station;
        $viewdata['city'] = $_city;
        $viewdata['station_info'] = $this->get_station_info($_station);



        $data_array=array();


		$energy_ac_column_hc_array = $this->statistics->findMonthStatisticslist_hc($_station,$_time_str,"getAcEnergy");
		$energy_dc_column_hc_array = $this->statistics->findMonthStatisticslist_hc($_station,$_time_str,"getDcEnergy");
		$energy_main_column_hc_array = $this->statistics->findMonthStatisticslist_hc($_station,$_time_str,"getMainEnergy");
		$fan_time_column_hc_array = $this->statistics->findMonthStatisticslist_hc($_station,$_time_str,"getFanTime");
		$colds_0_time_column_hc_array = $this->statistics->findMonthStatisticslist_hc($_station,$_time_str,"getColds0Time");
		$colds_1_time_column_hc_array = $this->statistics->findMonthStatisticslist_hc($_station,$_time_str,"getColds1Time");
		$fan_switch_num_column_hc_array = $this->statistics->findMonthStatisticslist_hc($_station,$_time_str,"getFanSwitchNum");
		$colds_0_switch_num_column_hc_array = $this->statistics->findMonthStatisticslist_hc($_station,$_time_str,"getColds0SwitchNum");
		$colds_1_switch_num_column_hc_array = $this->statistics->findMonthStatisticslist_hc($_station,$_time_str,"getColds1SwitchNum");
        $viewdata['energy_ac_column_list'] = '['.implode(',',$energy_ac_column_hc_array).']';
        $viewdata['energy_dc_column_list'] = '['.implode(',',$energy_dc_column_hc_array).']';
        $viewdata['energy_main_column_list'] = '['.implode(',',$energy_main_column_hc_array).']';
        $viewdata['fan_time_column_list'] = '['.implode(',',$fan_time_column_hc_array).']';
        $viewdata['colds_0_time_column_list'] = '['.implode(',',$colds_0_time_column_hc_array).']';
        $viewdata['colds_1_time_column_list'] = '['.implode(',',$colds_1_time_column_hc_array).']';
        $viewdata['fan_switch_num_column_list'] = '['.implode(',',$fan_switch_num_column_hc_array).']';
        $viewdata['colds_0_switch_num_column_list'] = '['.implode(',',$colds_0_switch_num_column_hc_array).']';
        $viewdata['colds_1_switch_num_column_list'] = '['.implode(',',$colds_1_switch_num_column_hc_array).']';


        if(ESC_STATION_TYPE_NPLUSONE == $_station->getStationType()){
                $std_energy_ac_column_hc_array = $this->statistics->findMonthNP1Statisticslist_hc($_station,$_time_str,"getAcEnergy");
                $viewdata['std_energy_ac_column_list'] = '['.implode(',',$std_energy_ac_column_hc_array).']';

                $viewdata['saving_pie'] = null;
                $viewdata['saving_pie_str'] = '[{name:"节约",y:0,color:"'.h_hc_colors(0).'"},{name:"节能站",y:0,color:"'.h_hc_colors(1).'"}]';
                //$saving_pie = $this->statistics->findDay6P1SavingPercentage($_station,$_time_str);
                //$viewdata['saving_pie'] = $saving_pie;
                //$viewdata['saving_pie_str'] = '[{name:"节约",y:'.$saving_pie['saving_p'].',color:"'.h_hc_colors(0).'"},{name:"节能站",y:'
                    //.$saving_pie['saving_station_p'].',color:"'.h_hc_colors(1).'"}]';

        }else if(ESC_STATION_TYPE_SAVING == $_station->getStationType() ||
                ESC_STATION_TYPE_COMMON == $_station->getStationType()){
            //todo:  要找匹配的
            if($std_station = $this->station->find_single_standard_station($_station)){
                $std_energy_ac_column_hc_array = $this->statistics->findMonthStatisticslist_hc($std_station,$_time_str,"getAcEnergy");
                $viewdata['std_energy_ac_column_list'] = '['.implode(',',$std_energy_ac_column_hc_array).']';

                $saving_pie = $this->statistics->findMonthSavingPercentage($_station,$std_station,$_time_str);
                $viewdata['saving_pie'] = $saving_pie;
                $viewdata['saving_pie_str'] = '[{name:"节约",y:'.$saving_pie['saving_p'].',color:"'.h_hc_colors(0).'"},{name:"节能站",y:'
                    .$saving_pie['saving_station_p'].',color:"'.h_hc_colors(1).'"}]';


            }else{
                $viewdata['std_energy_ac_column_list'] = '['.implode(',',array()).']';
                $viewdata['saving_pie'] = null;
                $viewdata['saving_pie_str'] = '[{name:"节约",y:0,color:"'.h_hc_colors(0).'"},{name:"节能站",y:0,color:"'.h_hc_colors(1).'"}]';
            }
        }else{ // stand
        }



        $dc_ac_pie = $this->statistics->findMonthDcAcPercentage($_station,$_time_str);
        $viewdata['dc_ac_pie'] = $dc_ac_pie;
        $viewdata['dc_ac_pie_str'] = '[{name:"dc",y:'.$dc_ac_pie['dc_p'].',color:"'.h_hc_colors(0).'"},{name:"ac",y:'
                                                    .$dc_ac_pie['ac_p'].',color:"'.h_hc_colors(1).'"}]';

        $switchon_pie = $this->statistics->findMonthSwitchonPercentage($_station,$_time_str);
        $viewdata['switchon_pie'] = $switchon_pie;
        $viewdata['switchon_pie_str'] = '[{name:"只开风机",y:'.$switchon_pie['fan_on_p'].',color:"'.h_hc_colors(0).'"},{name:"一台空调",y:'
                                    .$switchon_pie['colds_on_1_p'].',color:"'.h_hc_colors(1).'"},{name:"两台空调",y:'
                                    .$switchon_pie['colds_on_2_p'].',color:"'.h_hc_colors(2).'"},{name:"设备全关",y:'
                                    .$switchon_pie['all_off_p'].',color:"'.h_hc_colors(3).'"}]';




        $data_array['high_tmp'] = array('['.h_dt_str_to_js_unix_time(h_dt_start_time_of_month($_time_str)).',null]');
        $data_array['low_tmp'] = array('['.h_dt_str_to_js_unix_time(h_dt_start_time_of_month($_time_str)).',null]');
        $tmps = $this->weather->findMonthTemplist($_station,$_time_str);
        foreach($tmps as $tmp){
            array_push($data_array['high_tmp'],'['.h_dt_str_to_js_unix_time($tmp->getDay()->format('r')).','.$tmp->getHighTmp().']');
            array_push($data_array['low_tmp'],'['.h_dt_str_to_js_unix_time($tmp->getDay()->format('r')).','.$tmp->getLowTmp().']');
        }
        array_push($data_array['high_tmp'],'['.h_dt_str_to_js_unix_time(h_dt_stop_time_of_month($_time_str)).',null]'); 
        array_push($data_array['low_tmp'],'['.h_dt_str_to_js_unix_time(h_dt_stop_time_of_month($_time_str)).',null]'); 
        $viewdata['high_tmp_list'] = '['.implode(',',$data_array['high_tmp']).']'; 
        $viewdata['low_tmp_list'] = '['.implode(',',$data_array['low_tmp']).']'; 
        

        $this->load->view('templates/frontend_header',$viewdata);
        $this->load->view('frontend/station/menu');
        $this->load->view('frontend/station/month');
        $this->load->view('templates/frontend_footer');
    }

    
    public function control($station_id=16){
        $_station = $this->station->find($station_id);
        if(!$_station){echo "no ".$station_id." sta!";return;}
		if($_station->getRecycle()==ESC_DEL){echo $station_id." sta deleted!";return;}
		
        $viewdata['title'] = "Control";
        $stations = $this->station->findBy(array("project"=>$this->current_project,'recycle'=>ESC_NORMAL),array("display_order"=>"desc"));
        $viewdata['stations'] = $stations;
        $viewdata['station_info'] = $this->get_station_info($_station);
        $viewdata['station'] = $_station;

        $this->load->view('templates/frontend_header',$viewdata);
        $this->load->view('frontend/station/menu');
        $this->load->view('frontend/station/control');
        $this->load->view('templates/frontend_footer');
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // private functions
    //////////////////////////////////////////////////////////////////////////////////////////////////////////

    private function get_station_info($station){
        $_gap_mins = 24*60;
        $_data = $this->data->getLastData($station,$_gap_mins);
        $station_info = array();
        $station_info['last_indoor_tmp'] = $_data ? $_data->getIndoorTmp():"";
        $station_info['last_outdoor_tmp'] = $_data ? $_data->getOutdoorTmp():"";
        $station_info['last_indoor_hum'] = $_data ? $_data->getIndoorHum():"";
        $station_info['last_box_tmp'] = $_data ? $_data->getBoxTmp():"";
        $station_info['last_fan_0_on'] = $_data ? $_data->getFan0On():"";
        $station_info['last_colds_0_on'] = $_data ? $_data->getColds0On():"";
        $station_info['last_colds_1_on'] = $_data ? $_data->getColds1On():"";
        return $station_info;
    }

}
