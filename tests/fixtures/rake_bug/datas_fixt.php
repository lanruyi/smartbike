<?

$time = strtotime("now");
$d = array(
    //1站  检测室内温感bug ,恒温柜bug是否正常关闭 
    ' 1' => array("id" => 1, "station_id" => 1, "create_time" => date("YmdHis", $time - 60 * 1), 
        "indoor_tmp" => "16", "indoor_hum" => "16", "box_tmp" => "16.0"),
    ' 2' => array("id" => 2, "station_id" => 1, "create_time" => date("YmdHis", $time - 60 * 2), 
        "indoor_tmp" => "16", "indoor_hum" => "16", "box_tmp" => "16.0"),
    ' 3' => array("id" => 3, "station_id" => 1, "create_time" => date("YmdHis", $time - 60 * 3), 
        "indoor_tmp" => "16", "indoor_hum" => "16", "box_tmp" => "16.0"),
    ' 4' => array("id" => 4, "station_id" => 1, "create_time" => date("YmdHis", $time - 60 * 4), 
        "indoor_tmp" => "16", "indoor_hum" => "16", "box_tmp" => "16.0"),
    ' 5' => array("id" => 5, "station_id" => 1, "create_time" => date("YmdHis", $time - 60 * 5), 
        "indoor_tmp" => "16", "indoor_hum" => "16", "box_tmp" => "16.0"),
    ' 6' => array("id" => 6, "station_id" => 1, "create_time" => date("YmdHis", $time - 60 * 6), 
        "indoor_tmp" => "16", "indoor_hum" => "16", "box_tmp" => "16.0"),
    ' 7' => array("id" => 7, "station_id" => 1, "create_time" => date("YmdHis", $time - 60 * 7), 
        "indoor_tmp" => "16", "indoor_hum" => "16", "box_tmp" => "16.0"),
    ' 8' => array("id" => 8, "station_id" => 1, "create_time" => date("YmdHis", $time - 60 * 8), 
        "indoor_tmp" => "16", "indoor_hum" => "16", "box_tmp" => "16.0"),
    ' 9' => array("id" => 9, "station_id" => 1, "create_time" => date("YmdHis", $time - 60 * 9), 
        "indoor_tmp" => "16", "indoor_hum" => "16", "box_tmp" => "16.0"),
    '10' => array("id" =>10, "station_id" => 1, "create_time" => date("YmdHis", $time - 60 * 10), 
        "indoor_tmp" => "16", "indoor_hum" => "16", "box_tmp" => "16.0"),
 
    //2站   485故障是否正常开启
    '21' => array("id" => 21, "station_id" => 2, "create_time" => date("YmdHis", $time - 60 * 1), "box_tmp" => "16.4"),
    '22' => array("id" => 22, "station_id" => 2, "create_time" => date("YmdHis", $time - 60 * 2), "box_tmp" => "16.4"),
    '23' => array("id" => 23, "station_id" => 2, "create_time" => date("YmdHis", $time - 60 * 3), "box_tmp" => "16.4"),
    '24' => array("id" => 24, "station_id" => 2, "create_time" => date("YmdHis", $time - 60 * 4), "box_tmp" => "16.4"),
    '25' => array("id" => 25, "station_id" => 2, "create_time" => date("YmdHis", $time - 60 * 5), "box_tmp" => "16.4"),
    '26' => array("id" => 26, "station_id" => 2, "create_time" => date("YmdHis", $time - 60 * 6), "box_tmp" => "16.4"),
    '27' => array("id" => 27, "station_id" => 2, "create_time" => date("YmdHis", $time - 60 * 7), "box_tmp" => "16.4"),
    '28' => array("id" => 28, "station_id" => 2, "create_time" => date("YmdHis", $time - 60 * 8), "box_tmp" => "16.4"),
    '29' => array("id" => 29, "station_id" => 2, "create_time" => date("YmdHis", $time - 60 * 9), "box_tmp" => "16.4"),
    '30' => array("id" => 30, "station_id" => 2, "create_time" => date("YmdHis", $time - 60 * 10), "box_tmp" => "16.4"),
    
    //3站  检测室内高温bug 空调2故障 室外温感bug 停电bug 是否可以正常关闭
    '41' => array("id" => 41, "station_id" => 3, "create_time" => date("YmdHis", $time - 60 * 1), "indoor_tmp" => "26", 
        "colds_1_tmp" => "23", "outdoor_tmp" => "30", "outdoor_hum" => "30", "power_main" => "3355" ),
    '42' => array("id" => 42, "station_id" => 3, "create_time" => date("YmdHis", $time - 60 * 2), "indoor_tmp" => "26", 
        "colds_1_tmp" => "23", "outdoor_tmp" => "30", "outdoor_hum" => "30", "power_main" => "3355" ),
    '43' => array("id" => 43, "station_id" => 3, "create_time" => date("YmdHis", $time - 60 * 3), "indoor_tmp" => "26", 
        "colds_1_tmp" => "23", "outdoor_tmp" => "30", "outdoor_hum" => "30", "power_main" => "3355" ),
    '44' => array("id" => 44, "station_id" => 3, "create_time" => date("YmdHis", $time - 60 * 4), "indoor_tmp" => "26", 
        "colds_1_tmp" => "23", "outdoor_tmp" => "30", "outdoor_hum" => "30", "power_main" => "3355" ),
    '45' => array("id" => 45, "station_id" => 3, "create_time" => date("YmdHis", $time - 60 * 5), "indoor_tmp" => "26", 
        "colds_1_tmp" => "23", "outdoor_tmp" => "30", "outdoor_hum" => "30", "power_main" => "3355" ),
    '46' => array("id" => 46, "station_id" => 3, "create_time" => date("YmdHis", $time - 60 * 6), "indoor_tmp" => "26", 
        "colds_1_tmp" => "23", "outdoor_tmp" => "30", "outdoor_hum" => "30", "power_main" => "3355" ),
    '47' => array("id" => 47, "station_id" => 3, "create_time" => date("YmdHis", $time - 60 * 7), "indoor_tmp" => "26", 
        "colds_1_tmp" => "23", "outdoor_tmp" => "30", "outdoor_hum" => "30", "power_main" => "3355" ),
    '48' => array("id" => 48, "station_id" => 3, "create_time" => date("YmdHis", $time - 60 * 8), "indoor_tmp" => "26", 
        "colds_1_tmp" => "23", "outdoor_tmp" => "30", "outdoor_hum" => "30", "power_main" => "3355" ),
    '49' => array("id" => 49, "station_id" => 3, "create_time" => date("YmdHis", $time - 60 * 9), "indoor_tmp" => "26", 
        "colds_1_tmp" => "23", "outdoor_tmp" => "30", "outdoor_hum" => "30", "power_main" => "3355" ),
    '50' => array("id" => 50, "station_id" => 3, "create_time" => date("YmdHis", $time - 60 * 10), "indoor_tmp" => "26", 
        "colds_1_tmp" => "23", "outdoor_tmp" => "30", "outdoor_hum" => "30", "power_main" => "3355" ),


    //站点4    检测电表bug 空调1坏 是否可以正常关闭
    ' 61' => array("id" => 61, "station_id" => 4, "create_time" => date("YmdHis", $time - 60 * 1),  "colds_0_tmp" => "22",   
        "colds_0_on" => "0", "power_main" => "3355", "power_dc" => "2255", "energy_main" => "330", "energy_dc" => "220"),
    ' 62' => array("id" => 62, "station_id" => 4, "create_time" => date("YmdHis", $time - 60 * 2),  "colds_0_tmp" => "22",   
        "colds_0_on" => "0", "power_main" => "3355", "power_dc" => "2255", "energy_main" => "330", "energy_dc" => "220"),
    ' 63' => array("id" => 63, "station_id" => 4, "create_time" => date("YmdHis", $time - 60 * 3),  "colds_0_tmp" => "22",   
        "colds_0_on" => "0", "power_main" => "3355", "power_dc" => "2255", "energy_main" => "330", "energy_dc" => "220"),
    ' 64' => array("id" => 64, "station_id" => 4, "create_time" => date("YmdHis", $time - 60 * 4),  "colds_0_tmp" => "22",   
        "colds_0_on" => "0", "power_main" => "3355", "power_dc" => "2255", "energy_main" => "330", "energy_dc" => "220"),
    ' 65' => array("id" => 65, "station_id" => 4, "create_time" => date("YmdHis", $time - 60 * 5),  "colds_0_tmp" => "22",   
        "colds_0_on" => "0", "power_main" => "3355", "power_dc" => "2255", "energy_main" => "330", "energy_dc" => "220"),
    ' 66' => array("id" => 66, "station_id" => 4, "create_time" => date("YmdHis", $time - 60 * 6),  "colds_0_tmp" => "22",   
        "colds_0_on" => "0", "power_main" => "3355", "power_dc" => "2255", "energy_main" => "330", "energy_dc" => "220"),
    ' 67' => array("id" => 67, "station_id" => 4, "create_time" => date("YmdHis", $time - 60 * 7),  "colds_0_tmp" => "22",   
        "colds_0_on" => "0", "power_main" => "3355", "power_dc" => "2255", "energy_main" => "330", "energy_dc" => "220"),
    ' 68' => array("id" => 68, "station_id" => 4, "create_time" => date("YmdHis", $time - 60 * 8),  "colds_0_tmp" => "22",   
        "colds_0_on" => "0", "power_main" => "3355", "power_dc" => "2255", "energy_main" => "330", "energy_dc" => "220"),
    ' 69' => array("id" => 69, "station_id" => 4, "create_time" => date("YmdHis", $time - 60 * 9),  "colds_0_tmp" => "22",   
        "colds_0_on" => "0", "power_main" => "3355", "power_dc" => "2255", "energy_main" => "330", "energy_dc" => "220"),
    ' 70' => array("id" => 70, "station_id" => 4, "create_time" => date("YmdHis", $time - 60 * 10), "colds_0_tmp" => "22",   
        "colds_0_on" => "0", "power_main" => "3355", "power_dc" => "2255", "energy_main" => "330", "energy_dc" => "220"),

//5站   检测室内温感bug  停电bug 是否可以正常开启   
    ' 81' => array("id" => 81, "station_id" => 5, "create_time" => date("YmdHis", $time - 60 * 1), "indoor_tmp" => "", "indoor_hum" => "16", "box_tmp" => "22", "colds_0_tmp" => "22", "colds_1_tmp" => "23", "outdoor_tmp" => "30", "colds_0_on" => "0", "colds_1_on" => "0", "power_main" => "2", "power_dc" => "2255", "energy_main" => "330", "energy_dc" => "220"),
    ' 82' => array("id" => 82, "station_id" => 5, "create_time" => date("YmdHis", $time - 60 * 2), "indoor_tmp" => "", "indoor_hum" => "16", "box_tmp" => "22", "colds_0_tmp" => "22", "colds_1_tmp" => "23", "outdoor_tmp" => "30", "colds_0_on" => "0", "colds_1_on" => "0", "power_main" => "3", "power_dc" => "2255", "energy_main" => "330", "energy_dc" => "220"),
    ' 83' => array("id" => 83, "station_id" => 5, "create_time" => date("YmdHis", $time - 60 * 3), "indoor_tmp" => "", "indoor_hum" => "16", "box_tmp" => "22", "colds_0_tmp" => "22", "colds_1_tmp" => "23", "outdoor_tmp" => "30", "colds_0_on" => "0", "colds_1_on" => "0", "power_main" => "3", "power_dc" => "2255", "energy_main" => "330", "energy_dc" => "220"),
    ' 84' => array("id" => 84, "station_id" => 5, "create_time" => date("YmdHis", $time - 60 * 4), "indoor_tmp" => "", "indoor_hum" => "16", "box_tmp" => "22", "colds_0_tmp" => "22", "colds_1_tmp" => "23", "outdoor_tmp" => "30", "colds_0_on" => "0", "colds_1_on" => "0", "power_main" => "2", "power_dc" => "2255", "energy_main" => "330", "energy_dc" => "220"),
    ' 85' => array("id" => 85, "station_id" => 5, "create_time" => date("YmdHis", $time - 60 * 5), "indoor_tmp" => "", "indoor_hum" => "16", "box_tmp" => "22", "colds_0_tmp" => "22", "colds_1_tmp" => "23", "outdoor_tmp" => "30", "colds_0_on" => "0", "colds_1_on" => "0", "power_main" => "2", "power_dc" => "2255", "energy_main" => "330", "energy_dc" => "220"),
    ' 86' => array("id" => 86, "station_id" => 5, "create_time" => date("YmdHis", $time - 60 * 6), "indoor_tmp" => "", "indoor_hum" => "16", "box_tmp" => "22", "colds_0_tmp" => "22", "colds_1_tmp" => "23", "outdoor_tmp" => "30", "colds_0_on" => "0", "colds_1_on" => "0", "power_main" => "3", "power_dc" => "2255", "energy_main" => "330", "energy_dc" => "220"),
    ' 87' => array("id" => 87, "station_id" => 5, "create_time" => date("YmdHis", $time - 60 * 7), "indoor_tmp" => "", "indoor_hum" => "16", "box_tmp" => "22", "colds_0_tmp" => "22", "colds_1_tmp" => "23", "outdoor_tmp" => "30", "colds_0_on" => "0", "colds_1_on" => "0", "power_main" => "2", "power_dc" => "2255", "energy_main" => "330", "energy_dc" => "220"),
    ' 88' => array("id" => 88, "station_id" => 5, "create_time" => date("YmdHis", $time - 60 * 8), "indoor_tmp" => "", "indoor_hum" => "16", "box_tmp" => "22", "colds_0_tmp" => "22", "colds_1_tmp" => "23", "outdoor_tmp" => "30", "colds_0_on" => "0", "colds_1_on" => "0", "power_main" => "1", "power_dc" => "2255", "energy_main" => "330", "energy_dc" => "220"),
    ' 89' => array("id" => 89, "station_id" => 5, "create_time" => date("YmdHis", $time - 60 * 9), "indoor_tmp" => "", "indoor_hum" => "16", "box_tmp" => "22", "colds_0_tmp" => "22", "colds_1_tmp" => "23", "outdoor_tmp" => "30", "colds_0_on" => "0", "colds_1_on" => "0", "power_main" => "2", "power_dc" => "2255", "energy_main" => "330", "energy_dc" => "220"),
    ' 90' => array("id" => 90, "station_id" => 5, "create_time" => date("YmdHis", $time - 60 * 10), "indoor_tmp" => "", "indoor_hum" => "16", "box_tmp" => "22", "colds_0_tmp" => "22", "colds_1_tmp" => "23", "outdoor_tmp" => "30", "colds_0_on" => "0", "colds_1_on" => "0", "power_main" => "3", "power_dc" => "2255", "energy_main" => "330", "energy_dc" => "220"),
 

    //6站  检测室内高温bug 恒温柜bug  空调1,2bug 室外温感bug 电表bug 是否可以正常开启
     ' 101' => array("id" => 101, "station_id" => 6, "create_time" => date("YmdHis", $time - 60 * 1), "indoor_tmp" => "22", "indoor_hum" => "16", "box_tmp" => "", "colds_0_tmp" => "", "colds_1_tmp" => "", "outdoor_tmp" => "30", "colds_0_on" => "0", "colds_1_on" => "0", "power_main" => "3333", "power_dc" => "2255", "energy_main" => "", "energy_dc" => "220"),
    ' 102' => array("id" => 102, "station_id" => 6, "create_time" => date("YmdHis", $time - 60 * 2), "indoor_tmp" => "22", "indoor_hum" => "16", "box_tmp" => "", "colds_0_tmp" => "", "colds_1_tmp" => "", "outdoor_tmp" => "30", "colds_0_on" => "0", "colds_1_on" => "0", "power_main" => "3333", "power_dc" => "2255", "energy_main" => "", "energy_dc" => "220"),
    ' 103' => array("id" => 103, "station_id" => 6, "create_time" => date("YmdHis", $time - 60 * 3), "indoor_tmp" => "21", "indoor_hum" => "16", "box_tmp" => "", "colds_0_tmp" => "", "colds_1_tmp" => "", "outdoor_tmp" => "", "colds_0_on" => "0", "colds_1_on" => "0", "power_main" => "3333", "power_dc" => "2255", "energy_main" => "", "energy_dc" => "220"),
    ' 104' => array("id" => 104, "station_id" => 6, "create_time" => date("YmdHis", $time - 60 * 4), "indoor_tmp" => "20", "indoor_hum" => "16", "box_tmp" => "", "colds_0_tmp" => "", "colds_1_tmp" => "", "outdoor_tmp" => "", "colds_0_on" => "0", "colds_1_on" => "0", "power_main" => "3333", "power_dc" => "2255", "energy_main" => "", "energy_dc" => "220"),
    ' 105' => array("id" => 105, "station_id" => 6, "create_time" => date("YmdHis", $time - 60 * 5), "indoor_tmp" => "20", "indoor_hum" => "16", "box_tmp" => "", "colds_0_tmp" => "", "colds_1_tmp" => "", "outdoor_tmp" => "", "colds_0_on" => "0", "colds_1_on" => "0", "power_main" => "3333", "power_dc" => "2255", "energy_main" => "", "energy_dc" => "220"),
    ' 106' => array("id" => 106, "station_id" => 6, "create_time" => date("YmdHis", $time - 60 * 6), "indoor_tmp" => "42", "indoor_hum" => "16", "box_tmp" => "", "colds_0_tmp" => "", "colds_1_tmp" => "", "outdoor_tmp" => "", "colds_0_on" => "0", "colds_1_on" => "0", "power_main" => "3333", "power_dc" => "2255", "energy_main" => "", "energy_dc" => "220"),
    ' 107' => array("id" => 107, "station_id" => 6, "create_time" => date("YmdHis", $time - 60 * 7), "indoor_tmp" => "16", "indoor_hum" => "16", "box_tmp" => "", "colds_0_tmp" => "", "colds_1_tmp" => "", "outdoor_tmp" => "", "colds_0_on" => "0", "colds_1_on" => "0", "power_main" => "3333", "power_dc" => "2255", "energy_main" => "", "energy_dc" => "220"),
    ' 108' => array("id" => 108, "station_id" => 6, "create_time" => date("YmdHis", $time - 60 * 8), "indoor_tmp" => "16", "indoor_hum" => "16", "box_tmp" => "", "colds_0_tmp" => "", "colds_1_tmp" => "", "outdoor_tmp" => "", "colds_0_on" => "0", "colds_1_on" => "0", "power_main" => "3333", "power_dc" => "2255", "energy_main" => "", "energy_dc" => "220"),
    ' 109' => array("id" => 109, "station_id" => 6, "create_time" => date("YmdHis", $time - 60 * 9), "indoor_tmp" => "16", "indoor_hum" => "16", "box_tmp" => "", "colds_0_tmp" => "", "colds_1_tmp" => "", "outdoor_tmp" => "", "colds_0_on" => "0", "colds_1_on" => "0", "power_main" => "3333", "power_dc" => "2255", "energy_main" => "", "energy_dc" => "220"),
    ' 110' => array("id" => 110, "station_id" => 6, "create_time" => date("YmdHis", $time - 60 * 10), "indoor_tmp" => "16", "indoor_hum" => "16", "box_tmp" => "", "colds_0_tmp" => "", "colds_1_tmp" => "", "outdoor_tmp" => "", "colds_0_on" => "0", "colds_1_on" => "0", "power_main" => "3333", "power_dc" => "2255", "energy_main" => "", "energy_dc" => "220"),



    //站点7   检测弱链接bug 是否可以正常开启
    '199' => array("id" => 199, "station_id" => 7, "create_time" => date("YmdHis", $time - 60 * 1)),
    '200' => array("id" => 200, "station_id" => 7, "create_time" => date("YmdHis", $time - 60 * 2)), 
    '200' => array("id" => 200, "station_id" => 7, "create_time" => date("YmdHis", $time - 60 * 5)), 


    
    //站点8   检测485bug 是否可以正常关闭
    ' 121' => array("id" => 121, "station_id" => 8, "create_time" => date("YmdHis", $time - 60 * 1), "indoor_tmp" => "22", "indoor_hum" => "16", "box_tmp" => "22", "colds_0_tmp" => "33", "colds_1_tmp" => "22", "outdoor_tmp" => "30", "colds_0_on" => "0", "colds_1_on" => "0", "power_main" => "3333", "power_dc" => "2255", "energy_main" => "333", "energy_dc" => "220"),
    ' 122' => array("id" => 122, "station_id" => 8, "create_time" => date("YmdHis", $time - 60 * 2), "indoor_tmp" => "22", "indoor_hum" => "16", "box_tmp" => "22", "colds_0_tmp" => "33", "colds_1_tmp" => "22", "outdoor_tmp" => "30", "colds_0_on" => "0", "colds_1_on" => "0", "power_main" => "3333", "power_dc" => "2255", "energy_main" => "333", "energy_dc" => "220"),
    ' 123' => array("id" => 123, "station_id" => 8, "create_time" => date("YmdHis", $time - 60 * 3), "indoor_tmp" => "21", "indoor_hum" => "16", "box_tmp" => "22", "colds_0_tmp" => "33", "colds_1_tmp" => "22", "outdoor_tmp" => "", "colds_0_on" => "0", "colds_1_on" => "0", "power_main" => "3333", "power_dc" => "2255", "energy_main" => "333", "energy_dc" => "220"),
    ' 124' => array("id" => 124, "station_id" => 8, "create_time" => date("YmdHis", $time - 60 * 4), "indoor_tmp" => "20", "indoor_hum" => "16", "box_tmp" => "22", "colds_0_tmp" => "33", "colds_1_tmp" => "22", "outdoor_tmp" => "", "colds_0_on" => "0", "colds_1_on" => "0", "power_main" => "3333", "power_dc" => "2255", "energy_main" => "333", "energy_dc" => "220"),
    ' 125' => array("id" => 125, "station_id" => 8, "create_time" => date("YmdHis", $time - 60 * 5), "indoor_tmp" => "20", "indoor_hum" => "16", "box_tmp" => "22", "colds_0_tmp" => "33", "colds_1_tmp" => "22", "outdoor_tmp" => "20", "colds_0_on" => "0", "colds_1_on" => "0", "power_main" => "3333", "power_dc" => "2255", "energy_main" => "333", "energy_dc" => "220"),
    ' 126' => array("id" => 126, "station_id" => 8, "create_time" => date("YmdHis", $time - 60 * 6), "indoor_tmp" => "42", "indoor_hum" => "16", "box_tmp" => "22", "colds_0_tmp" => "33", "colds_1_tmp" => "22", "outdoor_tmp" => "20", "colds_0_on" => "0", "colds_1_on" => "0", "power_main" => "3333", "power_dc" => "2255", "energy_main" => "333", "energy_dc" => "220"),
    ' 127' => array("id" => 127, "station_id" => 8, "create_time" => date("YmdHis", $time - 60 * 7), "indoor_tmp" => "16", "indoor_hum" => "16", "box_tmp" => "22", "colds_0_tmp" => "33", "colds_1_tmp" => "22", "outdoor_tmp" => "", "colds_0_on" => "0", "colds_1_on" => "0", "power_main" => "3333", "power_dc" => "2255", "energy_main" => "333", "energy_dc" => "220"),
    ' 128' => array("id" => 128, "station_id" => 8, "create_time" => date("YmdHis", $time - 60 * 8), "indoor_tmp" => "16", "indoor_hum" => "16", "box_tmp" => "22", "colds_0_tmp" => "33", "colds_1_tmp" => "22", "outdoor_tmp" => "", "colds_0_on" => "0", "colds_1_on" => "0", "power_main" => "3333", "power_dc" => "2255", "energy_main" => "333", "energy_dc" => "220"),
    ' 129' => array("id" => 129, "station_id" => 8, "create_time" => date("YmdHis", $time - 60 * 9), "indoor_tmp" => "16", "indoor_hum" => "16", "box_tmp" => "22", "colds_0_tmp" => "33", "colds_1_tmp" => "22", "outdoor_tmp" => "", "colds_0_on" => "0", "colds_1_on" => "0", "power_main" => "3333", "power_dc" => "2255", "energy_main" => "333", "energy_dc" => "220"),

    //站点9 检测断开连接bug是否可以正常关闭
    '131' => array("id" => 131, "station_id" => 9, "create_time" => date("YmdHis", $time - 60 * 1)),
    '132' => array("id" => 132, "station_id" => 9, "create_time" => date("YmdHis", $time - 60 * 2)),
    
    //站点10  检测断开连接bug是否可以正常开启
    

    //站点11   检测恒温柜
    ' 133' => array("id" => 133, "station_id" => 11, "create_time" => date("YmdHis", $time - 60 * 1), "box_tmp" => "31"),
    ' 134' => array("id" => 134, "station_id" => 11, "create_time" => date("YmdHis", $time - 60 * 2), "box_tmp" => "29"),
    ' 135' => array("id" => 135, "station_id" => 11, "create_time" => date("YmdHis", $time - 60 * 3), "box_tmp" => "31"),
    ' 136' => array("id" => 136, "station_id" => 11, "create_time" => date("YmdHis", $time - 60 * 4), "box_tmp" => "29"),
    ' 137' => array("id" => 137, "station_id" => 11, "create_time" => date("YmdHis", $time - 60 * 5), "box_tmp" => "31"),
    ' 138' => array("id" => 138, "station_id" => 11, "create_time" => date("YmdHis", $time - 60 * 6), "box_tmp" => "29"),
    ' 139' => array("id" => 139, "station_id" => 11, "create_time" => date("YmdHis", $time - 60 * 7), "box_tmp" => "29"),
    ' 140' => array("id" => 140, "station_id" => 11, "create_time" => date("YmdHis", $time - 60 * 8), "box_tmp" => "29"),
    ' 141' => array("id" => 141, "station_id" => 11, "create_time" => date("YmdHis", $time - 60 * 9), "box_tmp" => "29"),
    
      //站点12   基准站空调未开启
    '143' => array("id" => 143, "station_id" => 12, "create_time"=>date("YmdHis", $time-60*1), "colds_0_on" => "0", "colds_1_on" => "0",),
    '144' => array("id" => 144, "station_id" => 12, "create_time"=>date("YmdHis", $time-60*2), "colds_0_on" => "0", "colds_1_on" => "0",),
    '145' => array("id" => 145, "station_id" => 12, "create_time"=>date("YmdHis", $time-60*3), "colds_0_on" => "0", "colds_1_on" => "0",),
    '146' => array("id" => 146, "station_id" => 12, "create_time"=>date("YmdHis", $time-60*4), "colds_0_on" => "0", "colds_1_on" => "0",),
    '147' => array("id" => 147, "station_id" => 12, "create_time"=>date("YmdHis", $time-60*5), "colds_0_on" => "0", "colds_1_on" => "0",),
    '148' => array("id" => 148, "station_id" => 12, "create_time"=>date("YmdHis", $time-60*6), "colds_0_on" => "0", "colds_1_on" => "0",),
    '149' => array("id" => 149, "station_id" => 12, "create_time"=>date("YmdHis", $time-60*7), "colds_0_on" => "0", "colds_1_on" => "0",),
    '150' => array("id" => 150, "station_id" => 12, "create_time"=>date("YmdHis", $time-60*8), "colds_0_on" => "0", "colds_1_on" => "0",),
    '151' => array("id" => 151, "station_id" => 12, "create_time"=>date("YmdHis", $time-60*9), "colds_0_on" => "0", "colds_1_on" => "0",),
    
      //站点13   MP1基准日空调未开启
    '152' => array("id" => 152, "station_id" => 13, "create_time"=>date("YmdHis", $time-60*1), "colds_0_on" => "0", "colds_1_on" => "0",),
    '153' => array("id" => 153, "station_id" => 13, "create_time"=>date("YmdHis", $time-60*2), "colds_0_on" => "0", "colds_1_on" => "0",),
    '154' => array("id" => 154, "station_id" => 13, "create_time"=>date("YmdHis", $time-60*3), "colds_0_on" => "0", "colds_1_on" => "0",),
    '155' => array("id" => 155, "station_id" => 13, "create_time"=>date("YmdHis", $time-60*4), "colds_0_on" => "0", "colds_1_on" => "0",),
    '156' => array("id" => 156, "station_id" => 13, "create_time"=>date("YmdHis", $time-60*5), "colds_0_on" => "0", "colds_1_on" => "0",),
    '157' => array("id" => 157, "station_id" => 13, "create_time"=>date("YmdHis", $time-60*6), "colds_0_on" => "0", "colds_1_on" => "0",),
    '158' => array("id" => 158, "station_id" => 13, "create_time"=>date("YmdHis", $time-60*7), "colds_0_on" => "0", "colds_1_on" => "0",),
    '159' => array("id" => 159, "station_id" => 13, "create_time"=>date("YmdHis", $time-60*8), "colds_0_on" => "0", "colds_1_on" => "0",),
    '160' => array("id" => 160, "station_id" => 13, "create_time"=>date("YmdHis", $time-60*9), "colds_0_on" => "0", "colds_1_on" => "0",),


    //站点14   MP1基准日空调未开启
    '163' => array("id" => 163, "station_id" => 14, "create_time"=>date("YmdHis", $time-60*1), "colds_0_on" => "1", "colds_1_on" => "0",),
    '164' => array("id" => 164, "station_id" => 14, "create_time"=>date("YmdHis", $time-60*2), "colds_0_on" => "1", "colds_1_on" => "0",),
    '165' => array("id" => 165, "station_id" => 14, "create_time"=>date("YmdHis", $time-60*3), "colds_0_on" => "1", "colds_1_on" => "0",),
    '166' => array("id" => 166, "station_id" => 14, "create_time"=>date("YmdHis", $time-60*4), "colds_0_on" => "1", "colds_1_on" => "0",),
    '167' => array("id" => 167, "station_id" => 14, "create_time"=>date("YmdHis", $time-60*5), "colds_0_on" => "1", "colds_1_on" => "0",),
    '168' => array("id" => 168, "station_id" => 14, "create_time"=>date("YmdHis", $time-60*6), "colds_0_on" => "1", "colds_1_on" => "0",),
    '169' => array("id" => 169, "station_id" => 14, "create_time"=>date("YmdHis", $time-60*7), "colds_0_on" => "1", "colds_1_on" => "0",),
    '170' => array("id" => 170, "station_id" => 14, "create_time"=>date("YmdHis", $time-60*8), "colds_0_on" => "1", "colds_1_on" => "0",),
    '171' => array("id" => 171, "station_id" => 14, "create_time"=>date("YmdHis", $time-60*9), "colds_0_on" => "1", "colds_1_on" => "0",)

    
);

