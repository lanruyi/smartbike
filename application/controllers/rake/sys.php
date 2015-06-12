<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sys_controller extends CI_Controller{
    
    function __construct()
    {
        if (isset($_SERVER['REMOTE_ADDR'])) {  
            //echo('Command Line! Be careful<br><br>');  
        }  
        parent::__construct();
        $this->load->model(array('warning','station'));
        $this->load->library(array('curl'));
    }
    
    //重定义不同类型报警的优先级或者完成类型后 用于处理历史数据
    public function refresh_warning_table($fast = true){
        //todo
        echo '<meta http-equiv="Content-type" content="text/html; charset=utf-8" />';
        echo "warning表更新完毕!";
    }

    //数据库升级到最新版本
    public function migrate($debug=0)
    {
        $this->load->library('migration');
        if ( ! $this->migration->current())
        {
            show_error($this->migration->error_string());
        }
        echo '<meta http-equiv="Content-type" content="text/html; charset=utf-8" />';
        echo "database update!";
        if($debug){
            $this->output->enable_profiler();
        }
    }

    //数据库降级到最新版本的上一个版本
    public function migrate_down()
    {
        $this->load->library('migration');
		$this->config->load('migration');
        if ( ! $this->migration->version($this->config->item('migration_version')-1))
        {
            show_error($this->migration->error_string());
        }
        echo '<meta http-equiv="Content-type" content="text/html; charset=utf-8" />';
        echo "数据库降级完毕!";
        //$this->output->enable_profiler();
    }

    //数据库转换到任意一个版本（慎重使用 要保证都有相应的migration down）
    public function migrate_to($version=0)
    {
        $this->load->library('migration');
		$this->config->load('migration');
        if(!$version){
            echo '<meta http-equiv="Content-type" content="text/html; charset=utf-8" />';
            echo "跳转版本号输入有误!";
            return;
        }
        if ( ! $this->migration->version($version))
        {
            show_error($this->migration->error_string());
        }
        echo '<meta http-equiv="Content-type" content="text/html; charset=utf-8" />';
        echo "数据库版本转换完毕!";
        //$this->output->enable_profiler();
    }

    //发送测试邮件
    public function send_test_mail()
    {
        $this->cmail->newTestCmail("xiang.chen@airborne-es.com,xiangchen.cn@gmail.com","你好！这是测试邮件！");
        $this->output->enable_profiler();
    }


    
}

