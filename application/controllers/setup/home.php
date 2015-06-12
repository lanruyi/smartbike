<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home_controller extends Setup_Controller{

    function __construct() {
        parent::__construct();
        $this->load->model(array('userlog', 'mid/mid_data', 'correct', 'project', 'esg', 
            'station', 'area', 'user', 'blog','data_ext','command','station_log','esgfix'));
        $this->load->helper(array('esgconf'));
    }

    public function index(){
        $this->load->view('templates/setup_header', $this->dt);
        $this->load->view('setup/menu');
        $this->load->view('setup/home/index');
        $this->load->view('templates/setup_footer');
    }

    public function nearestUnderConstructNewStation() {
        $station = $this->station->findUserNearestNewStation($this->curr_user);
        $station_id = $station ? $station['id'] : 0;
        redirect("/setup/home/station/" . $station_id, "location");
    }

    public function station($station_id = 0) {
        $this->dt['title'] = "新建基站";
        $this->dt['projects'] =$this->project->findBy(array(),array('ope_type'));
        $station = $this->station->find($station_id);
        if($station){
            $station['city'] = $this->area->find_sql($station['city_id']);
            $station['esg'] = $this->esg->getEsg($station_id);
            $station['district'] = $station['district_id']?$this->area->find_sql($station['district_id']):"";
        }
        $this->dt['station'] = $station;
        $this->dt['blog'] = $this->blog->findUserStationNearestBlog($this->curr_user['id'], $station_id);
        $this->dt['corrects'] = $this->correct->findBy_sql(
                array("station_id"=>$station_id),array("time desc"));
        $this->dt['prj_cities'] = json_encode($this->project->getEachProjectCities_sql());
        $this->dt['city_districts'] = json_encode($this->area->getEachCityDistricts_sql());
        $this->load->view('templates/setup_header', $this->dt);
        $this->load->view('setup/menu');
        $this->load->view('setup/home/station');
        $this->load->view('templates/setup_footer');
    }
    
    


    public function save_esg($station_id = 0) {
        $data['title'] = "";
        $esg_id = $this->input->get('esg_id');
        $station = $this->station->find_sql($station_id);

        if ($station){
            $esg = $this->esg->find_sql($esg_id);
            if ($esg){
                if ($esg["station_id"]) {
                    $this->session->set_flashdata('flash_err', '这个ESG已经挂在在基站'.$esg["station_id"]);
                }else{

                    $this->esg->update($esg_id,array("station_id"=>$station_id));
                    if($station['old_esg_id'] != $esg_id){
                        if($station['old_esg_id']){
                            //增加一条维修记录
                            $this->esgfix->addEsgChange($station_id,$station['old_esg_id'],$esg_id,$this->curr_user['id']);
                        }
                        $this->station->update($station_id,array("old_esg_id"=>$esg_id));
                    }
                    //装成功后即发送1条远程控制指令
                    $station = $this->station->find_sql($station_id);
                    $arg_str_array = array();
                    $_params = array();
                    $_params['highest_indoor_tmp'] = 37;
                    $_params['colds_box_type'] = h_station_box_exchange_command($station['box_type']);
                    $_params['colds_0_ctrl_type'] = h_station_colds_exchange_command($station['colds_0_func']);
                    $_params['colds_1_ctrl_type'] = h_station_colds_exchange_command($station['colds_1_func']);
                    foreach (h_esgconf_array() as $_c => $_esgconf) {
                        if(!isset($_params[$_esgconf['en']])){
                            array_push($arg_str_array, "\"\"");
                        }else{
                            if (h_esgconf_is_str($_c)) {
                                array_push($arg_str_array, "\"" . $_params[$_esgconf['en']] . "\"");
                            } else {
                                array_push($arg_str_array, $_params[$_esgconf['en']]);
                            }
                        }
                    }
                    $_arg_str = "[" . implode(",", $arg_str_array) . "]";
                    $this->command->newStCommand($station_id,$_arg_str,200);
                    $this->command->newOnCommand($station_id, 200);
                    $this->command->newGSCommand($station_id, 200);
                    $this->command->newGpCommand($station_id,null, 200);
                    
//                    $this->command->newStCommand($station_id,$_arg_str,$this->curr_user['id']);
//                    $this->command->newOnCommand($station_id, $this->curr_user['id']);
//                    $this->command->newStCommand_mode1($station_id, $this->curr_user['id']);
//                    $this->command->newGpCommand($station_id,null, $this->curr_user['id']);
                   // $this->command->newGSCommand($station_id, $this->curr_user['id']);
                    
                    $this->session->set_flashdata('flash_succ', 'ESG挂载成功,4条下行测试命令已列入到该基站的命令队列，请检查执行情况!');
                }
            } else {
                $this->session->set_flashdata('flash_err', '没有这个ESG!');
            }
        } else {
            $this->session->set_flashdata('flash_err', '没有这个基站!');
        }
        redirect('/setup/home/station/' . $station_id, 'local');
    }


    public function del_esg($station_id = 0) {
        $data['title'] = "";
        $station = $this->station->find_sql($station_id);
        if ($station) {
            $esg = $this->esg->findOneBy_sql(array("station_id"=>$station_id));
            if ($esg) {
                $this->esg->update_sql($esg['id'],array("station_id"=>null));
                //插入修改基站的日志
                $station_log = array();
                $station['esg_id'] = $esg['id'];
                $station_log['original_content'] = json_encode($station);
                $station_log['create_time'] = h_dt_now();
                $station_log['station_id'] = $station_id;
                $station_log['creator_id'] = $this->session->userdata('user_id');
                $station_log['change_content'] = json_encode(array('esg_id'=>0));
                $this->station_log->insert($station_log);
                $this->session->set_flashdata('flash_succ', 'ESG解除成功!');
            } else {
                $this->session->set_flashdata('flash_err', '没有挂载esg!');
            }
        } else {
            $this->session->set_flashdata('flash_err', '没有这个基站!');
        }
        redirect('/setup/home/station/' . $station_id, 'local');
    }
    
    public function em_single_station_data($station_id = 0) {
        $data['title'] = "简单数据";
        $station = $this->station->find_sql($station_id);
        $esg = $this->esg->findOneBy_sql(array("station_id"=>$station_id));
        $data['station'] = $station;
        $data['esg'] = $esg;
        if ($station) {
            $datas = $this->mid_data->findRecentDatas($station_id,8);
            $data['datas'] = $datas; 
        } else {
            $data['datas'] = array();
        }
        $this->load->view('setup/home/em_single_station_data', $data);
    }
    


    public function station_create_blog($station_id = 0) {
        $station = $this->station->find_sql($station_id);
        if ($station) {
            $this->blog->insert(array(
                'content'=>$this->input->get('content'),
                'station_id'=>$station_id,
                'author_id'=>$this->curr_user['id']));
        }
        redirect('/setup/home/station/' . $station_id, 'local');
    }
        
    
    //创建新基站
    public function ajax_new_station_sql() {
        $params = $this->input->get();
        $params["creator_id"] = $this->curr_user['id'];
        $params['name_chn'] = trim($params['name_chn']);
        $params['colds_num'] = $params['colds_1_func']==ESC_STATION_COLDS_FUNC_NONE?1:2;
        $params['total_load'] = h_get_total_load_by_load_num($params['load_num']);
        $params['have_box'] = $params['box_type']==ESC_STATION_BOX_TYPE_NONE?ESC_HAVE_BOX_NONE:ESC_HAVE_BOX;
        if(ESC_STATION_TYPE_NPLUSONE == $params['station_type'] ) {
            $params['ns']=6;
        }
        $this->station->new_sql($params);
        $station_id = $this->db->insert_id();
        echo '{"id":' . $station_id . ',"name_chn":"' . $params['name_chn'] . '"}';
        $this->session->set_flashdata('flash_succ', '基站' . ($params['name_chn']. "创建") . '成功!');
        redirect('/setup/home/station/'.$station_id , 'local');
    } 

    
    //刷新故障
    public function ajax_get_new_work_orders(){
        $query = $this->db->query("select * from work_orders where dispatcher_id=? and create_time>? and is_history=?",array($this->session->userdata('user_id'),date("Y-m-d H:i:s",$this->input->get("currentTime")),ESC_WORK_ORDER_ALIVE));
        echo json_encode($query->result_array());
    }

}
