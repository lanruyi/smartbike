<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define('ESC_ALL',0);

//recycle 正常/被删除
define('ESC_NORMAL',1);
define('ESC_DEL',2);

//alive 在线/不在线
define('ESC_ONLINE',1);
define('ESC_OFFLINE',2);

//being 有/没有
define('ESC_BEING',1);
define('ESC_BEINGLESS',2);
//time_type
define('ESC_DAY', 1);
define('ESC_MONTH', 2);


class ES_Model extends CI_Model {

    public $table_name;
    public $entities_str;
    private $num_rows;

    function __construct()
    {
        parent::__construct();
    }

    public function getArchiveWs($url,$post=array()){
        return $this->curl->simple_get($url);
    }

    //本类里面带DB没事 子类里面 特别是controller用的 不要带db
    public function start_cache(){
        $this->db->start_cache();
    }
    public function limit($l){
        $this->db->limit($l);
    }
    public function join($table, $cond, $type = ''){
        $this->db->join($table, $cond, $type);
    }
    public function select($s){
        $this->db->select($s);
    }
    public function where($w){
        $this->db->where($w);
    }
    public function group_by($g){
        $this->db->group_by($g);
    }
    public function order_by($o){
        $this->db->order_by($o);
    }
    public function count_all_results() {
        return $this->db->count_all_results($this->table_name);
    }
    // 有测试
    public function find_sql($id,$force = true){
        return $this->find($id,$force);
    } 
    // 有测试
    public function findBy_sql($params,$order_array=array(),$limit=null,$offset=null){
        return $this->findBy($params,$order_array,$limit,$offset);
    }
    // 查询一条数据 
    public function findOneBy_sql($params,$order_array=array()){
        return $this->findOneBy($params,$order_array);
    }
    //新建一条数据
    public function new_sql($params){
        return $this->insert($params);
    }
    //修改一条数据
    public function update_sql($id,$params){
        return $this->update($id,$params);
    }
    public function find($id,$force = true){
        if (!$id) return null;
        if ($force) {
            $this->db->where("id = ".((int)$id));
            $query = $this->db->get($this->table_name);
            $res = $query->row_array();
            $result = $res?$res:null;
        }else{
            $mem_key = "find_sql_" . $this->table_name . '_' . $id;
            $cache_time = 1;
            $result = $this->cache->get($mem_key);
            if (!$result) {
                $this->db->where("id = ".((int)$id));
                $query = $this->db->get($this->table_name);
                $res = $query->row_array();
                $result = $res?$res:null;
                $this->cache->save($mem_key,$result,$cache_time);
            }
        }
        return $result;
    }


    public function findBy($params=array(),$order_array=array(),$limit=null,$offset=null){
        $this->db->where($params);
        if($order_array){
            $this->db->order_by(implode(',',$order_array));
        }
        $query = $this->db->get($this->table_name,$limit,$offset);
        return $query->result_array();
    }


    public function findOneBy($params=array(),$order_array=array()){
        $this->db->limit(1);
        $res = $this->findBy($params,$order_array);
        if($res){
            return $res[0];
        }else{
            return null;
        }
    }


    //修改一条数据
    public function updateBy($params,$where = array()){
        if($params){
            $this->db->where($where);
            $this->db->update($this->table_name,$params);
        }
    }
    public function update($id,$params){
        if($params){
            $this->db->where('id',$id);
            $this->db->update($this->table_name,$params);
        }
        return $id;
    }
    //新建一个数据表项
    public function insert($_params){
        if($_params){
            $_params = $this->paramFormat($_params);
            $this->db->insert($this->table_name,$_params);
            return $this->db->insert_id();
        }else{
            return null;
        }
    }
    public function paramFormat($_params){
        return $_params;     
    }
    public function insert_array($params_array){
        if(!$params_array){
            return;
        }
        $_insert_array = array(); 
        foreach($params_array as $params){
           array_push($_insert_array,$this->paramFormat($params));  
        }
        $this->db->insert_batch($this->table_name,$_insert_array);
    }
    public function del($id){
        if(!$id){ return null; }
        $sql = "delete from ".$this->table_name." where id=".$id;
        $this->db->query($sql);
    }
    public function del_sql($id){
        if(!$id){ return null; }
        $sql = "delete from ".$this->table_name." where id=".$id;
        $this->db->query($sql);
    }
    public function delBy($param){
        $this->db->where($param);
        $this->db->delete($this->table_name);
    }




    function pagination_stop_cache($per_page,$cur_page){
        $this->db->stop_cache();
        $num =  $this->count_all_results();
        $this->db->limit($per_page,$per_page*($cur_page-1));
        $res =  $this->findBy();
        $this->db->flush_cache();
        return array("num" => $num,"res"=>$res);
    }
    
    //function pagination_num($params){
        //$this->db->where($params);
        //return $this->db->count_all_results($this->table_name);
    //}
    
    //function pagination($params,$orders,$per_page,$cur_page){
        //$this->db->where($params);
        //if($orders){
            //$this->db->order_by(implode(",",$orders));
        //}
        //$this->db->limit($per_page,$per_page*($cur_page-1));
        //$query = $this->db->get($this->table_name);
        //return $query->result_array();
    //}








    //////// 这边往下的函数需要重构 ///////////////////////////////////////////////////////////////////////////////

    public function get_where($args, $limit=null, $offset=null){
        $query = $this->db->get_where($this->table_name, $args, $limit, $offset);
        return $query->result_array();
    }

    public function count_group($params,$group){
        $this->db->where($params);
        $this->db->select("*,count(*) count_num");
        $this->db->group_by($group);
        $query = $this->db->get($this->table_name);
        return $query->result_array();
    }

    public function count($params){
        $this->db->where($params);
        return $this->db->count_all_results($this->table_name);
    }

    public function count_all() {
        return $this->db->count_all($this->table_name);
    }


    public function set_args_by_id($id,$args) {
        $this->db->where('id', $id);
        $this->db->update($this->table_name, $args);
    }


    public function del_by_id($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->table_name); 
    }



    function pagination_sql_station($conditions,$orders,$select,$per_page,$cur_page, $ext_select= "",$ext_con = ""){
        $condition_array = array();
        $order_array = array();
        $select_array = array();
        foreach($conditions as $k=>$v){
            if($v){
                array_push($condition_array,"s.".$k.$v);
            }
        }
        if($ext_con){
            array_push($condition_array,$ext_con);
        }
        foreach($orders as $k=>$v){
            array_push($order_array,"s.".$k." ".$v);
        }
        foreach($select as $k=>$v){
            array_push($select_array,"s.".$v);
        }
        if($ext_select){
            array_push($select_array,$ext_select);
        }

        $str = "";
        if(count($condition_array)){
            $str .= "where ".implode(" and ",$condition_array);
        }
        if(count($order_array)){
            $str .= " order by ".implode(",",$order_array);
        }

        $sql_num = "SELECT count(*) as num FROM ".$this->table_name." s left join stations on stations.id = s.station_id ".$str;
        $sql = "SELECT ".implode(',',$select_array).",stations.name_chn as sta_name_chn FROM ".$this->table_name." s left join stations on stations.id = s.station_id "
            .$str." limit ".($per_page*($cur_page-1)).",".$per_page;
        $query = $this->db->query($sql_num);
        $res_num = $query->result_array();
        $query = $this->db->query($sql);
        $res = $query->result_array();
        return array("num"=>$res_num[0]['num'],"res"=>$res);
    }




    

    //////// 分页函数 //////////////////////////////////////////////////////////////////////////////
    //  
    //  $guess_num  如果想要提高分页效率，可提供此估计元素总数，则此处不会计算元素总数
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////
    function pagination_sql($conditions,$orders,$per_page,$cur_page,$guess_num = null){
        $condition_array = array();
        $order_array = array();
        $where_str = "";
        $order_str = "";
        foreach($conditions as $k=>$v){
            if($v){
                array_push($condition_array,"s.".$k.$v);
            }
        }
        foreach($orders as $k=>$v){
            array_push($order_array,"s.".$k." ".$v);
        }
        if(count($condition_array)){
            $where_str .= "where ".implode(" and ",$condition_array);
        }
        if(count($order_array)){
            $order_str .= " order by ".implode(",",$order_array);
        }
        if(!$guess_num){
            $query = $this->db->query("SELECT count(*) as num FROM ".$this->table_name." s ".$where_str);
            $res_num = $query->result_array();
            $guess_num = $res_num[0]['num'];
        }
        $query = $this->db->query("SELECT * FROM ".$this->table_name." s "
            .$where_str." ".$order_str." limit ".($per_page*($cur_page-1)).",".$per_page);
        return array("num"=>$guess_num,"res"=>$query->result_array());
    }


    
    //todo: 用ci写法重构
    function pagination_sql_stations($conditions,$orders,$cur_page,$per_page,$station_params,$ext_con = ""){
        //假设$station_params如下
        //$station_params = array(
        //  "s.name_chn" => "s_name_chn",
        //  "s.total_load" => "",
        //  "s.city_id" => ""
        //)
        //则所拼字符串为  "t.*,s.name_chn s_name_chn,s.tatal_load , s.city_id"
        $select_str = "t.*";
        $select_array = array();
        foreach($station_params as $k=>$v){
            //todo 如果$k不带s.应该报错
            array_push($select_array, $k." ".$v);
        }
        if(count($select_array)){
            $select_str.= ",".implode(" ,",$select_array);
        }

        //拼where 和 order 字符串
        $where_order = "";
        $condition_array = array();
        $order_array = array();
        foreach($conditions as $k=>$v){
            if($v){
                array_push($condition_array,$k.$v);
            }
        }
        if($ext_con){
            array_push($condition_array, $ext_con);
        }
        foreach($orders as $k=>$v){
            array_push($order_array, $k." ".$v);
        }
        if(count($condition_array)){
            $where_order .= "where ".implode(" and ",$condition_array);
        }

        //查询（总数以及某一页的数据）
        $sql_num = "SELECT count(*) as num FROM ".$this->table_name." t left join stations s on t.station_id = s.id ".$where_order;

        if(count($order_array)){
            $where_order .= " order by ".implode(",",$order_array);
        }

        $sql = "SELECT  ".$select_str."  FROM ".$this->table_name." t left join stations s on t.station_id = s.id "
            .$where_order." limit ".($per_page*($cur_page-1)).",".$per_page;
        $query = $this->db->query($sql_num);
        $res_num = $query->row_array();
        $query = $this->db->query($sql);
        $res = $query->result_array();
        return array("num"=>$res_num['num'],"res"=>$res);
    }

    public function findAll_sql(){
        $query = $this->db->query("select * from ".$this->table_name);
        return $query->result_array();
    }

    public function findBy_some($selects,$params,$order_array=array(),$limit=null,$offset=null){
        $this->db->where($params);
        if($order_array){
            $this->db->order_by(implode(',',$order_array));
        }
        $query = $this->db->get($this->table_name,$limit,$offset);
        $res = $query->result_array();
        return $res;
    }

}










