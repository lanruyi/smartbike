<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_user_auth extends CI_Migration {

    public function up()
    {
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
    }

    public function down()
    {
        $this->dbforge->drop_table('ci_sessions');
        $this->dbforge->drop_table('login_attempts');
        $this->dbforge->drop_table('user_autologin');
        $this->dbforge->drop_table('user_profiles');
        $this->dbforge->drop_table('users');
    }

}

?>
