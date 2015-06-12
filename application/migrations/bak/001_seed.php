<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Seed extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field("`id`                 INT(10) UNSIGNED NOT NULL AUTO_INCREMENT");
        $this->dbforge->add_field("`setting_id`         INT(10) UNSIGNED DEFAULT '0' NOT NULL");
        $this->dbforge->add_field("`type`               INT(4) UNSIGNED DEFAULT '0' NOT NULL");
        $this->dbforge->add_field("`int_value`          INT(10) UNSIGNED DEFAULT NULL");
        $this->dbforge->add_field("`varchar_value`      VARCHAR(30) DEFAULT NULL");

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('setting_items');

        //$this->dbforge->add_field("`update_duration`    INT(10) UNSIGNED DEFAULT NULL");
        //$this->dbforge->add_field("`update_fixed_datetime` VARCHAR(30) DEFAULT NULL");
        //$this->dbforge->add_field("`sample_duration`    INT(10) UNSIGNED DEFAULT NULL");
        //$this->dbforge->add_field("`sample_fixed_datetime` VARCHAR(30) DEFAULT NULL");
        //$this->dbforge->add_field("`base_interval`      INT(10) UNSIGNED DEFAULT NULL");
        //$this->dbforge->add_field("`warning_period`     INT(10) UNSIGNED DEFAULT NULL");
        //$this->dbforge->add_field("`lowest_press`       INT(10) UNSIGNED DEFAULT NULL");
        //$this->dbforge->add_field("`highest_colds_temp` INT(10) UNSIGNED DEFAULT NULL");
        //$this->dbforge->add_field("`highest_indoor_tmp` INT(10) UNSIGNED DEFAULT NULL");
        //$this->dbforge->add_field("`highest_indoor_hum` INT(10) UNSIGNED DEFAULT NULL");
        //$this->dbforge->add_field("`highest_box_tmp`    INT(10) UNSIGNED DEFAULT NULL");
        //$this->dbforge->add_field("`type`               INT(4) UNSIGNED DEFAULT '0' NOT NULL");
        //$this->dbforge->add_field("`setting_type`       INT(4) UNSIGNED DEFAULT '0' NOT NULL");
        //$this->dbforge->add_field("`ch_tmp`     INT(10) UNSIGNED DEFAULT NULL");
        //$this->dbforge->add_field("`cd_tmp`     INT(10) UNSIGNED DEFAULT NULL");
        //$this->dbforge->add_field("`fan0_new_tmp_step`    INT(10) UNSIGNED DEFAULT NULL");
        //$this->dbforge->add_field("`hh_tmp` INT(10) UNSIGNED DEFAULT NULL");
        //$this->dbforge->add_field("`hd_tmp` INT(10) UNSIGNED DEFAULT NULL");



        $this->dbforge->add_field("`id`                 INT(10) UNSIGNED NOT NULL AUTO_INCREMENT");
        $this->dbforge->add_field("`station_id`         INT(10) UNSIGNED DEFAULT '0' NOT NULL");
        $this->dbforge->add_field("`command_id`         INT(10) UNSIGNED DEFAULT '0' NOT NULL");
        $this->dbforge->add_field("`name`               VARCHAR(30) DEFAULT NULL");
        $this->dbforge->add_field("`type`               TINYINT(2) UNSIGNED NOT NULL DEFAULT '0'");
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('settings');


        $this->dbforge->add_field("`session_id` varchar(40) COLLATE utf8_bin NOT NULL DEFAULT '0'");
        $this->dbforge->add_field("`ip_address` varchar(16) COLLATE utf8_bin NOT NULL DEFAULT '0'");
        $this->dbforge->add_field("`user_agent` varchar(150) COLLATE utf8_bin NOT NULL");
        $this->dbforge->add_field("`last_activity` int(10) unsigned NOT NULL DEFAULT '0'");
        $this->dbforge->add_field("`user_data` text COLLATE utf8_bin NOT NULL");
        $this->dbforge->add_key('session_id', TRUE);
        $this->dbforge->create_table('ci_sessions');


        $this->dbforge->add_field("`id` int(11) NOT NULL AUTO_INCREMENT");
        $this->dbforge->add_field("`ip_address` varchar(40) COLLATE utf8_bin NOT NULL");
        $this->dbforge->add_field("`login` varchar(50) COLLATE utf8_bin NOT NULL");
        $this->dbforge->add_field("`time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP");
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('login_attempts');


        $this->dbforge->add_field("`key_id` char(32) COLLATE utf8_bin NOT NULL");
        $this->dbforge->add_field("`user_id` int(11) NOT NULL DEFAULT '0'");
        $this->dbforge->add_field("`user_agent` varchar(150) COLLATE utf8_bin NOT NULL");
        $this->dbforge->add_field("`last_ip` varchar(40) COLLATE utf8_bin NOT NULL");
        $this->dbforge->add_field("`last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP");
        $this->dbforge->add_key('key_id', TRUE);
        $this->dbforge->create_table('user_autologin');


        $this->dbforge->add_field("`id` int(11) NOT NULL AUTO_INCREMENT");
        $this->dbforge->add_field("`user_id` int(11) NOT NULL");
        $this->dbforge->add_field("`country` varchar(20) COLLATE utf8_bin DEFAULT NULL");
        $this->dbforge->add_field("`website` varchar(255) COLLATE utf8_bin DEFAULT NULL");
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('user_profiles');

        $this->dbforge->add_field("`id` int(11) NOT NULL AUTO_INCREMENT");
        $this->dbforge->add_field("`username` varchar(50) COLLATE utf8_bin NOT NULL");
        $this->dbforge->add_field("`password` varchar(255) COLLATE utf8_bin NOT NULL");
        $this->dbforge->add_field("`email` varchar(100) COLLATE utf8_bin NOT NULL");
        $this->dbforge->add_field("`activated` tinyint(1) NOT NULL DEFAULT '1'");
        $this->dbforge->add_field("`banned` tinyint(1) NOT NULL DEFAULT '0'");
        $this->dbforge->add_field("`ban_reason` varchar(255) COLLATE utf8_bin DEFAULT NULL");
        $this->dbforge->add_field("`new_password_key` varchar(50) COLLATE utf8_bin DEFAULT NULL");
        $this->dbforge->add_field("`new_password_requested` datetime DEFAULT NULL");
        $this->dbforge->add_field("`new_email` varchar(100) COLLATE utf8_bin DEFAULT NULL");
        $this->dbforge->add_field("`new_email_key` varchar(50) COLLATE utf8_bin DEFAULT NULL");
        $this->dbforge->add_field("`last_ip` varchar(40) COLLATE utf8_bin NOT NULL");
        $this->dbforge->add_field("`last_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'");
        $this->dbforge->add_field("`created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'");
        $this->dbforge->add_field("`modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP");
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('users');


        $this->dbforge->add_field("`id`                 INT(10) UNSIGNED NOT NULL AUTO_INCREMENT");
        $this->dbforge->add_field("`name_chn`           VARCHAR(50) DEFAULT NULL");
        $this->dbforge->add_field("`name_py`            VARCHAR(50) DEFAULT NULL");
        $this->dbforge->add_field("`ip`                 VARCHAR(16) DEFAULT NULL");
        $this->dbforge->add_field("`alive`              TINYINT(1) UNSIGNED DEFAULT '0' NOT NULL");
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('stations');

        $this->db->query('alter table stations AUTO_INCREMENT=100');
        $this->db->insert('stations', array("id"=>1,"name_chn"=>'宜兴测试一号站',"name_py"=>'yx1h'));
        $this->db->insert('stations', array("id"=>2,"name_chn"=>'宜兴测试二号站',"name_py"=>'yx2h'));
        $this->db->insert('stations', array("id"=>3,"name_chn"=>'宜兴测试三号站',"name_py"=>'yx3h'));
        $this->db->insert('stations', array("id"=>4,"name_chn"=>'宜兴测试四号站',"name_py"=>'yx4h'));
        $this->db->insert('stations', array("id"=>5,"name_chn"=>'宜兴测试五号站',"name_py"=>'yx5h'));
        $this->db->insert('stations', array("id"=>6,"name_chn"=>'宜兴测试六号站',"name_py"=>'yx6h'));


        $this->dbforge->add_field("`id`                 INT(10) UNSIGNED NOT NULL AUTO_INCREMENT");
        $this->dbforge->add_field("`station_id`         INT(10) UNSIGNED DEFAULT '0' NOT NULL");
        $this->dbforge->add_field("`num`                TINYINT(2) DEFAULT NULL");
        $this->dbforge->add_field("`create_time`        datetime NOT NULL DEFAULT '0000-00-00 00:00:00'");
        $this->dbforge->add_field("`type`               tinyint(2) UNSIGNED NOT NULL DEFAULT '0'");
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('temperatures');



        $this->dbforge->add_field("`id`                 INT(10) UNSIGNED NOT NULL AUTO_INCREMENT");
        $this->dbforge->add_field("`station_id`         INT(10) UNSIGNED DEFAULT '0' NOT NULL");
        $this->dbforge->add_field("`num`                TINYINT(3) UNSIGNED DEFAULT NULL");
        $this->dbforge->add_field("`create_time`        datetime NOT NULL DEFAULT '0000-00-00 00:00:00'");
        $this->dbforge->add_field("`type`               tinyint(2) UNSIGNED NOT NULL DEFAULT '0'");

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('humidities');




        $this->dbforge->add_field("`id`                 INT(10) UNSIGNED NOT NULL AUTO_INCREMENT");
        $this->dbforge->add_field("`station_id`         INT(10) UNSIGNED DEFAULT '0' NOT NULL");
        $this->dbforge->add_field("`num`                INT(4) UNSIGNED DEFAULT NULL");
        $this->dbforge->add_field("`create_time`        datetime NOT NULL DEFAULT '0000-00-00 00:00:00'");
        $this->dbforge->add_field("`type`               tinyint(2) UNSIGNED NOT NULL DEFAULT '0'");

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('powers');


        $this->dbforge->add_field("`id`                 INT(10) UNSIGNED NOT NULL AUTO_INCREMENT");
        $this->dbforge->add_field("`station_id`         INT(10) UNSIGNED DEFAULT '0' NOT NULL");
        $this->dbforge->add_field("`num`                INT(4) UNSIGNED DEFAULT NULL");
        $this->dbforge->add_field("`create_time`        datetime NOT NULL DEFAULT '0000-00-00 00:00:00'");
        $this->dbforge->add_field("`type`               tinyint(2) UNSIGNED NOT NULL DEFAULT '0'");

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('energies');



        $this->dbforge->add_field("`id`                 INT(10) UNSIGNED NOT NULL AUTO_INCREMENT");
        $this->dbforge->add_field("`station_id`         INT(10) UNSIGNED DEFAULT '0' NOT NULL");
        $this->dbforge->add_field("`num`                TINYINT(1) UNSIGNED DEFAULT NULL");
        $this->dbforge->add_field("`create_time`        datetime NOT NULL DEFAULT '0000-00-00 00:00:00'");
        $this->dbforge->add_field("`type`               tinyint(2) UNSIGNED NOT NULL DEFAULT '0'");

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('switchons');



        $this->dbforge->add_field("`id`                 INT(10) UNSIGNED NOT NULL AUTO_INCREMENT");
        $this->dbforge->add_field("`station_id`         INT(10) UNSIGNED DEFAULT '0' NOT NULL");
        $this->dbforge->add_field("`command`            VARCHAR(50) DEFAULT NULL");
        $this->dbforge->add_field("`arg`                VARCHAR(2048) DEFAULT NULL");
        $this->dbforge->add_field("`priority`           tinyint(1) NOT NULL DEFAULT '0'");
        $this->dbforge->add_field("`status`             tinyint(1) NOT NULL DEFAULT '0'");

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('commands');



        $this->dbforge->add_field("`id`                 INT(10) UNSIGNED NOT NULL AUTO_INCREMENT");
        $this->dbforge->add_field("`station_id`         INT(10) UNSIGNED DEFAULT '0' NOT NULL");
        $this->dbforge->add_field("`type`               INT(4) UNSIGNED DEFAULT '0' NOT NULL");
        $this->dbforge->add_field("`create_time`        datetime NOT NULL DEFAULT '0000-00-00 00:00:00'");

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('warnings');

    }

    public function down()
    {
        //$this->dbforge->drop_table('station');
    }
}

