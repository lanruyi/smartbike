<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Exploration_controller extends Backend_Controller{

    function __construct()
    {
        parent::__construct();
        $this->load->model(array("appin"));
        $this->load->helper(array("xml","file","appxml"));
    }


    public function single($id){
        $this->dt['title'] = "工勘站点";
        $exploration_items = appxml_newest_items("exploration");
        $appin = $this->appin->find($id);
        $gk_station = json_decode($appin['content'],true);
        $gk_station['id']        = $appin['id'];
        $gk_station['user_id']   = $appin['user_id'];
        $gk_station['user_name'] = $this->user->getUserNameChn($appin['user_id']);
        $this->dt['gk_station']       = $gk_station;
        $this->dt['exploration_items']=$exploration_items;
        //vimjumper ../../views/newback/exploration/single.php
        $this->load->view('newback/exploration/single',$this->dt);
    }

    public function slist($curr_page = 1){
        $this->dt['title'] = "工勘站点列表";
        $exploration_items = appxml_newest_items("exploration");
        $per_page = 4;
        $filters = $this->input->get();
        $this->dt["users"] = $this->user->findAllUsers();
        $gk_stations=array();
        if($user_id = $this->input->get("user_id")){
            $this->appin->where(array("user_id"=>$user_id));
        }
        $appins = $this->appin->findBy(array("type"=>"exploration"),array("datetime desc"));
        foreach($appins as $appin){
            $gk_station = json_decode($appin['content'],true);
            $gk_station['id']        = $appin['id'];
            $gk_station['datetime']  = $appin['datetime'];
            $gk_station['user_id']   = $appin['user_id'];
            $gk_station['user_name'] = $this->user->getUserNameChn($appin['user_id']);
            $gk_stations[] = $gk_station;
        }

        $result_gk_stations = $gk_stations;
        if($filters){
            foreach($filters as $key => $val){
                if($val == 0) continue;
                $mid_gk_stations = array();
                foreach($result_gk_stations as $gk_station){
                    if(isset($gk_station[$key]) && 
                        in_array( $val , h_clean_array_null(explode(",",$gk_station[$key])) ) ){
                            $mid_gk_stations[] = $gk_station;
                    }
                }
                $result_gk_stations = $mid_gk_stations;
            }
        }


        $config['full_tag_open']	= '';
        $config['full_tag_close']	= '';
        $config['first_tag_open']		= '';
        $config['first_tag_close']	= '';
        $config['last_tag_open']		= '';
        $config['last_tag_close']	= '';
        $config['next_tag_open']		= '';
        $config['next_tag_close']	= '';
        $config['prev_tag_open']		= '';
        $config['prev_tag_close']	= '';
        $config['cur_tag_open']		= ' ';
        $config['cur_tag_close']	= ' ';
        $config['num_tag_open']		= '';
        $config['num_tag_close']	= '';
        $config['full_tag_open']	= '<span class="pagination2">';
        $config['full_tag_close']	= '</span>';

        $config['next_link']		= '下一页&gt;';
        $config['prev_link']		= '&lt;上一页';
        $config['first_link']		= '首页';
        $config['last_link']		= '尾页';
        $config['has_tail']	= FALSE;
        $config['base_url'] = '/newback/exploration/slist';
		$config['suffix'] = "?".$_SERVER['QUERY_STRING'];
        $config['first_url'] = $config['base_url'].$config['suffix'];
	    $config['total_rows'] = count($result_gk_stations);
	    $config['per_page'] = $per_page; 
	    $this->pagination->initialize($config); 
		$this->dt['pagination'] = $this->pagination->create_links();
        $pagination_stations = array_chunk($result_gk_stations,$per_page);

        $this->dt['num_str'] = h_filter_num_str(count($result_gk_stations),$curr_page,$per_page);
        $this->dt['gk_stations'] = $pagination_stations?$pagination_stations[$curr_page-1]:array();
        $this->dt['exploration_items']=$exploration_items;
        //vimjumper ../../views/newback/exploration/slist.php
        $this->load->view('newback/exploration/slist',$this->dt);
    }

}
