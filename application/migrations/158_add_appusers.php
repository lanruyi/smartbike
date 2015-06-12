<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_appusers extends CI_Migration {

    public function up(){
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `appusers` (
              `id`          int(11) NOT NULL AUTO_INCREMENT,
              `app_id`      varchar(40) default NULL      comment '设备id',
              `user_id`     int(11) default NULL          comment '用户id',
              `createtime`  datetime NOT NULL             comment '绑定时间',
              `auth`        tinyint(2) NOT NULL default 1 comment '权限',
              PRIMARY KEY (`id`)
            ) 
        ");
    }

    public function down()
    {
        $this->dbforge->drop_table('appusers');
    }

}
