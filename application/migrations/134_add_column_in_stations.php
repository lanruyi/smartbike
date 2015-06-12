<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_column_in_stations extends CI_Migration {

    public function up()
    {
        $this->db->query("alter table stations add column colds_0_func tinyint(2) not null default 0 comment '空调1的控制方式：1、继电器 2、脉冲开关 3、接触器 4、红外 5、无'");
        $this->db->query("alter table stations add column colds_1_func tinyint(2) not null default 0 comment '空调2的控制方式：1、继电器 2、脉冲开关 3、接触器 4、红外 5、无'");
        //$this->db->query("alter table stations add column box_status tinyint(2) not null default 0 comment '恒温柜的状态：1、春兰 2、无 3、榜样'");
    }
    
    public function down()
    {
        $this->db->query("alter table stations drop column colds_0_func");
        $this->db->query("alter table stations drop column colds_1_func");
        //$this->db->query("alter table stations drop column box_status");
    }

}








