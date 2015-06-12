<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//工单历史状态，1代表存活着，2代表是历史
define('ESC_WORK_ORDER_ALIVE', 1);
define('ESC_WORK_ORDER_HISTORY', 2);

//工单的归属方,1代表我方，2代表第三方
define('ESC_WORK_ORDER_WE',1);
define('ESC_WORK_ORDER_THIRD_PARTY',2);

//工单的几种状态
define('ESC_WORK_ORDER__CREATE',1);
define('ESC_WORK_ORDER__CONFIRM',2);
define('ESC_WORK_ORDER__FIX',3);
define('ESC_WORK_ORDER__CLOSE',4);

//修复状态
define('ESC_WORK_ORDER_NO_REPAIRED',1);
define('ESC_WORK_ORDER_REPAIRED',2);

class Work_order extends ES_Model {

  public function __construct()
  {
    $this->load->helper(array());
    $this->table_name = "work_orders";
  }
     
  //查找工单的基站id
  public function find_Station_Id($work_order_id){
      $work_order = $this->find_sql($work_order_id);
      return $work_order?$work_order['station_id']:null;
  }

}













