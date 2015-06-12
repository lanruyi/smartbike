<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class App_controller extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('appuser','appin','bug','station', 'project', 'command', 'area','user','rom','user'));
        $this->load->helper(array('appxml','file'));
    }

    public function index(){
    }


    public function login(){
        $app_id  = $this->input->post("app_id");
        $user    = $this->input->post("user");
        $md5pass = $this->input->post("md5pass");
        if(!$app_id){
            echo '{"status":"no_app_id"}';
            return;
        }
        $appuser = $this->appuser->findOneBy(array("app_id"=>$app_id));
        if(!$appuser){
            $this->appuser->insert(array("app_id"=>$app_id));
        }
        $user    = $this->user->checkUser_md5($user,$md5pass);
        if($user){
            $appuser = $this->appuser->findOneBy(array("app_id"=>$app_id));
            $this->appuser->update($appuser['id'],array("user_id"=>$user['id']));
            echo '{"status":"success","user_id":'.$user['id'].',"name_chn":"'.$user['name_chn'].'"}';
        }else{
            echo '{"status":"login_fail"}';
        }
        //$this->load->view('blank');
        //$this->output->enable_profiler();
    } 

    private function checkAuth($app_id){
        $appuser = $this->appuser->findOneBy(array("app_id"=>$app_id,"user_id > "=>0));
        if(!$appuser){
            echo '{"status":"no_login"}';
            exit(0);
        }
        return $appuser['user_id'];
    }

    public function insert(){
        $app_id  = $this->input->post("app_id");
        $type    = $this->input->post("type");
        $content = $this->input->post("content");
        $user_id = $this->checkAuth($app_id);
        echo $this->appin->newAppin($type,$content,$user_id);
    }

    public function getHeads(){
        echo appxml_heads();
    }
    public function getBody($str){
        echo appxml_body($str);
    }

}
