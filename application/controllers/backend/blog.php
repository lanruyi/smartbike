<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blog_controller extends Backend_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('mid/mid_station', 'blog', 'station', 'user','project','area'));
    }

    public function index($cur_page = 1) {
        $this->dt['backurlstr'] = urlencode($_SERVER["REQUEST_URI"]);
        $this->dt['users'] = $this->user->findBy_sql(array());

        if ($this->input->get('station_id')) {
            $this->dt['station'] = $this->mid_station->onestation_detail($this->input->get('station_id'));
            $this->dt['title'] = $this->dt['station']['name_chn']." 维护日志 ";
        } else {
            $this->dt['station'] = null;
        }

        $conditions['station_id = '] = $this->input->get('station_id');
        $conditions['author_id = '] = $this->input->get('author_id');
        $conditions['create_time > '] = $this->input->get('start_time');
        $conditions['create_time < '] = $this->input->get('stop_time');
        $per_page = $this->input->get('per_page') ? $this->input->get('per_page') : 30;
        $orders = array("create_time" => "desc");
        $paginator = $this->blog->pagination_sql($conditions, $orders, $per_page, $cur_page);

        $config['base_url'] = '/backend/blog/index/';
        $config['suffix'] = "?" . $_SERVER['QUERY_STRING'];
        $config['first_url'] = $config['base_url'] . $config['suffix'];
        $config['total_rows'] = $paginator['num'];
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $this->dt['pagination'] = $this->pagination->create_links();
        $this->dt['blogs'] = $paginator['res'];

        foreach ($this->dt['blogs'] as &$blog) {
            $station = $this->station->find_sql($blog['station_id']);
            $user = $this->user->find_sql($blog['author_id']);
            $blog['station_name_chn'] = $station ? $station['name_chn'] : "";
            $blog['author_name_chn'] = $user ? $user['name_chn'] : "";
        }

        $this->load->view('templates/backend_header', $this->dt);
        $this->load->view('backend/menu');
        $this->load->view('backend/blog/index');
        $this->load->view('templates/backend_footer');
    }


    public function mod_blog() {   
        $this->dt['mod'] = true;
        $blog = $this->blog->find_sql($this->uri->segment(4));
        $this->dt['blog'] = $blog;
        $this->dt['content'] = $blog['content'];
        $this->dt['station'] = $this->station->find_sql($blog['station_id']);
        $this->dt['user'] = $this->curr_user;
        
        if ($blog['station_id'] > 0) {
            $this->dt['title'] = $this->dt['station']['name_chn']." 更新日志 ";
        } 
        
        $this->load->view('templates/backend_header', $this->dt);
        $this->load->view('backend/menu');
        $this->load->view('backend/blog/mod_blog');
        $this->load->view('templates/backend_footer');
    }

    public function update_blog() {
        $this->blog->update_sql($this->input->post('id'),array(
            'content'   => $this->input->post('content'),
            'blog_type' => $this->input->post('type')));
        $this->session->set_flashdata('flash_succ', '修改很成功!');
        redirect(urldecode($this->input->get('backurl')), 'location');
    }

    public function del_blog() {
        $this->blog->del_sql($this->uri->segment(4));
        $this->session->set_flashdata('flash_succ', '删除成功!');
        redirect(urldecode($this->input->get('backurl')), 'location');
    }


    public function station_blog_add($station_id) {
        $this->blog->insert(array(
            'author_id' => $this->curr_user['id'],
            'station_id'=> $station_id,
            'content'   => $this->input->post('content'),
            'blog_type' => $this->input->post('type')));
        $this->session->set_flashdata('flash_succ', '添加成功!');
        redirect('/backend/blog/index?station_id=' . $station_id, 'location');
     
    }

    public function alist($cur_page = 1){
        $this->dt['title'] = "基站维护日志";
        $this->dt['backurlstr'] = urlencode($_SERVER["REQUEST_URI"]);
        //统计使用日志的用户
        $authors = $this->blog->count_authors();
        $author_ids = h_array_return_single_list($authors,"author_id");
        $this->dt['users'] = $this->user->findUserByIds($author_ids,array('id','name_chn'));
        $this->dt['projects'] = $this->project->findBy(array(),array('ope_type'));
        $this->dt['cities'] = $this->input->get('project_id')?$this->area->findProjectCities($this->input->get('project_id')):$this->area->findAllCities();

        //根据项目和城市 查维护日志
        $conditions = array();
        $conditions['s.project_id ='] = $this->input->get('project_id');
        $conditions['s.city_id ='] = $this->input->get('city_id');
        $conditions['t.author_id ='] = $this->input->get('author_id');
        $conditions['t.create_time >='] = h_dt_start_time_of_hour($this->input->get('start_time'));
        $conditions['t.create_time <'] = h_dt_start_time_of_tommorrow($this->input->get('stop_time'));
        $orders = array("t.create_time"=>"desc");
        $per_page = $this->input->get('per_page')?$this->input->get('per_page'):20;
        $station_params = array("s.name_chn "=>"s_name_chn","s.project_id"=>"s_project_id","s.city_id"=>"s_city_id","s.station_type"=>"s_station_type");
        $paginator = $this->blog->pagination_sql_stations($conditions,$orders,$cur_page,$per_page,$station_params);

        $config['base_url'] = '/backend/blog/alist/';
        $config['suffix'] = "?" . $_SERVER['QUERY_STRING'];
        $config['first_url'] = $config['base_url'] . $config['suffix'];
        $config['total_rows'] = $paginator['num'];
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $this->dt['pagination'] = $this->pagination->create_links();
        $blogs = $paginator['res'];
        $this->dt['blogs'] = array();
        foreach ($blogs as $blog) {
            $blog['author_name_chn'] = $this->user->getUserNameChn($blog['author_id']);
            $blog['city_name_chn'] = $this->area->getCityNameChn($blog['s_city_id']);
            $this->dt['blogs'][] = $blog;
        }

        $this->load->view('templates/backend_header', $this->dt);
        $this->load->view('backend/menu');
        $this->load->view('backend/blog/alist');
        $this->load->view('templates/backend_footer');
    }

    public function download_xls(){
        $cur_page =1 ;
        $per_page = 9999;
        $conditions = array();
        $conditions['s.project_id ='] = $this->input->get('project_id');
        $conditions['s.city_id ='] = $this->input->get('city_id');
        $conditions['t.author_id ='] = $this->input->get('author_id');
        $conditions['t.create_time >='] = h_dt_start_time_of_hour($this->input->get('start_time'));
        $conditions['t.create_time <'] = h_dt_start_time_of_tommorrow($this->input->get('stop_time'));
        $orders = array("t.create_time"=>"desc");
        $station_params = array("s.name_chn "=>"s_name_chn","s.project_id"=>"s_project_id","s.city_id"=>"s_city_id","s.station_type"=>"s_station_type");
        $paginator = $this->blog->pagination_sql_stations($conditions,$orders,$cur_page,$per_page,$station_params);
        $blogs = $paginator['res'];
        $datas = array();
        foreach($blogs as $blog){
            $blog['author_name_chn'] = $this->user->getUserNameChn($blog['author_id']);
            $blog['city_name_chn'] = $this->area->getCityNameChn($blog['s_city_id']);
            $datas[] = $blog;
        }

        $title_name = h_dt_date_str_no_time('').".csv";    
        
        // 输出Excel文件头，可把user.csv换成你要的文件名
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$title_name.'"');
        header('Cache-Control: max-age=0');
        
        $title = array('id'=>'基站id','city_name_chn'=>'城市','s_name_chn'=>'基站名','content'=>'日志内容','create_time'=>'创建时间','author_name_chn'=>'作者');

        // 打开PHP文件句柄，php://output 表示直接输出到浏览器
        $fp = fopen('php://output', 'a');

        // 输出Excel列名信息
        $head = array();
        foreach($title as $v){
        // CSV的Excel支持GBK编码，一定要转换，否则乱码
            $head[] = iconv('utf-8', 'gbk', $v);
        }

        // 将数据通过fputcsv写到文件句柄
        fputcsv($fp, $head);
        foreach($datas as $data){
            $i=0;
            foreach($title as $k=>$field){
                $row[$i] = iconv('utf-8', 'gbk', $data[$k]);
                $i++;
            }            
            fputcsv($fp, $row);
        }
    }   

}
