<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home_controller extends Backend_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('mid/mid_station','command', 'station', 'warning', 'cmail', 'data', 'project', 'esg','area','user'));
    }
    public function index() {
        $this->load->view('templates/back_header', $this->dt);
        $this->load->view('templates/back_menu');
        $this->load->view('backend/home/index');
        $this->load->view('templates/back_footer');
    }

    //public function index() {
        //$data['title'] = "整体报告";

        //$mem_key = "total_total_for_backend_home";
        //$cache_time = 5;
        //$result = $this->cache->get($mem_key);
        //if (!$result) {
            //$result = array();
            //$query = $this->db->query("select count(id) a from stations where recycle=".ESC_NORMAL);
            //$res = $query->row_array();
            //$result['total_station'] = $res['a'];
            //$query = $this->db->query("select count(id) a from stations where alive=" . ESC_ONLINE . "  and recycle=".ESC_NORMAL );
            //$res = $query->row_array();
            //$result['alive_station'] = $res['a'];
            //$query = $this->db->query("select count(id) a from esgs ");
            //$res = $query->row_array();
            //$result['total_esg'] = $res['a'];
            //$query = $this->db->query("select count(id) a from esgs where alive =" . ESC_ONLINE . " ");
            //$res = $query->row_array();
            //$result['alive_esg'] = $res['a'];

////            $query = $this->db->query('show table status from esdata');
////            $res_query = $query->result_array();
////            $result['size'] = ($res_query[7]['Data_length'] + $res_query[7]['Index_length']) / 1000000.0;

            //$this->cache->save($mem_key,$result,$cache_time);
        //}
        //$data = $data + $result;


        //$this->load->view('templates/backend_header', $data);
        //$this->load->view('backend/menu');
        //$this->load->view('backend/home/index');
        //$this->load->view('templates/backend_footer');
        //$this->output->enable_profiler($this->input->get('debug'));
    //}


    public function server_info() {
        $data['title'] = "server info";
        $_str = "";
        $_str .= $this->load->view('templates/backend_header', $data, true);
        $_str .= $this->load->view('backend/menu', $data, true);
        $_str .= "<iframe frameborder=0 border=0 style='width:100%;height:1700px;border:0' src='/static/esp.php'></iframe>";
        $_str .= $this->load->view('templates/backend_footer', $data, true);
        echo $_str;
    }

    public function apc_info() {
        $data['title'] = "apc info";
        $_str = "";
        $_str .= $this->load->view('templates/backend_header', $data, true);
        $_str .= $this->load->view('backend/menu', $data, true);
        $_str .= "<iframe frameborder=0 border=0 style='width:100%;height:1700px;border:0' src='/static/apc.php'></iframe>";
        $_str .= $this->load->view('templates/backend_footer', $data, true);
        echo $_str;
    }

    public function onebridge($station_id = 0) {
        $data['title'] = "one bridge";
        $data['backurlstr'] = urlencode($_SERVER["REQUEST_URI"]);

        $station_id != 0 or $station_id = 16;
        $station = $this->mid_station->onestation_detail($station_id);
        if (!$station) {
            show_error('no station');
        }
            
        $data['station'] = $station;
        $t = new DateTime($this->input->get('t'));
        $a = $this->input->get('a');
        if (!$a) {
            $and = 'd={"' . $t->format('Y-m-d H:i:s') . '":[33,35,4,8,22,1,1,0,2,"",31,32,"","","",1,500,67788,460,45645,"","","","","","","",""]}';
        } else if ($a == 1) {
            $and = 'd={"' . $t->format('Y-m-d H:i:s') . '":["","","","","","","","","","","","","","","","","","","","","","","","","","","",""]}';
        } else if ($a == 2) {
            $_command = $this->command->findOneBy_sql(array("station_id" => $station_id, "status" => 1));
            $c_id = $_command ? $_command['id'] : "1";
            $and = 'f={"' . $c_id . '":"success"}';
        } else if ($a == 3) {
            $and = 't={"s":["","","","","","","","","","","","","","","","","","","","","","","","","","",""],"p":["2012090321",""]}';
        } else if ($a == 4) {
            $and = 'w={"123123123":[17,19,21,22]}';
        } else if ($a == 5) {
            $and = 'cw={"123123123":[17,19,21,22]}';
        } else if ($a == 6) {
            $and = 'p={"p11":"xxxooo","p12":"iiiiii"}';
        }

        $data['body'] = 's=' . ($station['esg'] ?  $station['esg']['id'] : "") . '&' . $and;
        $this->load->view('templates/backend_header', $data);
        $this->load->view('backend/menu');
        $this->load->view('backend/onebridge');
        $this->load->view('templates/backend_footer');
    }

}

