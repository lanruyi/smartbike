<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tool_controller extends ES_Controller {
		
	function __construct(){
        parent::__construct();
        $this->load->model(array('project','area','fixdata','station','t_fandaydata',
            'monthdata','savpair'));
    }

    public function index(){}

    public function standard_station(){
    }

    public function standard_station_one_month_energy($time){
        $month = h_dt_start_time_of_month($time);

        $sav_pairs = $this->savpair->findBy_sql(array(
            "datetime"=>$month,
            "project_id"=>4));
        $station_ids = array();
        foreach($sav_pairs as $sav_pair){
            $station_ids[] = $sav_pair['std_station_id'];
        }
        if(!$station_ids){
            echo "本月无基准站";
            return;
        }
        $this->db->where("id in (".join(",",$station_ids).")");
        $stations = $this->station->findBy_sql(array(),array("city_id asc","load_num asc"));
        $this->db->where("station_id in (".join(",",$station_ids).")");
        $monthdatas = $this->monthdata->findBy_sql(array("datetime"=>$month));
        $monthhash = array();
        foreach ($monthdatas as $monthdata){
            $monthhash[$monthdata['station_id']] = $monthdata;
        }

        echo "<table border=1>";
        echo "<tr><td>时间</td><td>城市</td><td>站点</td><td>档位</td><td>负载</td><td>真实负载</td><td>建筑</td><td>用电</td></tr>";
        foreach ($stations as $station){
            if(!isset($monthhash[$station['id']])){
                continue;
            }
            $monthdata = $monthhash[$station['id']];
            echo "<tr>";
            echo "<td>";
            echo h_dt_format($month,"Y-m");
            echo "</td>";
            echo "<td>";
            echo $this->area->getCityNameChn($station['city_id']);
            echo "</td>";
            echo "<td>";
            echo $station['name_chn'];
            echo "</td>";
            echo "<td>";
            echo h_station_total_load_name_chn($station['total_load']);
            echo "</td>";
            echo "<td>";
            echo $station['load_num'];
            echo "</td>";
            echo "<td>";
            echo $monthdata['true_load_num']; 
            echo "</td>";
            echo "<td>";
            echo h_station_building_name_chn($station['building']);
            echo "</td>";
            echo "<td>";
            if($monthdata['true_energy']){
                echo $monthdata['true_energy']; 
            }else{
                echo $monthdata['main_energy'];
            }
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }

    public function no_box_fan_time(){
        $project_id = 4;
        $this->dt['backurl'] = urlencode($_SERVER["REQUEST_URI"]);
        $this->dt['cities'] = $this->area->findProjectCities($project_id);

        $month_array = h_dt_month_array("20130301000000",h_dt_sub_month("now"));
        arsort($month_array);
        $this->dt['month_array'] = $month_array;

        $this->load->view('templates/backend_header',$this->dt);
        $this->load->view('tool/no_box_fan_time');
        $this->load->view('templates/backend_footer');   
    }


    public function no_box_fan_time_detail_all(){
    	$this->dt['title'] = '江苏联通 无恒温柜基站 新风时间';
        $project_id = 4;
    	$month      = $this->input->get('month');
        $month = $month?$month:"20130701000000";
        $days = date("t",strtotime($month));

        $station_hash = array();
        $this->db->where( "create_time < $month and load_num < 30");
        $stations = $this->station->findBy_sql(array(
            "project_id" => $project_id,
            "recycle"    => ESC_NORMAL,
            "have_box"   => 1),
            array("city_id asc,stage asc"));    

        foreach($stations as $key=>$station){
            $stations[$key]['city'] = $this->area->find($station['city_id']);
        }

        $station_ids = h_array_to_id_array($stations); 

        $this->dt['stations']       = $stations;
        $this->dt['fan_time_hash']  = $this->t_fandaydata->getStationsFanTimeHash($station_ids,$month);
        $this->dt['monthdata_hash'] = $this->monthdata->findStationsMonthdataHash($station_ids,$month);
        $this->dt['station_hash']   = $station_hash;
        $this->dt['month']          = $month;

    	$this->load->view('templates/maintain_header', $this->dt);
        $this->load->view('tool/no_box_fan_time_detail_all');
        $this->load->view('templates/maintain_footer');
    }


    public function no_box_fan_time_detail(){
    	$this->dt['title'] = '江苏联通 无恒温柜基站 新风时间';
        $project_id = 4;
    	$month      = $this->input->get('month');
        $city_id    = $this->input->get('city_id');
        $month = $month?$month:"20130701000000";
        $days = date("t",strtotime($month));

        $station_hash = array();
        $this->db->where( "create_time < $month and load_num < 30");
        $stations = $this->station->findBy_sql(array(
            "project_id" => $project_id,
            "city_id"    => $city_id,
            "recycle"    => ESC_NORMAL,
            "have_box"   => 1));    
        foreach($stations as $station){
            $station_hash[$station['stage']][] = $station;
        }

        $station_ids = h_array_to_id_array($stations); 
        $this->dt['fan_time_hash'] = $this->t_fandaydata->getStationsFanTimeHash($station_ids,$month);
        $this->dt['monthdata_hash'] = $this->monthdata->findStationsMonthdataHash($station_ids,$month);

        $this->dt['station_hash'] = $station_hash;
        $this->dt['city'] = $this->area->find_sql($city_id);
        $this->dt['month'] = $month;

    	$this->load->view('templates/maintain_header', $this->dt);
        $this->load->view('tool/no_box_fan_time_detail');
    	$this->load->view('templates/maintain_footer');
    }

    
    public function station_to_station(){
    	$this->dt['title'] = '基站节能对比';
    	$this->dt['sv_datas'] = array();
    	$this->dt['cities'] = $this->area->findBy_sql(array('type'=>ESC_AREA_TYPE_CITY));
    	$this->dt['error'] = '';
    	//时间
    	$start_time = $this->input->get('start_time');
	    $end_time = date("Y-m-d",time());
    	//基准站
    	$s_city_id = $this->input->get('s_city_id');
    	$s_station_name_chn = $this->input->get('s_station_name_chn');
    	$s_station = $this->station->findOneBy_sql(array('city_id'=>$s_city_id,'name_chn'=>$s_station_name_chn));
    	//其他节能站
    	$e_city_id = $this->input->get('e_city_id');
    	$e_station_name_chn = $this->input->get('e_station_name_chn');
    	$e_station = $this->station->findOneBy_sql(array('city_id'=>$e_city_id,'name_chn'=>$e_station_name_chn));
        //节能方式
        $saving_type=$this->input->get('energy_save_type');
    	$this->dt['s_station'] = $s_station;
    	$this->dt['e_station'] = $e_station;

    	if($s_city_id && $s_station_name_chn && $e_city_id && $e_station_name_chn && $e_station && $s_station && $saving_type){
	    	$datas = array();
	    	if(!h_dt_compare($s_station['create_time'],$start_time) && !h_dt_compare($e_station['create_time'],$start_time)){
	    		$s_fixdatas = $this->fixdata->findBy_sql(array('station_id'=>$s_station['id'],'time >='=>$start_time,'time <='=>$end_time));
	    		$count = count($s_fixdatas);
	    		$e_fixdatas = $this->fixdata->findBy_sql(array('station_id'=>$e_station['id'],'time >='=>$start_time,'time <='=>$end_time));
	    		$j = 0 ;
	    		foreach($s_fixdatas as $k=>$s_fixdata){
	    			if($k==($count-1)){continue;}
	    			if($s_fixdata['time']==$e_fixdatas[$j]['time']){
	    				//作一部分判断，确保是后一天的数据
	    				if((strtotime($s_fixdata['time'])+24*60*60)==strtotime($s_fixdatas[$k+1]['time'])&&(strtotime($e_fixdatas[$j]['time'])+24*60*60)==strtotime($e_fixdatas[$j+1]['time'])){
		    				$datas[$k]['s_energy_main'] = $s_fixdatas[$k+1]['energy_main'] - $s_fixdata['energy_main'];
		    				$datas[$k]['s_energy_dc'] = $s_fixdatas[$k+1]['energy_dc'] - $s_fixdata['energy_dc'];
		    				$datas[$k]['e_energy_main'] = $e_fixdatas[$j+1]['energy_main'] - $e_fixdatas[$j]['energy_main'];
		    				$datas[$k]['e_energy_dc'] = $e_fixdatas[$j+1]['energy_dc'] - $e_fixdatas[$j]['eenergy_dc'];
		    				//如果有值的话 则做处理，节能率
                                                if($saving_type==1){
		    				$datas[$k]['saving_rate'] = h_e_jiangsu_save_rate($datas[$k]['s_energy_main'],$datas[$k]['e_energy_main'],$s_station['load_num'],$e_station['load_num']);
                                                $datas[$k]['saving_energy']=  h_e_jiangsu_save_energy($datas[$k]['e_energy_main'],$datas[$k]['saving_rate']);
		    				$datas[$k]['time'] = date('Y/m/d',strtotime($s_fixdata['time']));
	    					$j++;
		    				continue;
                                                }elseif ($saving_type==2) {
                                                  $datas[$k]['saving_rate'] = h_e_shanghai_save_rate($datas[$k]['s_energy_main'],$datas[$k]['e_energy_main'],$s_station['load_num'],$e_station['load_num']);
                                                  $datas[$k]['saving_energy']=  h_e_shanghai_save_energy($datas[$k]['e_energy_main'],$datas[$k]['saving_rate']);
		    				  $datas[$k]['time'] = date('Y/m/d',strtotime($s_fixdata['time']));
	    					  $j++;
		    				  continue;  
                                                }
		    			}
	    			}
	    		}
	    		$this->dt['sv_datas'] = $datas;
	    	}else{
	    		$this->dt['error'] = '信息有误！请检查后再输入';
	    	}
	    }else{
	    	$this->dt['error'] = '请选择城市基站以及时间以及节能方式';
	    }
    	$this->load->view('templates/maintain_header', $this->dt);
        $this->load->view('tool/station_to_station.php');

    }
}
