<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


define('ESC_SITE__FRONTEND',1);
define('ESC_SITE__BACKEND',2);
define('ESC_OS_ANDROID', 1);
define('ESC_OS_IOS', 2);
define('ESC_OS_OTHERS', 3);

class ES_Controller extends CI_Controller{

    var $current_project;
    var $current_city;
    var $current_user;
    var $user_role;
    var $project_cities;

    var $site;
    var $dt;

    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('user_agent');
        $this->load->model(array('mid/user_sess','user', 'role', 'userlog', 'project', 'rom','area'));

        if (!$this->user_sess->is_logged_in()) {
            $this->session->set_userdata('his_url', $_SERVER["REQUEST_URI"]);
            redirect('/user/login');
        } else {
            $this->curr_user = $this->user_sess->findCurrentUser();
        }
        
        $this->get_current_os();
        $this->user_role = $this->role->find($this->curr_user['role_id']);
        $this->dt['title']= "";
        $this->dt['backurlstr'] = urlencode($_SERVER["REQUEST_URI"]);
        //如果有debug 则打印出调试信息
        if($this->input->get('debug') == "cx"){
            $this->output->enable_profiler();
        }
    }
    
    function get_current_os() {
        $agent_str =  $this->agent->agent_string();
        if (substr_count($agent_str, "Android")) {
           $this->current_os = ESC_OS_ANDROID;
        } elseif (substr_count($agent_str, "iPhone")) {
            $this->current_os = ESC_OS_IOS;
        } else {
             $this->current_os = ESC_OS_OTHERS;
        }
    }

    function make_cookies($name,$value,$default = null){
        if($value === false){
            $value = $this->input->cookie($name);
        }
        if(!$value){
            $value = $default;
        }
		// xxx chuanqi, comment this for everythis n+1 will enter into zhuanqiang
		// everytime u change to a "n+1" project, to be resovled
        //$this->input->set_cookie($name,$value, 86000*3);
        return $value;
    }


}


class Ajax_Controller extends ES_Controller{
    function __construct()
    {
        parent::__construct();
    }

}

class Newfront_Controller extends ES_Controller{

    function __construct()
    {
        parent::__construct();
        $this->dt['title']="";
    }

}


class Frontend_Controller extends ES_Controller{

    function __construct()
    {
        parent::__construct();
        $this->current_project = $this->project->find_sql($this->curr_user['current_project_id']);
        if(!$this->current_project){
            redirect('/backend','local');
        }
        $this->project_cities = $this->area->findProjectCities($this->current_project['id']);
        $city_id = $this->input->cookie('current_city_id');
        if($city_id){
            $this->current_city = $this->area->find_sql($city_id);
        }else{
            $this->current_city = $this->project_cities[0];
        }
        
        //普通地级用户只能进入默认城市
        if($this->user_role['id'] == 6) {
            $this->current_city = $this->area->find_sql($this->curr_user['default_city_id']);
        }
        $this->dt['title']="";
    }

}


class Statistic_Controller extends ES_Controller{
    function __construct()
    {
        parent::__construct();
    }
}
class Maintain_Controller extends ES_Controller{
    function __construct()
    {
        parent::__construct();
    }
}
class Setup_Controller extends ES_Controller{
    function __construct()
    {
        parent::__construct();
    }
}
class Analysis_Controller extends ES_Controller{
    function __construct()
    {
        parent::__construct();
    }
}
class Aging_Controller extends ES_Controller{
    function __construct()
    {
        parent::__construct();
    }
}
class Rake_Controller extends ES_Controller{
    function __construct()
    {
        parent::__construct();
    }
}


class Backend_Controller extends ES_Controller{

    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('bug','station'));
        $this->authority();
    }

    private function authority(){
        $uri_authority = array(
            //frontend
            "frontend/single/control"=>array(ESC_AUTHORITY__FRONTEND_CONTROL),
            //backend	
            "backend/data"=>array(ESC_AUTHORITY__BACKEND_STATION_DATA),
            "backend/station"=>array(ESC_AUTHORITY__BACKEND_STATION_DATA),
            "backend/waring"=>array(ESC_AUTHORITY__BACKEND_STATION_DATA),
            "backend/command"=>array(ESC_AUTHORITY__BACKEND_STATION_DATA),
            "backend/setting"=>array(ESC_AUTHORITY__BACKEND_STATION_DATA),
            "backend/esg"=>array(ESC_AUTHORITY__BACKEND_ESG),
            "backend/tool"=>array(ESC_AUTHORITY__BACKEND_INSTALLATION),
            "backend/blog"=>array(ESC_AUTHORITY__BACKEND_STATION_LOG),
            "backend/area"=>array(ESC_AUTHORITY__BACKEND_ADMINISTRATOR),
            "backend/cmail"=>array(ESC_AUTHORITY__BACKEND_ADMINISTRATOR),
            "backend/rom"=>array(ESC_AUTHORITY__BACKEND_ADMINISTRATOR),
            "backend/user"=>array(ESC_AUTHORITY__BACKEND_ADMINISTRATOR),
            "backend/userlog"=>array(ESC_AUTHORITY__BACKEND_ADMINISTRATOR),
            "backend/role"=>array(ESC_AUTHORITY__BACKEND_ADMINISTRATOR),
            "backend/department"=>array(ESC_AUTHORITY__BACKEND_ADMINISTRATOR),
            "backend/project"=>array(ESC_AUTHORITY__BACKEND_ADMINISTRATOR),
            "backend/Station_and_project"=>array(ESC_AUTHORITY__BACKEND_ADMINISTRATOR),
            "backend/reports"=>array(ESC_AUTHORITY__BACKEND_ADMINISTRATOR),
            "backend/home"=>array(ESC_AUTHORITY__BACKEND_ADMINISTRATOR),
            //reporting
            "reporting"=>array(ESC_AUTHORITY__REPORTING),
            "reporting/home"=>array(ESC_AUTHORITY__REPORTING),
            "reporting/home/set_sav_pairs"=>array(ESC_AUTHORITY__REPORTING),
            "reporting/table/summarydata"=>array(ESC_AUTHORITY__REPORTING),
            "reporting/table/savpairsdata"=>array(ESC_AUTHORITY__REPORTING),
            "reporting/table/comstationdata"=>array(ESC_AUTHORITY__REPORTING)
        );


        $uri_str = $this->uri->uri_string();
        if(!$uri_str){return;}

        $necessary_auth = array();	
        foreach ($uri_authority as $key => $auths){
            if(strpos($uri_str,$key)===0){ $necessary_auth += $auths; }
        }
        foreach ($necessary_auth as $auth){
            if(!h_auth_check_role($this->user_role,$auth)){
                echo "Sorry, you have no permission to access this page!";
                exit(0);
            }
        }

    }

}




