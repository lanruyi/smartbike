<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Edge_controller extends Backend_Controller{

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('edge','station'));
        $this->load->helper(array('station'));
        $this->load->library(array('pagination'));
    }

    public function index($cur_page = 1) {
        $data['title'] = "边界管理";
        $data['backurlstr'] = urlencode($_SERVER["REQUEST_URI"]);

        $conditions = array();

        $per_page = $this->input->get('per_page') ? $this->input->get('per_page') : 20;

        $orders = array("id" => "desc");
        $paginator = $this->edge->pagination_sql($conditions, $orders, $per_page, $cur_page);
        $config['base_url'] = '/backend/edge/index/';
        $config['suffix'] = "?" . $_SERVER['QUERY_STRING'];
        $config['first_url'] = $config['base_url'] . $config['suffix'];
        $config['total_rows'] = $paginator['num'];
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['edges'] = $paginator['res'];

        $this->load->view('templates/backend_header', $data);
        $this->load->view('backend/menu', $data);
        $this->load->view('backend/edge/index', $data);
        $this->load->view('templates/backend_footer', $data);
    }

    public function mod_entity($edge_id){
        $data['title'] = "修改边界";
        $data['mod'] = true;
        $data['edge'] = $this->edge->find_sql($edge_id);
        $this->load->view('templates/backend_header', $data);
        $this->load->view('backend/menu');
        $this->load->view('backend/edge/new_entity');
        $this->load->view('templates/backend_footer');
    }


    public function new_entity(){
        $data['title'] = "新建边界";
        $data['mod'] = false;
        $this->load->view('templates/backend_header', $data);
        $this->load->view('backend/menu');
        $this->load->view('backend/edge/new_entity');
        $this->load->view('templates/backend_footer');
    }

    public function insert_edge(){   	
        $this->edge->new_sql(array("name_chn"=>$this->input->post('name_chn'),
        "edge_desc"=>$this->input->post('edge_desc'),
        "query"=>$this->input->post('query'),
        "time_slot"=>$this->input->post('time_slot'),
        "threshold"=>$this->input->post('threshold')));
        redirect('/backend/edge', 'location');
    }

    public function update_edge(){   	
        $edge_id = $this->input->post('id');
        if($edge_id){
        $this->edge->update_sql($edge_id,array("name_chn"=>$this->input->post('name_chn'),
            "edge_desc"=>$this->input->post('edge_desc'),
            "query"=>$this->input->post('query'),
            "time_slot"=>$this->input->post('time_slot'),
            "threshold"=>$this->input->post('threshold')));
        }
        redirect('/backend/edge', 'location');
    }

    public function test($edge_id){
        $edge = $this->edge->find_sql($edge_id);
        $t = new DateTime;
        $stop_str = $t->format('YmdHis');
        $t->sub(new DateInterval($edge['time_slot']));
        $start_str = $t->format('YmdHis');
        $query = $this->db->query($edge['query'], array($start_str, $stop_str));
        $this->session->set_flashdata('flash_succ', "测试已经完成");
        $this->db->query("delete from station_edges where edge_id = ".$edge_id);
        foreach  ($query->result_array() as $item){
            if($item['a'] > $edge['threshold']){
                $this->db->query("insert into station_edges (station_id,edge_id,nums) values (".$item['station_id'].",".$edge_id.",".$item['a'].")");
            }
        }
        $query = $this->db->query("select count(*) a from station_edges where edge_id = ".$edge_id);
        $res = $query->result_array();
        $this->edge->update_sql($edge_id,array(
            "station_nums"=>$res[0]['a'],
            "last_query_time"=>h_dt_now()));
        redirect(urldecode($this->input->get('backurl')), 'location');
    }

    public function stations($edge_id){
        $data['title'] = "基站列表";
        $data['backurlstr'] = urlencode($_SERVER["REQUEST_URI"]);

        $edge = $this->edge->find_sql($edge_id);
        $query = $this->db->query("
            select stations.name_chn station_name, projects.name_chn project_name, areas.name_chn area_name,
            nums,station_type
            from station_edges left join stations on station_edges.station_id = stations.id 
            left join projects on stations.project_id = projects.id left join areas on stations.city_id = areas.id
            where  edge_id=".$edge_id." order by project_id, city_id,nums desc ");
        $data['stations'] = $query->result_array();
        $data['edge'] = $edge;
        $this->load->view('templates/backend_header', $data);
        $this->load->view('backend/menu');
        $this->load->view('backend/edge/stations');
        $this->load->view('templates/backend_footer');
    }
	
}




