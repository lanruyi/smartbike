<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');




function h_auth_all_zero(){
    $auth = "";
    for($i=0;$i<20;$i++){$auth.= chr(0);}
    return $auth;
}

function h_role_is_admin($role){
    return $role['id'] == 3;
}

function h_auth_check_role($role,$num){
    return h_auth_check($role['authorities'],$num);
}

function h_auth_check($auths,$num){
    return (ord($auths[intval(floor($num/8))]) & pow(2,$num%8))>0;
}

function h_auth_display($auths){
    $c = "";
    for($i=0;$i<20;$i++){$c.= ord($auths[$i])." ";}
    return $c;
}

function h_auth_set_1($auths,$num){
    $auths[floor($num/8)] = chr(ord($auths[floor($num/8)]) | pow(2,$num%8));
    return $auths;
}

