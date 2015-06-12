<?

$d = array(
    '1' => array("id" => 1, "station_id" => 1, "type" => ESC_BUG__MAINTAINANCE_BUTTON, "status" => 1, "update_time" => "2012-11-29 20:20:02", "project_id" => 4, "city_id" => 40, "user_id" => NULL),
    //站点1 已经有了三个故障
    '3' => array("id" => 3, "station_id" => 1, "type" => ESC_BUG__SENSOR_INDOOR_BROKEN, "status" => 1, "start_time" => "2012-11-29 20:20:02", "project_id" => 4, "city_id" => 40, "user_id" => NULL),
    '4' => array("id" => 4, "station_id" => 1, "type" => ESC_BUG__SENSOR_BOX_BROKEN, "status" => 1, "start_time" => "2012-11-29 20:20:02", "project_id" => 4, "city_id" => 40, "user_id" => NULL),
    //站点4 
    '5' => array("id" => 6, "station_id" => 4, "type" => ESC_BUG__SENSOR_COLDS0_BROKEN, "status" => 1, "start_time" => "2012-11-29 20:20:02", "project_id" => 4, "city_id" => 40, "user_id" => NULL),
    '6' => array("id" => 7, "station_id" => 4, "type" => ESC_BUG__SMART_METER_BROKEN, "status" => 1, "start_time" => "2012-11-29 20:20:02", "project_id" => 4, "city_id" => 40, "user_id" => NULL),
    //站点3 
    '7' => array("id" => 5, "station_id" => 3, "type" => ESC_BUG__NO_POWER, "status" => 1, "start_time" => "2012-11-29 20:20:02", "project_id" => 4, "city_id" => 40, "user_id" => NULL),
    '8' => array("id" => 8, "station_id" => 3, "type" => ESC_BUG__SENSOR_COLDS1_BROKEN, "status" => 1, "start_time" => "2012-11-29 20:20:02", "project_id" => 4, "city_id" => 40, "user_id" => NULL),
    '9' => array("id" => 9, "station_id" => 3, "type" => ESC_BUG__INDOOR_TMP_HIGH, "status" => 1, "start_time" => "2012-11-29 20:20:02", "project_id" => 4, "city_id" => 40, "user_id" => NULL),
    '10' => array("id" => 10, "station_id" => 3, "type" => ESC_BUG__SENSOR_OUTDOOR_BROKEN, "status" => 1, "start_time" => "2012-11-29 20:20:02", "project_id" => 4, "city_id" => 40, "user_id" => NULL),
    //站点2  没有故障
    //站点8 485故障
     '11' => array("id" => 11, "station_id" => 8, "type" => ESC_BUG__485_DIE, "status" => 1, "start_time" => "2012-11-29 20:20:02", "project_id" => 4, "city_id" => 40, "user_id" => NULL),
    
    //站点9 断开连接
     '12' => array("id" => 12, "station_id" => 9, "type" => ESC_BUG__DISCONNECT, "status" => 1, "start_time" => "2012-11-29 20:20:02", "project_id" => 4, "city_id" => 40, "user_id" => NULL),
    
    //下面用于测试基准日或基准站异常
     '13' => array("id" => 13, "station_id" => 14, "type" => ESC_BUG__NO_COLDS_ON, "status" => 1, "start_time" => "2012-11-29 20:20:02", "project_id" => 4, "city_id" => 40, "user_id" => NULL),

    //下面两条用于测试
     '14' => array("id" => 14, "station_id" => 8, "type" => ESC_BUG__SAVING_ABNORMAL, "status" => 1, "start_time" => "2012-11-29 20:20:02", "project_id" => 4, "city_id" => 40, "user_id" => NULL),
     '15' => array("id" => 15, "station_id" => 3, "type" => ESC_BUG__SAVING_ABNORMAL, "status" => 1, "start_time" => "2012-11-29 20:20:02", "project_id" => 4, "city_id" => 40, "user_id" => NULL)
);

