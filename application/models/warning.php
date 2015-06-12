<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


define('ESC_WARNING_TYPE__MAINTAINANCE_BUTTON',17);
define('ESC_WARNING_TYPE__DISCONNECT',41);
define('ESC_WARNING_TYPE__ENERGY_WRONG',42);
define('ESC_WARNING_TYPE__INDOORTMP_HIGH',43);
define('ESC_WARNING_TYPE__BOXTMP_HIGH',44);
define('ESC_WARNING_TYPE__UTILITY_FAILURE',45);
define('ESC_WARNING_TYPE__SENSOR_INDOOR_BROKEN',46);
define('ESC_WARNING_TYPE__SENSOR_OUTDOOR_BROKEN',47);
define('ESC_WARNING_TYPE__SENSOR_BOX_BROKEN',48);
define('ESC_WARNING_TYPE__SENSOR_COLDS0_BROKEN',49);
define('ESC_WARNING_TYPE__SENSOR_COLDS1_BROKEN',50);
define('ESC_WARNING_TYPE__SENSOR_ENERGY_MAIN_BROKEN',51);
define('ESC_WARNING_TYPE__SENSOR_ENERGY_DC_BROKEN',52);
define('ESC_WARNING_TYPE__485_DIE',53);
define('ESC_WARNING_TYPE__ESG_TIME_INCORRECT',54);

define('ESC_WARNING_FINISH_TYPE__AUTO',1);
define('ESC_WARNING_FINISH_TYPE__MANUAL',2);
define('ESC_WARNING_FINISH_TYPE__ONCE',3);

define('ESC_WARNING_STATUS__OPEN',1);
define('ESC_WARNING_STATUS__CLOSED',2);

define('ESC_WARNING_PRIORITY__HIGH',2);
define('ESC_WARNING_PRIORITY__MIDDLE',3);
define('ESC_WARNING_PRIORITY__LOW',4);


class Warning extends ES_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->table_name = "warnings";
        $this->load->helper(array('warning'));
    }

	public function get_priority($warning_type){
        switch($warning_type){
        case ESC_WARNING_TYPE__BOXTMP_HIGH:
		case ESC_WARNING_TYPE__INDOORTMP_HIGH:
		case ESC_WARNING_TYPE__DISCONNECT:
		case ESC_WARNING_TYPE__ENERGY_WRONG:
		case ESC_WARNING_TYPE__SENSOR_INDOOR_BROKEN:
		case ESC_WARNING_TYPE__SENSOR_OUTDOOR_BROKEN:
        case ESC_WARNING_TYPE__ESG_TIME_INCORRECT:
            return ESC_WARNING_PRIORITY__HIGH;

		case ESC_WARNING_TYPE__UTILITY_FAILURE:
        case ESC_WARNING_TYPE__SENSOR_BOX_BROKEN:
		case ESC_WARNING_TYPE__SENSOR_COLDS0_BROKEN:
		case ESC_WARNING_TYPE__SENSOR_COLDS1_BROKEN:
		case ESC_WARNING_TYPE__SENSOR_ENERGY_MAIN_BROKEN:
		case ESC_WARNING_TYPE__SENSOR_ENERGY_DC_BROKEN:
		case ESC_WARNING_TYPE__485_DIE:
			return ESC_WARNING_PRIORITY__MIDDLE;		

        case ESC_WARNING_TYPE__MAINTAINANCE_BUTTON:
            return ESC_WARNING_PRIORITY__LOW;
        }
        return 0;
    } 


    public function get_finish_type($warning_type){
        switch($warning_type){
        case ESC_WARNING_TYPE__BOXTMP_HIGH:
		case ESC_WARNING_TYPE__INDOORTMP_HIGH:
		case ESC_WARNING_TYPE__DISCONNECT:
		case ESC_WARNING_TYPE__SENSOR_INDOOR_BROKEN:
		case ESC_WARNING_TYPE__SENSOR_OUTDOOR_BROKEN:
        case ESC_WARNING_TYPE__SENSOR_BOX_BROKEN:
		case ESC_WARNING_TYPE__SENSOR_COLDS0_BROKEN:
		case ESC_WARNING_TYPE__SENSOR_COLDS1_BROKEN:
		case ESC_WARNING_TYPE__SENSOR_ENERGY_MAIN_BROKEN:
		case ESC_WARNING_TYPE__SENSOR_ENERGY_DC_BROKEN:
        case ESC_WARNING_TYPE__ESG_TIME_INCORRECT:
		case ESC_WARNING_TYPE__UTILITY_FAILURE:
            return ESC_WARNING_FINISH_TYPE__AUTO;
			return ESC_WARNING_FINISH_TYPE__MANUAL;	
        case ESC_WARNING_TYPE__ENERGY_WRONG:
		case ESC_WARNING_TYPE__MAINTAINANCE_BUTTON:
		case ESC_WARNING_TYPE__485_DIE:
            return ESC_WARNING_FINISH_TYPE__ONCE;
        }
        return 0;
    }


    public function CloseWarning($station_id,$type){
        $this->db->query("update warnings 
            set end_time=NOW(),status=? where station_id=? and status=? and type=?",
            array(ESC_WARNING_STATUS__CLOSED,$station_id,ESC_WARNING_STATUS__OPEN,$type));
    }

    public function CloseWarnings($station_ids,$type){
        if($station_ids){
            $this->db->query("update warnings 
                set end_time=NOW(),status=? 
                where station_id in (".implode(',',$station_ids).") and status=? and type=?",
                array(ESC_WARNING_STATUS__CLOSED,ESC_WARNING_STATUS__OPEN,$type));
        }
    }

    public function ClearOtherWarnings($station_id){ 
        $this->db->query("update warnings 
            set end_time=NOW(),status=? 
            where station_id=? and status=? and type<>?",
            array(ESC_WARNING_STATUS__CLOSED,$station_id,ESC_WARNING_STATUS__OPEN,ESC_WARNING_TYPE__DISCONNECT));
    }

    public function newOpenWarning($station_id,$type,$relative_time = 0){
           $res = null;
           if($type != ESC_WARNING_TYPE__DISCONNECT){
               $query = $this->db->query("select id,finish_type from warnings 
                   where station_id=? and status=? and type=?",
                   array($station_id,ESC_WARNING_STATUS__OPEN,$type));
               $res = $query->result_array();
           }
           if(!$res){
               $query = $this->db->query("insert into warnings 
                   (`station_id`,`type`,`start_time`,`finish_type`,`status`,`priority`) 
                   values (?,?,NOW(),?,?,".$this->get_priority($type).")",
                       array($station_id,$type,$this->get_finish_type($type),
                       ESC_WARNING_STATUS__OPEN));
           }else{
               //if($res[0]['finish_type'] == ESC_WARNING_FINISH_TYPE__ONCE)
               //$query = $this->db->query("update warnings set update_time=NOW() 
               //   where id=?",array($res[0]['id']));
           }
    }


}





