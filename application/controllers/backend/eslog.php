<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Eslog_controller extends CI_Controller{

    function __construct()
    {
        parent::__construct();
        $this->load->helper(array());
        $this->load->model(array('eslog'));
    }


    public function index(){
        $data['title'] = "eslog";
        $eslogs = $this->eslog->findBy_sql(array('type'=>ESC_ESLOG__GPRSTEST),array('create_time DESC'), 100);
        $data['eslogs'] = $eslogs;
        echo "<script language='JavaScript'> function myrefresh(){ window.location.reload(); } setTimeout('myrefresh()',6000);</script>";
        foreach ($eslogs as $eslog){
            echo $eslog['create_time']." ".$eslog['log']." <br>";
        }
    }


}
?>


