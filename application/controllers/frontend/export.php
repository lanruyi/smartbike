<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/********************************
[Controller Export]

********************************/

class Export_controller extends Frontend_Controller{

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('project','data','station','warning','area'));
    }

    function index(){
        $this->dt['title']="数据导出";
        $project_id=$this->current_project['id'];
        $city_id=$this->current_city['id'];

        $this->load->view('templates/frontend_header', $this->dt);
		$this->load->view('frontend/export/index');
        $this->load->view('templates/frontend_footer');
    }

    function save_csv(){

        header( "Cache-Control: public" );
        header( "Pragma: public" );
        header("Content-type:application/vnd.ms-excel");
        header("Content-Disposition:attachment;filename=txxx.csv");
        header('Content-Type:APPLICATION/OCTET-STREAM');
        ob_start();
        $header_str =  iconv("utf-8",'gbk',"信息id,标题,名称,电话,QQ,Email,内容,时间\n");
        $file_str .= "你好,你好,你好,你',好\n";
        $file_str .= "你好,你好,你好,你,好\n";
        $file_str =  iconv("utf-8",'gbk',$file_str);
        ob_end_clean();
        echo $header_str;
        echo $file_str;

    }
}
