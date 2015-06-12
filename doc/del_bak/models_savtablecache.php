<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Savtablecache extends ES_Model {

    public function __construct() {
        $this->table_name = "savtablecaches";
    }

    public function paramFormat($_params) {
        $_params['datetime']       = isset($_params['datetime'])       ? $_params['datetime']      : "2008-01-01";
        $_params['project_id']     = isset($_params['project_id'])     ? $_params['project_id']    : 0;
        $_params['city_id']        = isset($_params['city_id'])        ? $_params['city_id']       : 0;

        $_params['has_zhuan_saving']  = isset($_params['has_zhuan_saving'])  ? $_params['has_zhuan_saving']  : 0;
        $_params['has_ban_saving']    = isset($_params['has_ban_saving'])    ? $_params['has_ban_saving']    : 0;
        $_params['has_zhuan_common']  = isset($_params['has_zhuan_common'])  ? $_params['has_zhuan_common']  : 0;
        $_params['has_ban_common']    = isset($_params['has_ban_common'])    ? $_params['has_ban_common']    : 0;
        $_params['has_final']         = isset($_params['has_final'])         ? $_params['has_final']         : 0;

        $_params['zhuan_saving']   = isset($_params['zhuan_saving'])   ? $_params['zhuan_saving']  : "";
        $_params['ban_saving']     = isset($_params['ban_saving'])     ? $_params['ban_saving']    : "";
        $_params['zhuan_common']   = isset($_params['zhuan_common'])   ? $_params['zhuan_common']  : "";
        $_params['ban_common']     = isset($_params['ban_common'])     ? $_params['ban_common']    : "";
        $_params['final']          = isset($_params['final'])          ? $_params['final']         : "";
        return $_params;
    }



    function setSavingTable($project_id,$city_id,$building,$datetime,$json_hash){
        $table_name = array(ESC_BUILDING_BAN => "ban_saving",ESC_BUILDING_ZHUAN => "zhuan_saving");
        $flag_name  = array(ESC_BUILDING_BAN => "has_ban_saving",ESC_BUILDING_ZHUAN => "has_zhuan_saving");
        $json_str = json_encode($json_hash);
        if($json_str){
            $this->db->select('id');
            $stcache = $this->findOneBy_sql(array("project_id"=>$project_id,"city_id"=>$city_id,"datetime"=>$datetime));
            $this->update_sql($stcache['id'],array($table_name[$building] => $json_str,$flag_name[$building] => 1));
        }
    }
    
    function setCommonTable($project_id,$city_id,$building,$datetime,$json_hash){
        $json_str = json_encode($json_hash);
        if($json_str){
            $this->db->select('id');
            $stcache = $this->findOneBy_sql(array("project_id"=>$project_id,"city_id"=>$city_id,"datetime"=>$datetime));
            $this->update_sql($stcache['id'],array(
                h_building_stcache_common($building) => $json_str,
                "has_".h_building_stcache_common($building) => 1));
        }
    }
    


}

