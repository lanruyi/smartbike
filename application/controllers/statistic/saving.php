<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Saving_controller extends Statistic_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('mid/mid_station','area','contract','station','project','monthdata','daydata'));
        $this->load->helper(array('chart'));
    }


    public function index(){
        redirect("/statistic/saving/months","local");
    }
    //public function index(){
        //$this->dt['title'] = '站点统计';

        //$datetime = $this->input->get("datetime")?$this->input->get("datetime"):"-1 month";
        //$datetime = h_dt_start_time_of_month($datetime);
        //$project_id = $this->input->get("project_id")?$this->input->get("project_id"):4;


        //$this->db->order_by("convert(`name_chn` USING gbk) COLLATE gbk_chinese_ci asc");
        //$this->dt['projects']   = $this->project->findProductProjects();
        //$this->dt['datetime']   = $datetime;
        //$this->dt['project_id'] = $project_id;

        //$this->dt["info"]=$this->monthSavingInfo($datetime,$project_id);

        //$this->load->view('templates/statistic_header',$this->dt);
        //$this->load->view('statistic/menu');
        //$this->load->view('statistic/saving/menu');
        //$this->load->view('statistic/saving/index');
        //$this->load->view('templates/statistic_footer'); 
    //}

    public function months(){
        $this->dt['title'] = '站点统计';

        $start_month = $this->input->get("start_month")?$this->input->get("start_month"):"-1 month";
        $start_month = h_dt_start_time_of_month($start_month);
        $stop_month = $this->input->get("stop_month")?$this->input->get("stop_month"):"-1 month";
        $stop_month = h_dt_stop_time_of_month($stop_month);

        $project_id = $this->input->get("project_id")?$this->input->get("project_id"):4;

        if(h_dt_diff($start_month,$stop_month)>0){
            show_error("开始时间不能小于结束时间");
        }

        $this->dt['projects']   = $this->project->findProductProjects();
        $this->dt['start_month']   = $start_month;
        $this->dt['stop_month']   = $stop_month;
        $this->dt['project_id'] = $project_id;

        $month_data = array();
        $total_info = array();
        foreach(h_station_total_load_array() as $total_load => $name){
            $total_info[$total_load]['num']              = 0;
            $total_info[$total_load]['saving']           = 0;
            $total_info[$total_load]['average_std_main'] = 0;
        }
        for($month = $start_month;h_dt_diff($month,$stop_month)<=0;$month = h_dt_add_month($month)){
            $month_info = $this->monthSavingInfo($month,$project_id);
            $month_data[$month] = $month_info;
            foreach(h_station_total_load_array() as $total_load => $name){
                if($month_info[$total_load]['saving'] && $month_info[$total_load]['average_std_main']){
                    $total_info[$total_load]['saving']           += $month_info[$total_load]['saving'];
                    $total_info[$total_load]['average_std_main'] += $month_info[$total_load]['average_std_main'];
                    $total_info[$total_load]['num'] ++;
                }
            }
        }
        $this->dt['total_info'] = $total_info;
        $this->dt['month_data'] = $month_data;

        $this->load->view('templates/statistic_header',$this->dt);
        $this->load->view('statistic/menu');
        $this->load->view('statistic/saving/menu');
        $this->load->view('statistic/saving/months');
        $this->load->view('templates/statistic_footer'); 
    }



    public function monthSavingInfo($datetime,$project_id){
        $info = array();
        foreach(h_station_total_load_array() as $total_load => $name){
            if($project_id){ $this->db->where(array("project_id"=>$project_id)); }
            $stations = $this->station->findBy(array("recycle"=>ESC_NORMAL,
                "status !="=>ESC_STATION_STATUS_REMOVE,
                "station_type !="=>ESC_STATION_TYPE_STANDARD,
                "station_type !="=>ESC_STATION_TYPE_NPLUSONE,
                "total_load"=>$total_load));
            if($project_id){ $this->db->where(array("project_id"=>$project_id)); }
            $std_stations = $this->station->findBy(array("recycle"=>ESC_NORMAL,
                "status !="=>ESC_STATION_STATUS_REMOVE,
                "station_type ="=>ESC_STATION_TYPE_STANDARD,
                "total_load"=>$total_load));
            $item['num'] = count($stations);
            $item['std_num'] = count($std_stations);
            $station_ids = h_array_to_id_array($stations);
            $std_station_ids = h_array_to_id_array($std_stations);
            $item['normal_std_num'] = 0;
            $item['normal_num'] = 0;
            $item['total_main'] = 0;
            $item['total_std_main'] = 0;
            $item['average_main'] = 0;
            $item['average_std_main'] = 0;
            if($std_station_ids){
                $this->db->where("station_id in (".implode(",",$std_station_ids).")");
                //过滤正常的月能耗 
                $this->db->where("(main_energy > ".($total_load*10*60*24*30/1000/2)." or true_energy>0)");
                $monthdatas = $this->monthdata->findBy(array("datetime"=>$datetime));
                $item['normal_std_num'] = count($monthdatas);
                $total_energy = 0; 
                foreach($monthdatas as $monthdata){
                    $main_energy = ($monthdata['true_energy']?$monthdata['true_energy']:$monthdata['main_energy']);
                    $total_energy += $main_energy;
                }
                $item['total_std_main'] = $total_energy;
                $item['average_std_main'] = $item['normal_std_num']?$total_energy/$item['normal_std_num']:0;
            }
            if($station_ids){
                $this->db->where("station_id in (".implode(",",$station_ids).")");
                //过滤正常的月能耗 
                $this->db->where("(main_energy > ".($total_load*10*60*24*30/1000/3)." or true_energy>0)");
                $monthdatas = $this->monthdata->findBy(array("datetime"=>$datetime));
                $item['normal_num'] = count($monthdatas);
                $total_energy = 0; 
                foreach($monthdatas as $monthdata){
                    $main_energy = ($monthdata['true_energy']?$monthdata['true_energy']:$monthdata['main_energy']);
                    $total_energy += $main_energy;
                }
                $item['total_main'] = $total_energy; 
                $item['average_main'] = $item['normal_num']?$total_energy/$item['normal_num']:0;
            }
            $item['saving'] = $item['average_std_main'] - $item['average_main'];
            $item['saving'] = $item['saving']>0?$item['saving']:0;
            $info[$total_load] = $item;
        }
        return $info;

    }


} 
