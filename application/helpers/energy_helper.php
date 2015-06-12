<?php if (!defined('BASEPATH')) exit('No direct script accessss allowed');

// ..\..\tests\helpers\EnergyHelperTest.php

// 江苏基准标杆节能公式 通过标杆（节能）站电量计算节能量等信息
function h_e_jiangsu_save_energy($main_energy,$rate){
    if($rate<1){
        return $main_energy * $rate / (1-$rate);
    }else{
        return 0;
    }
}

// 江苏基准标杆节能公式
function h_e_jiangsu_save_rate($std_energy, $sav_energy, $std_load_num, $sav_load_num){
    if ($std_energy == 0 || $sav_energy == 0){
        return 0;
    }
    if( $std_load_num && $sav_load_num ){
        $load_correct = $std_load_num / $sav_load_num;
    }else{
        $load_correct = 1;
    }
    $rate = ($std_energy - $sav_energy * $load_correct ) / $std_energy;
    if($rate < 0){
        $rate = 0;
    }
    return $rate;
}
//上海节能计算公式
function h_e_shanghai_save_rate($std_energy,$sav_energy,$std_load_num,$sav_load_num){
    if ($std_energy==0 || $sav_energy==0 ){
        return 0;
    }
    $rate=($std_energy-$sav_energy/$std_load_num*$sav_load_num)/$std_energy;
    return $rate;
}
function h_e_shanghai_save_energy($sav_energy,$rate){
    if($rate>0 && $rate <1){
        return $sav_energy*$rate/(1-$rate);
    }
}
