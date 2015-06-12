<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_appins extends CI_Migration {

    public function up(){
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `appins` (
              `id`        int(11) NOT NULL AUTO_INCREMENT,
              `content`   text NOT NULL default ''  comment '上传数据',
              `user_id`   int(11) default NULL      comment '上传人',
              `datetime`  datetime NOT NULL         comment '上传时间',
              `type`      varchar(20) NOT NULL      comment '上传类型',
              PRIMARY KEY (`id`)
            ) 
        ");
    }

    public function down()
    {
        $this->dbforge->drop_table('appins');
    }

}
