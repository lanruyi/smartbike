<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Xiang_try_controller extends CI_Controller{

    function __construct()
    {
        parent::__construct();
    }


    public function index(){
        $h1 = array(
            "2"=>"k",
            "3"=>"l",
            "4"=>"t",
            "5"=>"s");
        $h2 = array(
            "3"=>"m",
            "4"=>"n",
            "5"=>"s",
            "6"=>"o");

        //1 hash 合并 没有重复的key
        hp($h1+$h2);
        //2 hash diff
        hp(array_diff_key($h1,$h2));
        //2 hash intersect
        hp(array_intersect_key($h1,$h2));

        
        hp(array_keys($h2));
        //echo $_SERVER['HTTP_HOST'];
    }

    //public function index(){
        //@$rs = mysql_list_tables("esdata");
        //while ($row = mysql_fetch_row($rs)) {
            //$table_name = $row[0];
            //echo $table_name.":<br>";
            //$query = $this->db->query("describe ".$table_name);
            //foreach($query->result_array() as $v){
                //echo $v['Field']." ";
            //}
            //echo "<br>";
            //echo "<br>";
        //}
        //mysql_free_result($rs);
    //}
    
    public function city_id_table(){
        @$rs = mysql_list_tables("esdata");
        while ($row = mysql_fetch_row($rs)) {
            $table_name = $row[0];
            $query = $this->db->query("describe ".$table_name);
            foreach($query->result_array() as $v){
                if("city_id" == $v['Field']){
                    echo "update ".$table_name." set city_id=67 where city_id=50;<br>";
                }
            }
        }
        mysql_free_result($rs);
    }
}
