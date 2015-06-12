<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Maintain_controller extends Backend_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->library(array('curl','email'));
        $this->load->model(array('command','bug','station','warning','cmail','data','project'));
        $this->load->helper(array('date','project','bug'));
    }

    public function detail($cur_page = 1){
        $this->dt['title'] = "detail";
        $this->dt['backurlstr'] = urlencode($_SERVER["REQUEST_URI"]);

        if($this->input->get('station_id')){
        }else{
            $this->dt['station'] = null; 
        }
            
        $per_page = $this->input->get('per_page')? $this->input->get('per_page'):20;	
        $conditions = array();
        $conditions['type ='] = $this->input->get('type');
        $conditions['status ='] = ESC_BUG_STATUS__OPEN;
        $conditions['project_id ='] = $this->input->get('project_id');
        $conditions['city_id ='] = $this->input->get('city_id');
        
		$orders = array("id"=>"desc");
        $paginator =  $this->bug->pagination_sql($conditions,$orders,$per_page,$cur_page);		
        //config pagination
        $config['base_url'] = '/maintain/maintain/detail/';
        $config['suffix'] = "?".$_SERVER['QUERY_STRING'];
        $config['first_url'] = $config['base_url'].$config['suffix'];
	    $config['total_rows'] =$paginator['num'];
	    $config['per_page'] = $per_page; 
		
        $this->pagination->initialize($config); 
        $this->dt['pagination'] = $this->pagination->create_links();
        foreach($paginator['res'] as &$bug){
            $station = $this->station->find_sql($bug['station_id']);
            $project = $this->project->find_sql($bug['project_id']);
            $city = $this->area->find_sql($bug['city_id']);
            $bug['station_name_chn'] = $station?$station['name_chn']:"";
            $bug['project_name_chn'] = $project?$project['name_chn']:"";
            $bug['city_name_chn'] = $city?$city['name_chn']:"";
        } 
        $this->dt['bugs'] = $paginator['res'];
        $this->dt['projects'] = $this->project->findProductProjects();
        $this->dt['cities'] = $this->project->getProductCities();
        $this->dt['bug_types'] = h_bug_type_array();

        // 组装过滤器的url params 
        $urls['type'] = $this->input->get('type');
        $urls['city_id'] = $this->input->get('city_id');
        foreach($this->dt['projects'] as &$project){
            $urls['project_id'] = $project['id'];
            $project['url'] = h_url_param_str($urls);
        }
        $urls['project_id'] = "";
        $this->dt['project_empty'] = h_url_param_str($urls);


        $urls['project_id'] = $this->input->get('project_id');
        foreach($this->dt['cities'] as &$city){
            $urls['city_id'] = $city['id'];
            $city['url'] = h_url_param_str($urls);
        }
        $urls['city_id'] = '';
        $this->dt['city_empty'] = h_url_param_str($urls);


        $urls['city_id'] = $this->input->get('city_id');
        foreach($this->dt['bug_types'] as $type => &$bug){
            $urls['type'] = $type;
            $name = $bug;
            $bug = array();
            $bug['type'] = $type;
            $bug['name_chn'] = $name;
            $bug['url'] = h_url_param_str($urls);
        }
        $urls['type'] = '';
        $this->dt['type_empty'] = h_url_param_str($urls);

        //$query = $this->db->query("select project_id,name_chn,count(*) as a from bugs left join projects on projects.id = bugs.project_id where status = ? group by project_id",
            //array(ESC_BUG_STATUS__OPEN));
        //$this->dt['projects'] = $query->result_array();

        $this->load->view('templates/backend_header', $this->dt);
        $this->load->view('maintain/menu');
        $this->load->view('maintain/detail.php');
        $this->load->view('templates/backend_footer');
    }

    public function index(){
        $this->dt['title'] = "maintain";

        $this->load->view('templates/backend_header', $this->dt);
        $this->load->view('maintain/menu');
        $this->load->view('maintain/index.php');
        $this->load->view('templates/backend_footer');
    }


    public function history(){
        $data['title']='故障历史';
        //准备过滤条件
        $conditions = array();
        $conditions['project_id ='] = $this->input->get('project_id');
        $conditions['city_id ='] = $this->input->get('project_id')?$this->input->get('city_id'):'';
        $conditions['type ='] = $this->input->get('type_id')?$this->input->get('type_id'):''; 
        $condition_str = "";
        foreach($conditions as $key=>$value){
            if($value){
                $condition_str.=" and ".$key.$value;
            }
        }
        $data['month'] = array('一月','二月','三月','四月','五月','六月','七月','八月','九月','十月','十一月','十二月');
        $data['year'] = array('2012'=>'2012','2013'=>'2013','2014'=>'2014');
        //第几个月,不选的话则默认是当前月
        $get_month = $this->input->get('month_id')?$this->input->get('month_id'):date("m",time());
        $data['get_month'] = $get_month;
        //获取年份，不选的话则默认是当前年
        $get_year = $this->input->get('year_id')?$this->input->get('year_id'):date("Y",time());
        $data['get_year'] = $get_year;

        $start = h_dt_start_time_of_month($get_year."-".$get_month);

        //获取要查询的天数，数组下标从0开始
        $current_day = @date("t",strtotime($start));
        $data['days'] = $current_day;
        $days = range(1,$current_day);
        //看每天8点时系统有多少BUG
        $p_time = new DateTime($get_year."-".$get_month."-1"." 20:00:00");

        //查询某月前一个月最后一天的错误数
        $prev_time=($get_month==1?($get_year-1).'-12-31 20:00:00':$get_year."-".($get_month-1)."-".date("t",strtotime($get_year.'-'.($get_month-1).'-1')).' 20:00:00');
    
        $query=$this->db->query("select count(*) as count from bugs where start_time <= ? and ((stop_time > ? and status = ?) or (status = ?)) ".$condition_str,
                    array($prev_time,$prev_time,ESC_BUG_STATUS__CLOSED,ESC_BUG_STATUS__OPEN));
        $result = $query->result_array();
        $change=$result[0]['count'];

        if($get_year <= date("Y",time())){
            foreach($days as $day){
                // 1.Opened bugs which start time ahead of the p_time(8:00pm each day)  2. Closed bugs which p_time was between start_time and stop_time
                $query = $this->db->query("select count(*) as count from bugs where start_time <= ? and ((stop_time > ? and status = ?) or (status = ?)) ".$condition_str,
                    array($p_time->format('YmdHis'),$p_time->format('YmdHis'),ESC_BUG_STATUS__CLOSED,ESC_BUG_STATUS__OPEN));
                $result = $query->result_array(); 
                $data['bugs'][$day]['count']=$result[0]['count'];
                $data['bugs'][$day]['day']=$day;
                $data['bugs'][$day]['change']=$result[0]['count']-$change;
                //这里把数据传递给调用方法里的参数
                $data['bug_day_counts'][$day][1] = $result[0]['count'];
                $p_time->add(new DateInterval("P1D"));
                $change = $result[0]['count'];
                if($p_time > new DateTime()) break;
            }
        }else{
            $data['bugs']=array();
        }


        $data['projects'] = $this->project->findProductProjects();
        
        if($this->input->get('project_id')){
             $query=$this->db->query("select city_list from projects where id = ?",array($this->input->get('project_id')));
             $result=$query->row_array();
             $current_project_id=$result['city_list'];  
             //$query=$this->db->query("selesct id,name_chn from areas where id in ( ? )",array($current_project_id),false);
             $query=$this->db->query("select id,name_chn from areas where id in ( ".$current_project_id." )");
             $data['cities'] = $query->result_array();
        }else{
             $this->db->select('id,name_chn');
             $query = $this->db->get('areas');
             $data['cities'] = $query->result_array();
        }
       
        $urls['project_id'] = $this->input->get('project_id');
        $urls['city_id'] = $this->input->get('city_id');
        $urls['year_id'] = $this->input->get('year_id');
        $urls['month_id'] = $this->input->get('month_id');
        $all_types=h_bug_type_array();
        foreach($all_types as $k=>$type){
            $data['types'][$k]['name_chn']=$type;
            $urls['type_id'] = $k;
            $data['types'][$k]['id'] = $k;
            $data['types'][$k]['url'] = h_url_param_str($urls);
        }
        $urls['type_id'] = '';
        $data['type_empty'] = h_url_param_str($urls);

        $urls['project_id'] = $this->input->get('project_id');
        $urls['city_id'] = $this->input->get('city_id');
        $urls['year_id'] = $this->input->get('year_id');
        $urls['type_id'] = $this->input->get('type_id');
        foreach($data['month'] as $k=>$month){
            $j=$k+1;
            $data['months'][$k]['name_chn']=$month;
            $urls['month_id'] = $j;
            $data['months'][$k]['id'] = $j;
            $data['months'][$k]['url'] = h_url_param_str($urls);
        }


        $urls['project_id'] = $this->input->get('project_id');
        $urls['city_id'] = $this->input->get('project_id')?$this->input->get('city_id'):'';
        $urls['month_id'] = $this->input->get('month_id');
        $urls['type_id'] = $this->input->get('type_id');
        foreach($data['year'] as $k=>$year){
            $data['years'][$k]['name_chn']=$year;
            $urls['year_id'] = $k;
            $data['years'][$k]['id'] = $k;
            $data['years'][$k]['url'] = h_url_param_str($urls);          
        }



        $urls['city_id'] = '';
        $urls['year_id'] = $this->input->get('project_id')?$this->input->get('year_id'):date("Y",time());
        $urls['month_id'] = $this->input->get('month_id');
        $urls['type_id'] = $this->input->get('type_id');
        foreach($data['projects'] as &$project){
            $urls['project_id'] = $project['id'];
            $project['url'] = h_url_param_str($urls);
        }
        $urls['project_id'] = '';
        $data['project_empty'] = h_url_param_str($urls);




        $urls['year_id'] = $this->input->get('project_id')?$this->input->get('year_id'):date("Y",time());
        $urls['month_id'] = $this->input->get('month_id');
        $urls['project_id'] = $this->input->get('project_id');
        $urls['type_id'] = $this->input->get('type_id');
        foreach($data['cities'] as &$city){
            $urls['city_id'] = $city['id'];
            $city['url'] = h_url_param_str($urls);
        }
        $urls['city_id'] = '';
        $data['city_empty'] = h_url_param_str($urls);

        $this->load->view('templates/backend_header', $data);
        $this->load->view('maintain/menu');
        $this->load->view('maintain/history');
        $this->load->view('templates/backend_footer');
        
    }

    public function map(){
        $this->dt['title']='故障地图';
 	
        if($this->input->get('station_id')){
        }else{
            $this->dt['station'] = null; 
        }
        //项目
        $query = $this->db->query("select * from projects where is_product=1");       
        $this->dt['projects'] = $query->result_array();
        $projects=array();
        foreach($this->dt['projects'] as $pro){
            array_push($projects,$pro['id']);
        } 
        
        $conditions = array();
        $conditions['type ='] = $this->input->get('type');
        $conditions['status ='] = ESC_BUG_STATUS__OPEN;
        $conditions['city_id ='] = $this->input->get('city_id')?$this->input->get('city_id'):40;
        $condition_array=array();
        $str="";
        foreach($conditions as $k=>$v){
            if($v){
                array_push($condition_array,$k.$v);
            }
        }
        if(count($condition_array)){
            $str .= "where ".implode(" and ",$condition_array);
        }
        $pro_str="";
        if($this->input->get('project_id')){
            $pro_str=" and project_id =".$this->input->get('project_id');
        }else{
            $pro_str=" and project_id in (".implode(',',$projects).")";
        }
        $str.=$pro_str;
        
        $query = $this->db->query("SELECT * FROM bugs ".$str);
        $result=$query->result_array();
        $tmps=array();
        foreach($result as $k=>&$bug){
             $station_id=$bug['station_id'];
             $query = $this->db->query("select * from stations where id = ? ",array($station_id));
             //查询所有符合条件的基站信息
             $station = $query->row_array();
             if(empty($station['lng']) || empty($station['lat'])){
                 continue;
             }
             $tmp_type=h_bug_type_name_chn($bug['type']);
             if(in_array($station_id,array_keys($tmps))){            
                $tmps[$station_id]['type'].='<p>'.$tmp_type.'</p>' ;
             }else{
                $tmps[$bug['station_id']]=array('lng'=>$station['lng'],'lat'=>$station['lat'],'station'=>$station['name_chn'],'type'=>"<p>".$tmp_type."</p>"); 
             }
             
             $query = $this->db->query("select * from projects where id = ? ",array($bug['project_id']));
             $project = $query->row_array();
             $query = $this->db->query("select * from areas where id = ? ",array($bug['city_id']));
             $city = $query->row_array();
             //记录
            
              if($bug['city_id']==$conditions['city_id =']){
                //获取该城市的详细信息
                  $this->dt['city']=$city;
             }
             $bug['station_name_chn'] = $station?$station['name_chn']:"";
             $bug['project_name_chn'] = $project?$project['name_chn']:"";
             $bug['city_name_chn'] = $city?$city['name_chn']:"";
        }
        $this->dt['bugs'] = $result;
        //用来记录故障的,经纬度为空的踢掉
        $this->dt['tmps'] = $tmps;
        
        $query = $this->db->query("select * from areas"); 
        $this->dt['cities'] = $query->result_array();
        $this->dt['bug_types'] = h_bug_type_array();
        
        //var_dump($this->dt['city']);
       
        
        
        
        //拼装url
        $urls['type'] = $this->input->get('type');
        $urls['city_id'] = $this->input->get('city_id')?$this->input->get('city_id'):40;
        foreach($this->dt['projects'] as &$project){
            $urls['project_id'] = $project['id'];
            $project['url'] = h_url_param_str($urls);
        }
        $urls['project_id'] = "";
        $this->dt['project_empty'] = h_url_param_str($urls);


        $urls['project_id'] = $this->input->get('project_id');
        foreach($this->dt['cities'] as &$city){
            $urls['city_id'] = $city['id'];
            $city['url'] = h_url_param_str($urls);
        }
        $urls['city_id'] = '';

        if($this->input->get('city_id')){
            $this->dt['city_id']=$this->input->get('city_id');
        }else{
            $this->dt['city_id']=40;
            
        }
        $urls['city_id'] = $this->input->get('city_id')?$this->input->get('city_id'):40;
        
        
        foreach($this->dt['bug_types'] as $type => &$bug){
            $urls['type'] = $type;
            $name = $bug;
            $bug = array();
            $bug['type'] = $type;
            $bug['name_chn'] = $name;
            $bug['url'] = h_url_param_str($urls);
        }
        $urls['type'] = '';
        $this->dt['type_empty'] = h_url_param_str($urls);
        
        $this->load->view('templates/backend_header',$this->dt);
        $this->load->view('maintain/menu');
        $this->load->view('maintain/map');
        $this->load->view('templates/backend_footer');   
        
    }

}

