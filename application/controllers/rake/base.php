<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Base_controller extends CI_Controller{

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('command','project','esg','warning','station','data'));
    }

    //确认没有时间异常的数据
    public function check_data_time(){
        $query = $this->db->query("select count(id) nums from datas 
            where create_time<20120501000000"); 
        $result = $query->row_array();
        echo "== [".$result['nums']."] ==";
        if($result['nums']){
            $query = $this->db->query("delete  from datas 
                where create_time<20120501000000"); 
        }
    }

    //修复基站创建时间
    public function check_station_create_time(){
        $query = $this->db->query("select id from stations where recycle=".ESC_NORMAL." and create_time<'2013-02-01 00:00:00'");
        $stations = $query->result_array();
        echo count($stations).'个基站重建创建日<br><br>';
        $count = 0;
        foreach ($stations as $station) {
            $query = $this->db->query("select create_time from datas where station_id=".$station['id']." order by create_time limit 1");
            $result = $query->row_array();
            if($result){
                $this->db->query("update stations set create_time='".$result['create_time']."' where id=".$station['id']);
                $count++;
            }
        }
        echo '<br>'.$count.'个基站<创建日>补齐!<br>';
        echo '<br>done!<br>';
    }

    public function check_ns(){
        $query = $this->db->query("update stations set station_type=".ESC_STATION_TYPE_NPLUSONE.",ns=6,ns_start=20120401 where station_type = ".ESC_STATION_TYPE_SIXPULSONE);
        $query = $this->db->query("update stations set ns=6,ns_start=20120401 where station_type = ".ESC_STATION_TYPE_NPLUSONE);
        $query = $this->db->query("update stations set ns=0,ns_start=20120401 where station_type <> ".ESC_STATION_TYPE_NPLUSONE);
    }

    public function remove_zero(){
        $this->db->query("delete from temperatures where num = 0");
        echo "Success!";
    }

    public function init_esg(){
        $query = $this->db->query("SELECT * FROM `stations`");
        $now = new DateTime;
        foreach ($query->result() as $row)
        {
            $string = $row->name_py? $row->name_py : "";
            $this->db->query("insert into esgs 
                (`id`,`string`,`esg_key`,`create_time`) values".
                " ('".$row->id."','".$string."','".$row->new_station_key.
                "','".$now->format('YmdHis')."')");
        }
    }

    public function add_city(){
        $this->db->query("insert into areas (id,name_chn,name_py,weather_code,type) values (40,'无锡','wuxi','101190201','0')");
        $this->db->query("insert into areas (id,name_chn,name_py,weather_code,type) values (41,'盐城','yancheng','101190705','0')");
        $this->db->query("insert into areas (id,name_chn,name_py,weather_code,type) values (42,'南通','nantong','101190501','0')");
        echo "Success!";
    }

    //将已删除基站的残留命令删除
    public function verify_command_station(){
        $commands = $this->command->findBy_sql(array());
        foreach ($commands as $command){
            $station_id = $command['station_id'];
            $station = $this->station->findOneBy_sql(
                array('id'=>$station_id,'recycle'=>ESC_NORMAL));
            if(!$station){
                echo $station_id."<br>";
                $this->command->del_sql($command['id']);
            }
        }
    }

    public function moving_main_power_80000(){
        $res = $this->db->query("update datas set 
            power_main = null where power_main=80000");
        var_dump($res);
        echo '<br>done!<br>';
    }


}




