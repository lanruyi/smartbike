<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/********************************
Fast JJump 
Entities/Cmail.php 
..\..\controllers\cmail.php

********************************/


define('ESC_CMAIL_STATUS__WAIT',1);
define('ESC_CMAIL_STATUS__SENT',2);
define('ESC_CMAIL_STATUS__CANCEL',3);

define('ESC_CMAIL_TYPE__WARNING_INSTANT',1);
define('ESC_CMAIL_TYPE__WARNING_REPORT',2);


class Cmail extends ES_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->table_name = "cmails";
    }

    public function findAllWaitCmails(){
        return $this->findBy_sql(array("status"=>ESC_CMAIL_STATUS__WAIT));
    }

    public function newWarningInstantCmail($to,$con="",$title=""){
        //      $now = new DateTime();
        //      $_cmail->setToAdd($to);
        //      $_cmail->setFromAdd("warning@semos-cloud.com");
        //      //$_cmail->setSubject("紧急报警 ".$title." [AirBorne Cloud]");
        //      $_cmail->setSubject($title);
        //      $_cmail->setContent($con);
        //      $_cmail->setStatus(ESC_CMAIL_STATUS__WAIT);
        //      $_cmail->setCreateTime($now);
        //      $_cmail->setSendTime($now);
        //      $_cmail->setType(ESC_CMAIL_TYPE__WARNING_INSTANT);
        //      $_cmail->setPriority(1);

    }

    public function newTestCmail($to,$con=""){
        //      $now = new DateTime();
        //      $_cmail->setToAdd($to);
        //      $_cmail->setFromAdd("warning@semos-cloud.com");
        //      $_cmail->setSubject("Semos Cloud 测试邮件 标题一定要长长长长长长长长长长长长长长--");
        //      $_cmail->setContent($con);
        //      $_cmail->setStatus(ESC_CMAIL_STATUS__WAIT);
        //      $_cmail->setCreateTime($now);
        //      $_cmail->setSendTime($now);
        //      $_cmail->setType(ESC_CMAIL_TYPE__WARNING_INSTANT);
        //      $_cmail->setPriority(1);
    }

}
?>
