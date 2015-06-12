

    public function newlist2($cur_page = 1){
        $this->dt['title']="多站视图";
        $load_level = $this->input->get('load_level')?$this->input->get('load_level'):ESC_TOTAL_LOAD_20A30A;
        $building = $this->input->get('building')?$this->input->get('building'):ESC_BUILDING_ZHUAN;
        $this->dt['load_level'] = $load_level;
        $this->dt['building'] = $building;

        $project_id=$this->current_project['id'];
        $city_id=$this->current_city['id'];
        $this->dt['standard_stations'] = $this->station->getStandardStations($project_id,$city_id,$load_level,$building);
        $this->dt['saving_stations'] = $this->station->getSavingStations($project_id,$city_id,$load_level,$building);
        $this->dt['station_nums'] = $this->station->getCityStationNums($project_id,$city_id);


        $per_page = $this->input->get('per_page')? $this->input->get('per_page'):10;	
        $paginator =  $this->station->getCommonStationsPagination($project_id,$city_id,$load_level,$building,$per_page,$cur_page);
        $config['base_url']   = "/frontend/stations/newlist/";
        $config['suffix']     = "?".$_SERVER['QUERY_STRING'];
        $config['first_url']  = $config['base_url'].$config['suffix'];
        $config['total_rows'] = $paginator['num'];
        $config['per_page']   = $per_page; 
        $this->pagination->initialize($config); 
        $this->dt['common_pagination'] = $this->pagination->create_links();
        $this->dt['common_stations'] = $paginator['res'];


        foreach(array('standard_stations','saving_stations','common_stations') as $station_type){
            foreach($this->dt[$station_type] as $key=>$station){
                $last_data = $this->data->getLastData_sql($station['id'], 60);
                $energy_info = $this->mid_energy->getStationEnergyInfo($station['id']);
                $this->dt[$station_type][$key] += $energy_info;
                $this->dt[$station_type][$key]['last_data'] = $last_data;
            }
        }

        $this->load->view('templates/frontend_header', $this->dt);
		$this->load->view('frontend/stations/newlist');
        $this->load->view('templates/frontend_footer');
    }


    public function getProjectCityBugInfo($id,$str='project'){
        $result = array();
        $query = $this->db->query("select count(*) as station_num from stations where recycle = ".ESC_NORMAL." and ".$str."_id = ".$id);
        $res = $query->result_array();
        $result['station_num'] = $res[0]['station_num'];
        if($result['station_num'] == 0){
            $result['bug_num'] = 0;
            $result['bug_station_num'] = 0;
            $result['bug_point'] = 0;
            return $result;
        }
        $query = $this->db->query("select count(*) as bug_num from bugs where status = ".ESC_BUG_STATUS__OPEN." and ".$str."_id = ".$id);
        $res = $query->result_array();
        $result['bug_num'] = $res[0]['bug_num'];
        $query = $this->db->query("select station_id from bugs where status = ".ESC_BUG_STATUS__OPEN." and ".$str."_id = ".$id ." group by station_id");
        $res = $query->result_array();
        $result['bug_station_num'] = count($res);

        $query = $this->db->query("select type,count(*) as cnum from bugs where status = ".ESC_BUG_STATUS__OPEN." and ".$str."_id = ".$id ." group by type");
        $res = $query->result_array();
        $points = 100 * $result['station_num'];
        foreach ($res as $item){
            $points -= $this->bug_point($item['type'])*$item['cnum'];
        }
        $result['bug_point'] = round($points/$result['station_num'],2);
        return $result;
    }




        //获取得到不是测试的数项目id据
        $projects = $this->project->getMaintainProjects();
        $projects_ids = array_map('turntoidarray',$projects); 
        $this->dt['projects'] = $projects;
        $info = array();
        
        foreach($projects as $project){
            $p['id'] = $project['id'];
            $p['name_chn'] = $project['name_chn'];
            $p['info'] = $this->bug->getProjectCityBugInfo($project['id'],'project');
            $query = $this->db->query("select id,name_chn from areas where id in (".$project['city_list'].")");
            $p['cities'] = array();
            $cities = $query->result_array();
            foreach($cities as $city){
                $c['id'] = $city['id'];
                $c['name_chn'] = $city['name_chn'];
                $c['info'] = $this->bug->getProjectCityBugInfo($city['id'],'city');
                array_push($p['cities'],$c);
            }
            array_push($info,$p);
        }
        //把城市、项目的信息都存放在info里
        $this->dt['info'] = $info;      
        
        $low_point_stations = array();
        $query = $this->db->query("select id,city_id,name_chn,bug_point,project_id from stations where recycle = ? and bug_point<=80",array(ESC_NORMAL));
        $res = $query->result_array();
        foreach ($res as $station){
            $low_point_stations[$station['project_id']][$station['city_id']][]=$station;
        }
        
        
        //将所有的各项故障数按照城市归类划分，只要是bug_point<100的都要，但每个项目和城市的只取一条，避免数据重复
        $query = $this->db->query("select id,city_id,name_chn,bug_point,project_id from stations where recycle = ? and bug_point<100 group by project_id,city_id",array(ESC_NORMAL));
        $res = $query->result_array();

        //按每个项目和城市统计故障类型 
        $all_bugs_city_num=array();
        foreach ($res as $station){
                $query = $this->db->query("select count(*) as bug_nums,type from bugs where city_id=? and status = ? group by type",array($station['city_id'],ESC_BUG_STATUS__OPEN));
                $tmp =  $query->result_array();
                foreach($tmp as $v){                  
                  $arr=array('bug_type'=>$v['type'],'bug_nums'=>$v['bug_nums']);
                  $all_bugs_city_num[$station['project_id']][$station['city_id']][]=$arr;
                }
                             
        }
        $this->dt['all_bugs_city_num']=$all_bugs_city_num;
       
        $this->dt['low_point_stations'] = $low_point_stations;

        $query = $this->db->query("select stations.id as station_id,city_id,stations.name_chn as station_name_chn,projects.name_chn as project_name_chn,
            bug_point,project_id,station_type from stations 
            left join projects on projects.id = stations.project_id
            left join areas on areas.id = stations.city_id
            where recycle = ? and bug_point<90 and station_type in (?,?) and project_id in (".implode(',',$projects_ids).")",
            array(ESC_NORMAL,ESC_STATION_TYPE_SAVING,ESC_STATION_TYPE_STANDARD));
        
        //这里为了方便 查询基准站，标杆站，所以要对这个数组进行一些处理
        $tmp_arr = $query->result_array();
        $this->dt['urgency_stations']=array();
        foreach($tmp_arr as $v){
            $this->dt['urgency_stations'][$v['project_id'].'_'.$v['city_id']] = $v;
        }
       
        
        //获取所有故障的类型和总数量
        $query = $this->db->query("select type,count(*) as bug_num from bugs where status = ? group by type",
            array(ESC_BUG_STATUS__OPEN));
        $this->dt['bug_nums'] = $query->result_array();




    //基站的bug应该返回的分数
    public function bug_return_socres($station_id) {
        $station = $this->station->find_sql($station_id);
        $station_type = $station['station_type'];
        $modulus = $this->station->bug_station_type($station_type);
        $bugs = $this->bug->find_stationid_sql($station_id);
        $score = 0;
        foreach ($bugs as $bug) {
            $score+=$this->bug->bug_point($bug['type']);
        }
        return $modulus * $score;
    }

    //重新计算每个基站的故障分数
    public function check_station_point() {
        $query = $this->db->query("select id,name_chn,bug_point,station_type,0 as bug_point_t from stations where recycle=1");
        $res = $query->result_array();
        $stations = array();
        foreach ($res as $sta) {
            $stations[$sta['id']] = $sta;

            $stations[$sta['id']]['bug_point_t'] = $this->bug_return_socres($sta['id']);
            echo $stations[$sta['id']]['id'] . ":" . $stations[$sta['id']]['name_chn'] . ":" . $stations[$sta['id']]['bug_point_t'] . "\n";
        }
        $c = 0;
        foreach ($stations as $station) {
            if ($station['bug_point'] != $station['bug_point_t']) {
                echo $station['name_chn'] . "(" . $station['bug_point'] . "/" . $station['bug_point_t'] . ")\n";
                $query = $this->db->query("update stations set bug_point=? where id=?", array($station['bug_point_t'], $station['id']));
                $c++;
            }
        }
        echo $c . "\n";
    }













                header('HTTP/1.1 200 OK');
                header('Content-Type: application/octet-stream');
                header('Content-Transfer-Encoding: binary');
                header('Connection:Keep-Alive');
                //header('Content-Disposition: attachment; filename="download.txt"');
                ob_clean();
                flush();
                echo $this->addfp_pay_load($part_id, $pay_load);
                exit();

                    <li><? if($station->getStationType() == ESC_STATION_TYPE_NPLUSONE){
                             echo h_bar_np1_day_string($time_disp,$station);
                         }else if(isset($std_station)){
                             echo "基准站:<a href='javascript:go_to_station(".$std_station->getId().")'>".$std_station->getNameChn()."</a>";
                     }?></li>                           



              <div class="add_note">
                  <?php echo form_open("/frontend/single/day/".$station->getId()."?time=".$time_disp); ?>
                  <textarea name="note_content"></textarea>
                  <ul>
                      <input type="radio" name="openness" value="1" checked="checked" />对所有人公开
                      <input type="radio" name="openness" value="2" />仅自己可见
                  </ul>
                  <ul><?php echo form_submit("","保存"); ?>
                      <input type="button" value="取消" id="cancel" />
                  </ul>
                  <? echo form_close(); ?>

              </div>
                <div class="notes_list"><ul>
                <? if(count($private_notes)||count($station_notes)){
                	echo "<p style='font-weight:bold;color:red;'>Notes [ ".$station->getNameChn()." ".$time_disp." ]: </p>";
                	} ?>
		  	  
               <li class="note_title"><span><? if(count($private_notes)||count($self_public_notes)){ echo "个人笔记"; }?></span></li>
		  	  	<li><table class="table ">
		  	  <? foreach($private_notes as $note){ ?>
                		<tr><td><?= $note->getNoteTime()->format('Y-m-d H:i:s') ?></td>
                		<td><?= nl2br($note->getContent()) ?></td><td>[私]</td></tr>
                <? }?>
                
		  	  <? foreach($self_public_notes as $note){ ?>
                		<tr><td><?= $note->getNoteTime()->format('Y-m-d H:i:s') ?></td>
                		<td><?= nl2br($note->getContent()) ?></td><td>[公]</td></tr>
                <? }?>
                	</table></li>	
		  	  <li class="note_title"><span><? if(count($station_notes)>count($self_public_notes)){ echo "其他人笔记"; }?></span></li>
                <? foreach($station_notes as $note){ 
                	if($note->getAuthor() != $user){ ?>
                	<li><table class="table">
                		<tr><td><?= $note->getNoteTime()->format('Y-m-d H:i:s') ?></td>
                			<td><?= $note->getAuthor()->getNameChn()?></td>
                		<td colspan="2"><?= nl2br($note->getContent()) ?></td></tr>
                	</table></li>	
		  	  <? }}?>				  
                </ul></div>





<style>
.nTab{ float: left; width: 100%; margin: 0 auto; border-bottom:1px #C7C7CD solid; background:#d5d5d5; background-position:left; background-repeat:repeat-y; margin:8px 0; }
.nTab .TabTitle{ clear: both; height: 26px; overflow: hidden; }
.nTab .TabTitle ul{ margin:0; padding:0; }
.nTab .TabTitle li{ float: left; width: 140px;text-align:center; cursor: pointer; padding-top: 6px; padding-right: 0px; padding-left: 0px; padding-bottom: 7px; list-style-type: none; }
.nTab .TabTitle .active{ border-left:1px  #C7C7CD solid;border-top:1px  #C7C7CD solid;border-bottom:1px #fff solid;background-color:#fff}
.nTab .TabTitle .normal{ border-top:1px #C7C7CD solid;border-bottom:1px #C7C7CD solid;}
.nTab .TabContent{ width:auto;background:#fff; margin: 0px auto; padding:0; border-right:1px #C7C7CD solid;border-left:1px #C7C7CD solid; }
.nTab .TabContent ul{padding:8px;list-style:none;margin:0;background-color:#fff;overflow:hidden }
.nTab .TabContent ul li{float:left;list-style:none;margin:0 5px;padding:0 5px;width:100px;height:22px;line-height:22px;overflow:hidden;background-color:#fff }
.none {display:none;}
</style>


<div style="">
  <div class="nTab">
    <div class="TabTitle">
      <ul id="myTab0">
      <? foreach($station_array as $total_load => $buildings){ ?>
      <li class="<?= $total_load == $station->getTotalLoad()?"active":"normal"?>" onclick="nTabs(this,<?= ($total_load-1)?>);"><?= h_station_total_load_name_chn($total_load)?></li>
      <? }?>
      </ul>
    </div>
    <div class="TabContent">
      <? foreach($station_array as $total_load => $buildings){ ?>
      <div id="myTab0_Content<?= ($total_load-1)?>" class=<?= $total_load == $station->getTotalLoad()?"":"none"?> >
          <ul>
          <? foreach($buildings as $building => $stationtypes){ ?>
              <? foreach($stationtypes as $station_type => $stas){ ?>
                  <? foreach($stas as $sta){ ?>
                  <li style="background-color:<?= $sta == $station?"#ddd":""?>">
                        <?= h_online_mark($sta->isOnline()) ?><a href="javascript:go_to_station(<?= $sta->getId()?>);"> <?= $sta->getNameChn()?> </a>
                    </li>
                  <? }?>
              <? }?>
          <? }?>
          </ul>
      </div>
      <? }?>
    </div>
  </div>
</div>



        <div class='es_sub2_menu' style="border-bottom:4px solid #ccc">  
            <ul>
            <? foreach($cities as $key=>$city){?>
                <? if(!$first_stations[$key]){continue;} ?>
                <li class="<?= $city_id == $city->getId()?"active":"" ?>"> 
                    <a  href="javascript:go_to_station(<?= $first_stations[$key]->getId()?>);"> <?= $city->getNameChn()?> </a> </li>
                <li class="divider-vertical"></li>
            <? }?>
            </ul>
        </div>

<script type="text/javascript">
function nTabs(thisObj,Num){
if(thisObj.className == "active")return;
var tabObj = thisObj.parentNode.id;
var tabList = document.getElementById(tabObj).getElementsByTagName("li");
for(i=0; i <tabList.length; i++)
{
  if (i == Num)
  {
   thisObj.className = "active"; 
      document.getElementById(tabObj+"_Content"+i).style.display = "block";
  }else{
   tabList[i].className = "normal"; 
   document.getElementById(tabObj+"_Content"+i).style.display = "none";
  }
} 
}
</script>





    public function savpairsdata($building_type){
        $this->dt['projects'] = $this->project->findBy_sql(array("is_product"=>1,"type"=>1));
        $this->dt['cities'] = $this->area->findBy_sql(array());
        
        $conditions = array();
        $conditions['project_id'] = $this-> input ->get('project_id')?$this-> input ->get('project_id'):4;
        $conditions['city_id'] = $this-> input ->get('city_id') ? $this-> input ->get('city_id'):0;
        $conditions['time_type'] = $this->input->get('time_type')?$this->input->get('time_type'):ESC_DAY;
        $conditions['datetime'] = $this->input->get('datetime')? $this-> input ->get('datetime'): h_dt_readable_day("yesterday");
        $conditions['datetime'] = (ESC_MONTH==$conditions['time_type'])?h_dt_readable_day(h_dt_start_time_of_month($conditions['datetime'])):h_dt_readable_day($conditions['datetime']);
        
        $conditions['saving_func'] = ESC_SAV_STD_FUN_B;
        $this->dt['conditions']=$conditions;
        
        $this->dt['prj_cities'] = json_encode($this->project->getEachProjectCities_sql());
        
        $this->dt['project_name_chn'] = $this->project->getProjectNameChn($conditions['project_id']);
        $this->dt['city_name_chn'] = $this->area->getCityNameChn($conditions['city_id']);
        $this->dt['datetime_disp'] = (ESC_MONTH==$conditions['time_type'])?h_dt_date_str_no_day($conditions['datetime']):h_dt_date_str_no_time($conditions['datetime']);
        $time_type_array = h_report_time_type_array();
        $this->dt['time_type_disp'] =  $time_type_array[$conditions['time_type']];
       
        $this->dt['building_type_zhuan'] = ESC_BUILDING_ZHUAN;
        $this->dt['building_type_ban'] = ESC_BUILDING_BAN;
        
        $datetime = h_dt_start_time_of_month($conditions['datetime']);

        $sav_pairs = $this->savpair->getSavPairs(array("project_id"=>$conditions['project_id'],"city_id"=>$conditions['city_id'],
            "datetime"=>$datetime,"building_type"=>$building_type));

        $sav_pairs_data = array();
        foreach($sav_pairs as $sav_pair){
            $sav_pairs_data[$sav_pair['total_load']][$sav_pair['id']]['sav']['station_name_chn'] = $this->station->getStationNameChn($sav_pair['sav_station_id']);
            $sav_pairs_data[$sav_pair['total_load']][$sav_pair['id']]['std']['station_name_chn'] = $this->station->getStationNameChn($sav_pair['std_station_id']);
            $sav_pairs_data[$sav_pair['total_load']][$sav_pair['id']]['sav']['station_load_num'] = $this->station->getStationLoadNum($sav_pair['sav_station_id']);
            $sav_pairs_data[$sav_pair['total_load']][$sav_pair['id']]['std']['station_load_num'] = $this->station->getStationLoadNum($sav_pair['std_station_id']);
            $sav_pairs_data[$sav_pair['total_load']][$sav_pair['id']]['sav']['station_cspt'] = $this->savpair->getSavStationCspt($sav_pair['id'],$conditions['datetime'],$conditions['time_type']);
            $sav_pairs_data[$sav_pair['total_load']][$sav_pair['id']]['std']['station_cspt'] = $this->savpair->getStdStationCspt($sav_pair['id'],$conditions['datetime'],$conditions['time_type']);
            $sav_pairs_data[$sav_pair['total_load']][$sav_pair['id']]['rate'] = $this->savpair->getSavPairRate($sav_pair['id'],$conditions['datetime'],$conditions['time_type'],$conditions['saving_func']);
            $sav_pairs_data[$sav_pair['total_load']][$sav_pair['id']]['energy_sav'] = $this->saving->getEnergySave($sav_pair['sav_station_id'],$conditions['datetime'],$conditions['time_type'],$conditions['saving_func']); 
        }     
        
        //按total_load排序
        $sav_pairs_data_ordered = $this->station->order_by_total_load($sav_pairs_data);    
        //生成每档位平均节能率序列
        $saving_rate_array = array();
        foreach($sav_pairs_data as $total_load=>$savpairs){
            $saving_rate_array[$total_load] = $this->loadleveldata->getSavingRate($conditions+array('total_load'=>$total_load,'building_type'=>$building_type));
        }
        $this->dt['savpairdatas'] = $sav_pairs_data_ordered;
        $this->dt['saving_rate_array'] = $saving_rate_array;
      
        $this->dt['total_load_chn'] = h_station_total_load_array();
       
        $this->load->view('templates/backend_header',$this->dt);
        $this->load->view('reporting/submenu');
        $this->load->view('reporting/table/menu');
        $this->load->view('reporting/table/savpairsdata');
        $this->load->view('templates/backend_footer');
    }
    
    public function comstationdata($building_type){
        $this->dt['projects'] = $this->project->findBy_sql(array("is_product"=>1,"type"=>1));
        $this->dt['cities'] = $this->area->findBy_sql(array());
        
        $conditions = array();
        $conditions['project_id'] = $this-> input ->get('project_id')?$this-> input ->get('project_id'):4;
        $conditions['city_id'] = $this-> input ->get('city_id') ? $this-> input ->get('city_id'):0;
        $conditions['time_type'] = $this->input->get('time_type')?$this->input->get('time_type'):ESC_MONTH;
        $conditions['datetime'] = $this->input->get('datetime')? $this-> input ->get('datetime'): h_dt_readable_day("yesterday");
        $conditions['datetime'] = (ESC_MONTH==$conditions['time_type'])?  h_dt_readable_day(h_dt_start_time_of_month($conditions['datetime'])):$conditions['datetime'];
        
        $conditions['saving_func'] = ESC_SAV_STD_FUN_B;
        $this->dt['conditions']=$conditions;
        
        $this->dt['prj_cities'] = json_encode($this->project->getEachProjectCities_sql());
        $this->dt['project_name_chn'] = $this->project->getProjectNameChn($conditions['project_id']);
        $this->dt['city_name_chn'] = $this->area->getCityNameChn($conditions['city_id']);
        $this->dt['datetime_disp'] = (ESC_MONTH==$conditions['time_type'])?h_dt_date_str_no_day($conditions['datetime']):h_dt_date_str_no_time($conditions['datetime']);
        $time_type_array = h_report_time_type_array();
        $this->dt['time_type_disp'] =  $time_type_array[$conditions['time_type']];
       
        $this->dt['building_type_zhuan'] = ESC_BUILDING_ZHUAN;
        $this->dt['building_type_ban'] = ESC_BUILDING_BAN;
//        $stations = $this->station->getSomeAvailableStationAtTime(array("project_id"=>$conditions['project_id'],
//                                                                "city_id"=>$conditions['city_id'],
//                                                                "building"=>$building_type,
//                                                                "station_type"=>ESC_STATION_TYPE_COMMON,
//                                                                "recycle"=>ESC_NORMAL),
//                                                                $conditions['datetime'],
//                                                                 array("load_num"));
//     
        $stations = $this->saving->findBy_sql($conditions+array("station_type"=>ESC_STATION_TYPE_COMMON,"building_type"=>$building_type));
        $comstationdatas = array();
        foreach($stations as $station){
            $comstationdatas[$station['station_id']]['station_name_chn'] = $this->station->getStationNameChn($station['station_id']);
            $comstationdatas[$station['station_id']]['load_num'] = $this->station->getStationLoadNum($station['station_id']);
            $comstationdatas[$station['station_id']]['saving_rate'] = $station['saving_rate'];
            $comstationdatas[$station['station_id']]['station_cspt'] = $this->saving->getStationEnergyCspt($station['station_id'],$conditions['datetime'],$conditions['time_type']);
            $comstationdatas[$station['station_id']]['energy_save'] = $station['energy_save'];
            $comstationdatas[$station['station_id']]['error'] = $station['error'];
        }
        $this->dt['comstationdatas'] = $comstationdatas;
        
        $this->load->view('templates/backend_header',$this->dt);
        $this->load->view('reporting/submenu');
        $this->load->view('reporting/table/menu');
        $this->load->view('reporting/table/comstationdata');
        $this->load->view('templates/backend_footer');
    }
    
    public function summarydata(){
        $this->dt['projects'] = $this->project->findBy_sql(array("is_product"=>1,"type"=>1));
        $this->dt['cities'] = $this->area->findBy_sql(array());
        
        $conditions = array();
        $conditions['project_id'] = $this-> input ->get('project_id')?$this-> input ->get('project_id'):4;
        $conditions['city_id'] = $this-> input ->get('city_id') ? $this-> input ->get('city_id'):0;
        $conditions['time_type'] = $this->input->get('time_type')?$this->input->get('time_type'):ESC_MONTH;
        $conditions['datetime'] = $this->input->get('datetime')? $this-> input ->get('datetime'): h_dt_readable_day("yesterday");
        $conditions['datetime'] = (ESC_MONTH==$conditions['time_type'])? h_dt_readable_day(h_dt_start_time_of_month($conditions['datetime'])):$conditions['datetime'];
            
        $conditions['saving_func'] = ESC_SAV_STD_FUN_B;
        $this->dt['conditions']=$conditions;
        
        $this->dt['prj_cities'] = json_encode($this->project->getEachProjectCities_sql());
        
        $this->dt['project_name_chn'] = $this->project->getProjectNameChn($conditions['project_id']);
        $this->dt['city_name_chn'] = $this->area->getCityNameChn($conditions['city_id']);
        $this->dt['datetime_disp'] = (ESC_MONTH==$conditions['time_type'])?h_dt_date_str_no_day($conditions['datetime']):h_dt_date_str_no_time($conditions['datetime']);
        $time_type_array = h_report_time_type_array();
        $this->dt['time_type_disp'] =  $time_type_array[$conditions['time_type']];
       
        $this->dt['building_type_zhuan'] = ESC_BUILDING_ZHUAN;
        $this->dt['building_type_ban'] = ESC_BUILDING_BAN;
        //获得各种基站总数
        $this->dt['sav_station_num'] = $this->saving->getOneKindStationNum(ESC_STATION_TYPE_SAVING,$conditions);
        $this->dt['std_station_num'] = $this->saving->getOneKindStationNum(ESC_STATION_TYPE_STANDARD,$conditions);
        $this->dt['com_station_num'] = $this->saving->getOneKindStationNum(ESC_STATION_TYPE_COMMON,$conditions);
//        //获得参与计算的基站数
//        $this->dt['normal_sav_station_num'] = $this->saving->getOneKindStationNum(ESC_STATION_TYPE_SAVING,$conditions+array('error'=>null));
//        $this->dt['normal_com_station_num'] = $this->saving->getOneKindStationNum(ESC_STATION_TYPE_COMMON,$conditions+array('error'=>null));
        $this->dt['sav_station_energy_save'] = $this->saving->getOneKindStationEnergySave(ESC_STATION_TYPE_SAVING,$conditions);
        $this->dt['com_station_energy_save'] = $this->saving->getOneKindStationEnergySave(ESC_STATION_TYPE_COMMON,$conditions);
        
        //$this->output->enable_profiler(TRUE);
        $this->load->view('templates/backend_header',$this->dt);
        $this->load->view('reporting/submenu');
        $this->load->view('reporting/table/menu');
        $this->load->view('reporting/table/sum');
        $this->load->view('templates/backend_footer');
    }
    
