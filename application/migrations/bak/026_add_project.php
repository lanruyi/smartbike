<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_project extends CI_Migration {


    public function up()
    {
        $this->dbforge->add_field("`id`               INT(10) UNSIGNED NOT NULL AUTO_INCREMENT");
        $this->dbforge->add_field("`name_chn`         VARCHAR(50) DEFAULT NULL");
        $this->dbforge->add_field("`is_hide_front`    TINYINT(1) NOT NULL DEFAULT '0'");
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('projects');


        $this->dbforge->add_field("`user_id`               INT(10) UNSIGNED DEFAULT '0' NOT NULL");
        $this->dbforge->add_field("`project_id`               INT(10) UNSIGNED DEFAULT '0' NOT NULL");
        $this->dbforge->add_key(array('user_id','project_id'), TRUE);
        $this->dbforge->create_table('user_projects');


        $fields = array("`project_id`     int(10) NOT NULL DEFAULT '1' ");
        $this->dbforge->add_column('stations', $fields);


        $fields = array("`current_project_id`   int(10) DEFAULT NULL");
        $this->dbforge->add_column('users', $fields);


        $this->db->insert('projects', array("id"=>1,"name_chn"=>'未定义项目基站',"is_hide_front"=>'1'));
        $this->db->insert('projects', array("id"=>2,"name_chn"=>'安装过程中',"is_hide_front"=>'1'));
        $this->db->insert('projects', array("id"=>3,"name_chn"=>'研发部测试项目',"is_hide_front"=>'0'));
        $this->db->insert('projects', array("id"=>4,"name_chn"=>'研发部演示项目',"is_hide_front"=>'0'));

        $this->db->query('ALTER TABLE  `projects` AUTO_INCREMENT = 100');
        
    }

    public function down()
    {
        $this->dbforge->drop_table('projects');
        $this->dbforge->drop_table('user_projects');
        $this->dbforge->drop_column('stations', 'project_id');
        $this->dbforge->drop_column('users', 'current_project_id');
         
    }

}

?>
