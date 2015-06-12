<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inspection_controller extends Backend_Controller{

	function __construct()
	{
		parent::__construct();
		$this->load->model(array("appin", "user"));
		$this->load->helper(array("xml","file","appxml"));
	}


	public function single($id){
		$this->dt['title'] = "巡检站点";
		$inspection_items = appxml_newest_items("inspection");
		$appin = $this->appin->find($id);
		$gk_station = json_decode($appin['content'],true);
		$gk_station['id']        = $appin['id'];
		$gk_station['user_id']   = $appin['user_id'];
		$gk_station['user_name'] = $this->user->getUserNameChn($appin['user_id']);
		$this->dt['gk_station']       = $gk_station;
		$this->dt['inspection_items']=$inspection_items;
		//vimjumper ../../views/newback/inspection/single.php
		$this->load->view('newback/inspection/single',$this->dt);
	}

	public function slist($curr_page = 1){
		$this->dt['title'] = "巡检站点列表";
		$inspection_items = appxml_newest_items("inspection");
		$per_page = 4;
		$filters = $this->input->get();
		$this->dt["users"] = $this->user->findAllUsers();
		$gk_stations=array();
                
                $user_name_chn = $this->input->get("user_name_chn");
                $user = $user_name_chn?$this->user->findOneBy_sql(array("name_chn" => $user_name_chn)):array();
                $user_id = $user?$user['id']:"";
		if($user_id){
                    $this->appin->where(array("user_id"=>$user_id));
		}
		if ($create_start_time = $this->input->get("create_start_time")){
			$this->appin->where("(datetime > ".h_dt_format($create_start_time).")");
		}

		if ($create_stop_time = $this->input->get("create_stop_time")){
			$this->appin->where("(datetime < ".h_dt_stop_time_of_day($create_stop_time).")");
		}
		unset($filters["create_start_time"]);
		unset($filters["create_stop_time"]);
		$appins = $this->appin->findBy(array("type"=>"inspection"),array("datetime desc"));
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
		$config['base_url'] = '/newback/inspection/slist';
		$config['suffix'] = "?".$_SERVER['QUERY_STRING'];
		$config['first_url'] = $config['base_url'].$config['suffix'];
		$config['total_rows'] = count($result_gk_stations);
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$this->dt['pagination'] = $this->pagination->create_links();
		$pagination_stations = array_chunk($result_gk_stations,$per_page);

		$this->dt['num_str'] = h_filter_num_str(count($result_gk_stations),$curr_page,$per_page);
		$this->dt['gk_stations'] = $pagination_stations?$pagination_stations[$curr_page-1]:array();
		$this->dt['inspection_items']=$inspection_items;
		//vimjumper ../../views/newback/inspection/slist.php
		$this->load->view('newback/inspection/slist',$this->dt);
	}

}
