<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define('DEFAULT_PROJECT_ID',0);
define('ESC_PROJECT_TYPE_STANDARD_SAVING_COMMON',1);
define('ESC_PROJECT_TYPE_NPLUSONE',2);
define('ESC_PROJECT_TYPE_STANDARD_SAVING',3);
define('ESC_PROJECT_TYPE_STANDARD_SAVING_SH',4);

class Project extends ES_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->table_name = "projects";
        $this->load->helper('project');
    }

    public function findProductProjects(){
        return $this->project->findBy(array("is_product"=>1));
    }

    //根据基站ID返回项目名 
    public function getProjectNameChn($project_id){
        if(!$project_id) return "无";
        $project = $this->find($project_id);
        return $project? $project['name_chn']:"无"; 
    }

    //返回一个项目类型的项目
    public function findProjectTypeProjects($project_type){
        $user_projects= $this->project->getUserProjects($this->curr_user['id'],$project_type);
        return $user_projects;
    }

    public function getNewfrontProjectFuncName($project_id){
        $func_name = "js";
        if($project_id == 4){
            $func_name = "js";
        }elseif($project_id == 104){
            $func_name = "gx";
        }else{
            $project = $this->project->find($project_id);
            if($project){
                if(ESC_PROJECT_TYPE_STANDARD_SAVING == $project['type']){
                    $func_name = "gx";
                }
                if(ESC_PROJECT_TYPE_STANDARD_SAVING_COMMON == $project['type']){
                    $func_name = "js";
                }
                if(ESC_PROJECT_TYPE_NPLUSONE== $project['type']){
                    $func_name = "np1";
                }
            }
        }
        return $func_name;
    }

    //////////////////// 这边往下的都需要重构 ///////////////////////



    public function getMaintainProjects(){
        $query = $this->db->query("select * from projects where is_product = 1");
        return $query->result_array();
    }


    public function getSelectProjects($type=null){
        if($type){
            $query = $this->db->query("select * from projects where is_product = 1 and type=?",array($type));
        }else{
            $query = $this->db->query("select * from projects where is_product = 1");
        }
        return $query->result_array();
    }

    public function getAllProjects(){
        $query = $this->db->query("select * from projects");
        return $query->result_array();
    }

    public function getProductCities(){
        $query = $this->db->query("select city_list from projects where is_product = 1 and city_list<>\"\"");
        $city_ids = array(); 
        foreach ($query->result_array() as $p){
            array_push($city_ids,$p['city_list']);
        }
        if($city_ids){
            $query = $this->db->query("select * from areas where id in (".implode(',',$city_ids).")");
            return $query->result_array();
        }else{
            return array();
        }
    }

    public function getProjectsByIds($pids = array()){
        if($pids){
            $query = $this->db->query("select * from projects where id in (?)",array(implode(',',$pids)));
            return $query->result_array();
        }else{
            return array();
        }
    }

    public function getEachProjectCities_sql(){
        $projects = $this->findBy_sql(array());
        $prj_cities = array();
        foreach($projects as $project){
            $cities_array = $this->getCitiesName_sql($project['id']);
            $prj_cities[$project['id']] = $cities_array;
        }
        return $prj_cities;
    }

    public function getCitiesName_sql($project_id){
        $query = $this->db->query("select city_list from projects where id=?",array($project_id));
        $city_list = $query->row_array();
        $city_ids = explode(',',$city_list['city_list']);
        foreach($city_ids as $city_id){
            $cities[$city_id] = $this->area->getCityNameChn($city_id);
        }
        return $cities;
    }

    public function getAndInitConfigs($project_id){
        $project = $this->project->find_sql($project_id);
        if($project){
            $configs = json_decode($project['config_str'],true);
            $need_save = false;
            if(!isset($configs['highest_indoor_tmp'])){
                $configs['highest_indoor_tmp'] = 37;
                $need_save = true;
            }
            if(!isset($configs['no_box_highest_indoor_tmp'])){
                $configs['no_box_highest_indoor_tmp'] = 30;
                $need_save = true;
            }
            if(!isset($configs['highest_box_tmp'])){
                $configs['highest_box_tmp'] = 29;
                $need_save = true;
            }
            if($need_save){
                $project['config_str']=json_encode($configs);
                $this->update_sql($project['id'], $project);
            }
            return $configs;
        }
    }


    public function setTmp($project_id,$highest_indoor_tmp,$no_box_highest_indoor_tmp,$highest_box_tmp){
        $project = $this->project->find_sql($project_id);
        $configs = json_decode($project['config_str'],true);
        $configs['highest_indoor_tmp'] = $highest_indoor_tmp;
        $configs['no_box_highest_indoor_tmp'] = $no_box_highest_indoor_tmp;
        $configs['highest_box_tmp'] = $highest_box_tmp;
        $project['config_str']=json_encode($configs);
        $this->update_sql($project_id, $project);
        return $project;
    }



    //返回某个用户拥有权限的所有项目
    public function getUserProjects($user_id,$type){
        $query = $this->db->query("select * from projects left join user_projects 
            on projects.id = user_projects.project_id where user_id=? and ope_type=?",array($user_id,$type));
        return $query->result_array();
    }


    public function findAliveProjects(){
        return $this->findBy_sql(array("is_product"=>ESC_NORMAL));
    }

}

