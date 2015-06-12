-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2013 年 12 月 11 日 04:46
-- 服务器版本: 5.5.16
-- PHP 版本: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `esdata`
--

-- --------------------------------------------------------

--
-- 表的结构 `agingdatas`
--

CREATE TABLE IF NOT EXISTS `agingdatas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `esg_id` int(10) unsigned NOT NULL DEFAULT '0',
  `indoor_tmp` decimal(3,1) DEFAULT NULL,
  `outdoor_tmp` decimal(3,1) DEFAULT NULL,
  `box_tmp` decimal(3,1) DEFAULT NULL,
  `colds_0_tmp` decimal(3,1) DEFAULT NULL,
  `colds_1_tmp` decimal(3,1) DEFAULT NULL,
  `indoor_hum` tinyint(3) DEFAULT NULL,
  `outdoor_hum` tinyint(3) DEFAULT NULL,
  `colds_0_on` tinyint(1) DEFAULT NULL,
  `colds_1_on` tinyint(1) DEFAULT NULL,
  `fan_0_on` tinyint(1) DEFAULT NULL,
  `colds_box_on` tinyint(1) DEFAULT NULL,
  `power_main` int(4) DEFAULT NULL,
  `power_dc` int(4) DEFAULT NULL,
  `energy_main` decimal(10,2) DEFAULT NULL,
  `energy_dc` decimal(10,2) DEFAULT NULL,
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `true_out_tmp` decimal(3,1) DEFAULT NULL,
  `box_tmp_1` decimal(3,1) DEFAULT NULL,
  `box_tmp_2` decimal(3,1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `station_time` (`esg_id`,`create_time`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- 表的结构 `areas`
--

CREATE TABLE IF NOT EXISTS `areas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name_chn` varchar(50) DEFAULT NULL,
  `name_py` varchar(50) DEFAULT NULL,
  `weather_code` varchar(20) DEFAULT NULL,
  `type` int(4) unsigned NOT NULL DEFAULT '0',
  `lng` varchar(20) DEFAULT NULL,
  `lat` varchar(20) DEFAULT NULL,
  `father_id` int(9) NOT NULL DEFAULT '0' COMMENT '父类id',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_chn` (`name_chn`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=72 ;

-- --------------------------------------------------------

--
-- 表的结构 `autochecks`
--

CREATE TABLE IF NOT EXISTS `autochecks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `station_id` int(11) NOT NULL,
  `datetime` datetime NOT NULL,
  `check_time` tinyint(4) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `report` varchar(210) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- 表的结构 `batches`
--

CREATE TABLE IF NOT EXISTS `batches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contract_id` int(9) DEFAULT NULL COMMENT '合同id',
  `city_id` int(9) DEFAULT NULL COMMENT '城市id',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `start_time` datetime DEFAULT NULL COMMENT '开始时间',
  `total_month` smallint(6) DEFAULT NULL COMMENT '总收款时间，单位：月',
  `current_time` datetime DEFAULT NULL COMMENT '上一次收款时间',
  `recycle` tinyint(3) NOT NULL DEFAULT '1' COMMENT '合同状态：1、活着的 2、已删除',
  `name_chn` varchar(200) NOT NULL DEFAULT '' COMMENT '全名',
  `batch_num` tinyint(2) NOT NULL DEFAULT '0' COMMENT '第几批',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='批次表' AUTO_INCREMENT=21 ;

-- --------------------------------------------------------

--
-- 表的结构 `blogs`
--

CREATE TABLE IF NOT EXISTS `blogs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `station_id` int(10) unsigned DEFAULT NULL,
  `author_id` int(10) unsigned DEFAULT NULL,
  `content` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `blog_type` tinyint(2) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5907 ;

-- --------------------------------------------------------

--
-- 表的结构 `bugs`
--

CREATE TABLE IF NOT EXISTS `bugs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `station_id` int(11) NOT NULL,
  `type` tinyint(3) unsigned NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `start_time` datetime NOT NULL,
  `update_time` datetime DEFAULT NULL,
  `stop_time` datetime DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `arg` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `station_id` (`station_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=585237 ;

-- --------------------------------------------------------

--
-- 表的结构 `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '0',
  `ip_address` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '0',
  `user_agent` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `cmails`
--

CREATE TABLE IF NOT EXISTS `cmails` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `to_add` text NOT NULL,
  `from_add` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `content` text NOT NULL,
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `priority` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `send_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `real_send_time` datetime DEFAULT '0000-00-00 00:00:00',
  `time_consume` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=699 ;

-- --------------------------------------------------------

--
-- 表的结构 `commands`
--

CREATE TABLE IF NOT EXISTS `commands` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `station_id` int(10) unsigned NOT NULL DEFAULT '0',
  `command` varchar(50) DEFAULT NULL,
  `arg` varchar(2048) DEFAULT NULL,
  `priority` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `user_id` int(10) unsigned DEFAULT NULL,
  `create_time` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `station_id_2` (`station_id`,`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=249266 ;

-- --------------------------------------------------------

--
-- 表的结构 `contracts`
--

CREATE TABLE IF NOT EXISTS `contracts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_chn` varchar(255) NOT NULL COMMENT '合同号',
  `project_id` int(9) DEFAULT NULL COMMENT '项目id',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `recycle` tinyint(3) NOT NULL DEFAULT '1' COMMENT '合同状态：1、活着的 2、已删除',
  `image` varchar(255) NOT NULL COMMENT '图片',
  `content` text NOT NULL COMMENT '描述',
  `phase_num` tinyint(2) NOT NULL DEFAULT '0' COMMENT '第几期',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='合同表' AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- 表的结构 `corrects`
--

CREATE TABLE IF NOT EXISTS `corrects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `station_id` int(10) unsigned NOT NULL,
  `org_num` decimal(10,2) DEFAULT NULL,
  `correct_num` decimal(10,2) DEFAULT NULL,
  `type` tinyint(2) unsigned DEFAULT '0',
  `base` decimal(10,2) DEFAULT NULL,
  `correct_base` decimal(10,2) DEFAULT NULL,
  `slope` decimal(6,5) DEFAULT NULL,
  `time` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2191 ;

-- --------------------------------------------------------

--
-- 表的结构 `datas`
--

CREATE TABLE IF NOT EXISTS `datas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `station_id` int(10) unsigned NOT NULL DEFAULT '0',
  `indoor_tmp` decimal(3,1) DEFAULT NULL,
  `outdoor_tmp` decimal(3,1) DEFAULT NULL,
  `box_tmp` decimal(3,1) DEFAULT NULL,
  `colds_0_tmp` decimal(3,1) DEFAULT NULL,
  `colds_1_tmp` decimal(3,1) DEFAULT NULL,
  `indoor_hum` tinyint(3) DEFAULT NULL,
  `outdoor_hum` tinyint(3) DEFAULT NULL,
  `colds_0_on` tinyint(1) DEFAULT NULL,
  `colds_1_on` tinyint(1) DEFAULT NULL,
  `fan_0_on` tinyint(1) DEFAULT NULL,
  `colds_box_on` tinyint(1) DEFAULT NULL,
  `power_main` int(4) DEFAULT NULL,
  `power_dc` int(4) DEFAULT NULL,
  `energy_main` decimal(10,2) DEFAULT NULL,
  `energy_dc` decimal(10,2) DEFAULT NULL,
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `station_time` (`station_id`,`create_time`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13292610 ;

-- --------------------------------------------------------

--
-- 表的结构 `data_exts`
--

CREATE TABLE IF NOT EXISTS `data_exts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data_id` int(11) NOT NULL,
  `true_out_tmp` decimal(3,1) DEFAULT NULL,
  `box_tmp_1` decimal(3,1) DEFAULT NULL,
  `box_tmp_2` decimal(3,1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- 表的结构 `data_indexs`
--

CREATE TABLE IF NOT EXISTS `data_indexs` (
  `id` smallint(11) NOT NULL,
  `from` date NOT NULL,
  `to` date NOT NULL,
  `project_id` int(11) NOT NULL,
  `table` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `daydatas`
--

CREATE TABLE IF NOT EXISTS `daydatas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `station_id` int(11) NOT NULL,
  `day` date NOT NULL,
  `main_energy` decimal(5,2) DEFAULT NULL,
  `dc_energy` decimal(5,2) DEFAULT NULL,
  `ac_energy` decimal(5,2) DEFAULT NULL,
  `packets` smallint(5) DEFAULT NULL,
  `calc_type` tinyint(4) NOT NULL DEFAULT '1',
  `is_first_day` tinyint(1) NOT NULL DEFAULT '1',
  `true_load_num` decimal(9,6) DEFAULT NULL COMMENT '真实负载',
  `load_num` decimal(5,2) DEFAULT NULL COMMENT '当日负载',
  PRIMARY KEY (`id`),
  KEY `day_station` (`day`,`station_id`),
  KEY `station_day` (`station_id`,`day`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=685331 ;

-- --------------------------------------------------------

--
-- 表的结构 `departments`
--

CREATE TABLE IF NOT EXISTS `departments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name_chn` varchar(50) DEFAULT NULL,
  `role_id` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- 表的结构 `edges`
--

CREATE TABLE IF NOT EXISTS `edges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_chn` varchar(20) NOT NULL,
  `edge_desc` text NOT NULL,
  `query` text NOT NULL,
  `time_slot` varchar(200) NOT NULL,
  `threshold` int(10) NOT NULL,
  `last_query_time` datetime DEFAULT NULL,
  `station_nums` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- 表的结构 `esgconfs`
--

CREATE TABLE IF NOT EXISTS `esgconfs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `station_id` int(10) unsigned NOT NULL DEFAULT '0',
  `update_duration` int(10) DEFAULT NULL,
  `fan_sampling_last_time` int(10) DEFAULT NULL,
  `base_day_ac_temp` int(10) DEFAULT NULL,
  `energy_saving_ac_temp` int(10) DEFAULT NULL,
  `base_interval` varchar(50) DEFAULT NULL,
  `warning_period` int(10) DEFAULT NULL,
  `lowest_press` int(10) DEFAULT NULL,
  `highest_colds_temp` decimal(10,2) DEFAULT NULL,
  `highest_indoor_tmp` decimal(10,2) DEFAULT NULL,
  `highest_indoor_hum` decimal(10,2) DEFAULT NULL,
  `highest_box_tmp` decimal(10,2) DEFAULT NULL,
  `ch_tmp` decimal(10,2) DEFAULT NULL,
  `cd_tmp` decimal(10,2) DEFAULT NULL,
  `all_close_temp` decimal(10,2) DEFAULT NULL,
  `temp_adjust_factor` decimal(10,2) DEFAULT NULL,
  `fan_min_time` decimal(10,2) DEFAULT NULL,
  `sys_mode` int(10) DEFAULT NULL,
  `simple_control` int(10) DEFAULT NULL,
  `day_of_week` int(10) DEFAULT NULL,
  `ctime` int(10) DEFAULT NULL,
  `colds_order` int(10) DEFAULT NULL,
  `colds_min_time` int(10) DEFAULT NULL,
  `colds_box_type` int(10) DEFAULT NULL,
  `smart_meter_type` int(10) DEFAULT NULL,
  `colds_0_ctrl_type` int(10) DEFAULT NULL,
  `colds_1_ctrl_type` int(10) DEFAULT NULL,
  `fan_keep_on_time` int(10) DEFAULT NULL,
  `last_update_time` datetime DEFAULT NULL,
  `fan_full_speed_duration` varchar(50) DEFAULT NULL,
  `colds_onoff_distance` decimal(10,1) DEFAULT NULL,
  `in_out_distance` tinyint(2) DEFAULT NULL,
  `colds_box_workpoint` tinyint(2) DEFAULT NULL,
  `colds_box_worksens` tinyint(2) DEFAULT NULL,
  `load_num` decimal(5,2) NOT NULL DEFAULT '0.00' COMMENT '当前基站负载',
  `host` varchar(20) NOT NULL DEFAULT '' COMMENT '上位机主机名',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2353 ;

-- --------------------------------------------------------

--
-- 表的结构 `esgs`
--

CREATE TABLE IF NOT EXISTS `esgs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `string` varchar(50) DEFAULT NULL,
  `esg_key` varchar(50) DEFAULT NULL,
  `station_id` int(10) DEFAULT NULL,
  `alive` tinyint(1) NOT NULL DEFAULT '0',
  `count` int(10) NOT NULL DEFAULT '0',
  `status` tinyint(3) NOT NULL DEFAULT '0',
  `create_time` datetime DEFAULT '0000-00-00 00:00:00',
  `last_update_time` datetime DEFAULT NULL,
  `aging_status` tinyint(1) DEFAULT '0',
  `aging_start_time` datetime DEFAULT NULL,
  `aging_stop_time` datetime DEFAULT NULL,
  `aging_report` text,
  `host` varchar(50) NOT NULL DEFAULT '',
  `subsys` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `station_id` (`station_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1100114176 ;

-- --------------------------------------------------------

--
-- 表的结构 `eslogs`
--

CREATE TABLE IF NOT EXISTS `eslogs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `long_log` text NOT NULL,
  `log` varchar(255) DEFAULT NULL,
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=366 ;

-- --------------------------------------------------------

--
-- 表的结构 `fixbugs`
--

CREATE TABLE IF NOT EXISTS `fixbugs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `station_id` int(11) NOT NULL,
  `bug_type` tinyint(2) NOT NULL,
  `time` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1403 ;

-- --------------------------------------------------------

--
-- 表的结构 `fixdatas`
--

CREATE TABLE IF NOT EXISTS `fixdatas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `station_id` int(10) unsigned NOT NULL DEFAULT '0',
  `energy_main` decimal(10,2) DEFAULT NULL,
  `energy_dc` decimal(10,2) DEFAULT NULL,
  `energy_main_flag` tinyint(4) NOT NULL DEFAULT '0',
  `energy_dc_flag` tinyint(4) NOT NULL DEFAULT '0',
  `time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `station_time` (`station_id`,`time`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=492989 ;

-- --------------------------------------------------------

--
-- 表的结构 `hourdatas`
--

CREATE TABLE IF NOT EXISTS `hourdatas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `station_id` int(11) NOT NULL,
  `energy_main` decimal(5,2) DEFAULT NULL,
  `energy_dc` decimal(5,2) DEFAULT NULL,
  `energy_ac` decimal(5,2) DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `loadleveldatas`
--

CREATE TABLE IF NOT EXISTS `loadleveldatas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datetime` datetime NOT NULL,
  `project_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `building_type` tinyint(1) NOT NULL,
  `total_load` tinyint(1) NOT NULL,
  `time_type` tinyint(1) NOT NULL,
  `saving_rate` decimal(6,4) DEFAULT NULL,
  `saving_func` int(11) DEFAULT NULL,
  `error` tinyint(2) DEFAULT NULL,
  `warning` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8303 ;

-- --------------------------------------------------------

--
-- 表的结构 `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `version` int(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `monthdatas`
--

CREATE TABLE IF NOT EXISTS `monthdatas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `station_id` int(11) NOT NULL,
  `datetime` datetime NOT NULL,
  `main_energy` decimal(7,2) DEFAULT NULL,
  `dc_energy` decimal(7,2) DEFAULT NULL,
  `ac_energy` decimal(5,2) DEFAULT NULL,
  `calc_type` tinyint(4) NOT NULL DEFAULT '1',
  `true_energy` decimal(7,2) DEFAULT NULL,
  `reason` text NOT NULL,
  `true_load_num` decimal(9,6) DEFAULT NULL COMMENT '真实负载',
  PRIMARY KEY (`id`),
  UNIQUE KEY `station_id` (`station_id`,`datetime`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36078 ;

-- --------------------------------------------------------

--
-- 表的结构 `notes`
--

CREATE TABLE IF NOT EXISTS `notes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `station_id` int(10) unsigned DEFAULT NULL,
  `author_id` int(10) unsigned DEFAULT NULL,
  `content` text CHARACTER SET utf8 COLLATE utf8_bin,
  `create_time` datetime DEFAULT NULL,
  `note_time` datetime DEFAULT NULL,
  `openness` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=66 ;

-- --------------------------------------------------------

--
-- 表的结构 `np1stddays`
--

CREATE TABLE IF NOT EXISTS `np1stddays` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `station_id` int(10) DEFAULT NULL COMMENT '基站id',
  `datetime` datetime DEFAULT NULL COMMENT '哪一天是节能日',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='n+1基站的节能日' AUTO_INCREMENT=5687 ;

-- --------------------------------------------------------

--
-- 表的结构 `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name_chn` varchar(50) DEFAULT NULL,
  `is_hide_front` tinyint(1) NOT NULL DEFAULT '0',
  `total_warnings` varchar(255) DEFAULT NULL,
  `city_list` varchar(255) DEFAULT NULL,
  `type` tinyint(1) DEFAULT '1',
  `config_str` text,
  `is_product` tinyint(4) DEFAULT '1',
  `domin` varchar(50) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=111 ;

-- --------------------------------------------------------

--
-- 表的结构 `properties`
--

CREATE TABLE IF NOT EXISTS `properties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `esg_id` int(11) NOT NULL,
  `station_id` int(11) NOT NULL,
  `rom_version` varchar(20) DEFAULT NULL,
  `es_main_bd_ver` varchar(10) DEFAULT NULL,
  `es_ext_bd_ver` varchar(10) DEFAULT NULL,
  `outdoor_ts_ver` varchar(10) DEFAULT NULL,
  `indoor_ts_ver` varchar(10) DEFAULT NULL,
  `colds_0_ts_ver` varchar(10) DEFAULT NULL,
  `colds_1_ts_ver` varchar(10) DEFAULT NULL,
  `box_1_ts_ver` varchar(10) DEFAULT NULL,
  `box_2_ts_ver` varchar(10) DEFAULT NULL,
  `up_time` int(11) DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2155 ;

-- --------------------------------------------------------

--
-- 表的结构 `restarts`
--

CREATE TABLE IF NOT EXISTS `restarts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `station_id` int(10) unsigned DEFAULT NULL,
  `esg_id` int(10) unsigned DEFAULT NULL,
  `restart_time` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name_chn` varchar(50) DEFAULT NULL,
  `authorities` binary(20) NOT NULL DEFAULT '\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- 表的结构 `roms`
--

CREATE TABLE IF NOT EXISTS `roms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(30) DEFAULT NULL,
  `size` int(10) unsigned NOT NULL DEFAULT '0',
  `num` int(4) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `name` varchar(300) DEFAULT NULL,
  `orig_name` varchar(300) DEFAULT NULL,
  `comment` text NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `recycle` tinyint(2) DEFAULT '1',
  `station_num` int(11) DEFAULT NULL COMMENT '该rom的基站数量',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=192 ;

-- --------------------------------------------------------

--
-- 表的结构 `rom_updates`
--

CREATE TABLE IF NOT EXISTS `rom_updates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `station_id` int(11) NOT NULL,
  `old_rom_id` int(11) DEFAULT NULL,
  `new_rom_id` int(11) NOT NULL,
  `part_num` smallint(6) NOT NULL,
  `start_time` datetime NOT NULL,
  `down_time` datetime DEFAULT NULL,
  `stop_time` datetime DEFAULT NULL,
  `current_part_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `finish` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1294 ;

-- --------------------------------------------------------

--
-- 表的结构 `savings`
--

CREATE TABLE IF NOT EXISTS `savings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `station_id` int(11) NOT NULL,
  `datetime` datetime NOT NULL,
  `project_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `building_type` tinyint(1) NOT NULL,
  `total_load` tinyint(1) NOT NULL,
  `station_type` int(11) NOT NULL,
  `time_type` tinyint(1) NOT NULL,
  `saving_rate` decimal(6,4) DEFAULT NULL,
  `energy_save` decimal(10,2) DEFAULT NULL,
  `saving_func` int(11) NOT NULL,
  `error` tinyint(2) DEFAULT NULL,
  `warning` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=251545 ;

-- --------------------------------------------------------

--
-- 表的结构 `savpairdatas`
--

CREATE TABLE IF NOT EXISTS `savpairdatas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `savpair_id` int(11) NOT NULL,
  `datetime` datetime NOT NULL,
  `time_type` tinyint(1) NOT NULL,
  `sav_station_cspt` decimal(6,2) DEFAULT NULL,
  `std_station_cspt` decimal(6,2) DEFAULT NULL,
  `rate` decimal(6,4) DEFAULT NULL,
  `saving_func` tinyint(2) DEFAULT NULL,
  `error` tinyint(2) DEFAULT NULL,
  `warning` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14753 ;

-- --------------------------------------------------------

--
-- 表的结构 `savpairs`
--

CREATE TABLE IF NOT EXISTS `savpairs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datetime` datetime NOT NULL,
  `project_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `building_type` tinyint(1) NOT NULL,
  `total_load` tinyint(1) NOT NULL,
  `sav_station_id` int(11) NOT NULL,
  `std_station_id` int(11) NOT NULL,
  `save_rate` decimal(9,6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=996 ;

-- --------------------------------------------------------

--
-- 表的结构 `savtablecaches`
--

CREATE TABLE IF NOT EXISTS `savtablecaches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `city_id` smallint(6) NOT NULL,
  `datetime` datetime NOT NULL,
  `has_zhuan_saving` tinyint(1) NOT NULL DEFAULT '0',
  `has_ban_saving` tinyint(1) NOT NULL DEFAULT '0',
  `has_zhuan_common` tinyint(1) NOT NULL DEFAULT '0',
  `has_ban_common` tinyint(1) NOT NULL DEFAULT '0',
  `has_final` tinyint(1) NOT NULL DEFAULT '0',
  `zhuan_saving` text,
  `ban_saving` text,
  `zhuan_common` text,
  `ban_common` text,
  `final` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=56 ;

-- --------------------------------------------------------

--
-- 表的结构 `sav_stds`
--

CREATE TABLE IF NOT EXISTS `sav_stds` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datetime` datetime NOT NULL,
  `project_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `building_type` tinyint(1) NOT NULL,
  `total_load` tinyint(1) NOT NULL,
  `std_station_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=96 ;

-- --------------------------------------------------------

--
-- 表的结构 `sav_std_averages`
--

CREATE TABLE IF NOT EXISTS `sav_std_averages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datetime` datetime NOT NULL,
  `project_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `building_type` tinyint(1) NOT NULL,
  `total_load` tinyint(1) NOT NULL,
  `average_main_energy` decimal(11,6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=52 ;

-- --------------------------------------------------------

--
-- 表的结构 `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `station_id` int(10) unsigned NOT NULL DEFAULT '0',
  `command_id` int(10) unsigned DEFAULT NULL,
  `name` varchar(30) DEFAULT NULL,
  `type` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2206 ;

-- --------------------------------------------------------

--
-- 表的结构 `setting_items`
--

CREATE TABLE IF NOT EXISTS `setting_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `setting_id` int(10) unsigned NOT NULL DEFAULT '0',
  `type` int(4) unsigned NOT NULL DEFAULT '0',
  `value` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=37828 ;

-- --------------------------------------------------------

--
-- 表的结构 `stagroups`
--

CREATE TABLE IF NOT EXISTS `stagroups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name_chn` varchar(10) DEFAULT NULL,
  `count` int(10) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(2) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- 表的结构 `stations`
--

CREATE TABLE IF NOT EXISTS `stations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name_chn` varchar(50) DEFAULT NULL,
  `name_py` varchar(50) DEFAULT NULL,
  `bug_point` smallint(6) NOT NULL DEFAULT '0',
  `ip` varchar(16) DEFAULT NULL,
  `alive` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `comment` text NOT NULL,
  `lng` varchar(20) DEFAULT NULL,
  `lat` varchar(20) DEFAULT NULL,
  `colds_num` tinyint(2) NOT NULL DEFAULT '2',
  `total_load` tinyint(2) NOT NULL DEFAULT '0',
  `display_order` int(11) NOT NULL DEFAULT '0',
  `pic_url` varchar(200) DEFAULT NULL,
  `last_connect_time` datetime DEFAULT NULL,
  `station_type` tinyint(1) NOT NULL DEFAULT '0',
  `fan_type` tinyint(2) NOT NULL DEFAULT '0',
  `building` tinyint(2) NOT NULL DEFAULT '0',
  `colds_0_type` int(4) NOT NULL DEFAULT '0',
  `colds_1_type` int(4) NOT NULL DEFAULT '0',
  `rom_id` int(10) DEFAULT NULL,
  `city_id` int(10) DEFAULT NULL,
  `address_chn` varchar(250) NOT NULL DEFAULT '',
  `new_station_key` varchar(250) DEFAULT NULL,
  `project_id` int(10) DEFAULT NULL,
  `recycle` tinyint(1) DEFAULT '0',
  `creator_id` int(10) unsigned DEFAULT NULL,
  `create_time` datetime DEFAULT '0000-00-00 00:00:00',
  `box_type` tinyint(1) DEFAULT '1',
  `equip_with_outdoor_sensor` tinyint(1) DEFAULT '1',
  `force_on` tinyint(1) DEFAULT '1',
  `sim_num` varchar(50) DEFAULT '',
  `air_volume` tinyint(1) DEFAULT '0',
  `load_num` decimal(4,1) NOT NULL,
  `warning_priority` tinyint(1) DEFAULT '0',
  `ns` int(10) DEFAULT '0',
  `ns_start` datetime DEFAULT '2012-04-01 00:00:00',
  `standard_station_id` int(11) NOT NULL DEFAULT '0',
  `frontend_visible` tinyint(2) NOT NULL DEFAULT '1',
  `have_box` tinyint(1) DEFAULT '2',
  `stage` tinyint(2) DEFAULT '1',
  `price` decimal(5,3) DEFAULT NULL,
  `district_id` int(9) NOT NULL DEFAULT '0' COMMENT '区域id',
  `colds_0_func` tinyint(2) NOT NULL DEFAULT '0' COMMENT '空调1的控制方式：1、继电器 2、脉冲开关 3、接触器 4、红外 5、无',
  `colds_1_func` tinyint(2) NOT NULL DEFAULT '0' COMMENT '空调2的控制方式：1、继电器 2、脉冲开关 3、接触器 4、红外 5、无',
  `old_station_id` int(9) DEFAULT NULL COMMENT '专门用来记录搬迁的老基站',
  `status` tinyint(2) NOT NULL DEFAULT '4' COMMENT '基站的状态 ：1、工程安装，建站 2、工程验收 3、内部验收 4、正常运营 ..',
  `batch_id` smallint(2) DEFAULT NULL COMMENT '批次id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4054 ;

-- --------------------------------------------------------

--
-- 表的结构 `station_edges`
--

CREATE TABLE IF NOT EXISTS `station_edges` (
  `station_id` int(11) NOT NULL,
  `edge_id` int(11) NOT NULL,
  `nums` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `station_logs`
--

CREATE TABLE IF NOT EXISTS `station_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `station_id` int(11) DEFAULT NULL COMMENT '基站id',
  `creator_id` int(11) DEFAULT NULL COMMENT '修改基站信息的用户id',
  `original_content` text NOT NULL COMMENT '基站更新前的数据，以json的形式存入数据库',
  `change_content` text NOT NULL COMMENT '基站变化内容，以json的形式存入数据库',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='基站修改日志表' AUTO_INCREMENT=33 ;

-- --------------------------------------------------------

--
-- 表的结构 `station_stagroups`
--

CREATE TABLE IF NOT EXISTS `station_stagroups` (
  `station_id` int(10) unsigned NOT NULL DEFAULT '0',
  `stagroup_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`station_id`,`stagroup_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `statisticses`
--

CREATE TABLE IF NOT EXISTS `statisticses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `time` datetime NOT NULL,
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `station_id` int(10) unsigned NOT NULL,
  `main_energy` decimal(10,2) DEFAULT NULL,
  `ac_energy` decimal(10,2) DEFAULT NULL,
  `dc_energy` decimal(10,2) DEFAULT NULL,
  `colds_0_time` int(10) unsigned DEFAULT NULL,
  `colds_1_time` int(10) unsigned DEFAULT NULL,
  `fan_time` int(10) unsigned DEFAULT NULL,
  `colds_0_switch_num` int(10) unsigned DEFAULT NULL,
  `colds_1_switch_num` int(10) unsigned DEFAULT NULL,
  `fan_switch_num` int(10) unsigned DEFAULT NULL,
  `indoor_tmp_gt_time` int(10) unsigned DEFAULT NULL,
  `box_tmp_gt_time` int(10) unsigned DEFAULT NULL,
  `no_power_time` int(10) unsigned DEFAULT NULL,
  `all_off_time` int(10) unsigned DEFAULT NULL,
  `packets` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `station_type_time` (`station_id`,`type`,`time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `sysconfig`
--

CREATE TABLE IF NOT EXISTS `sysconfig` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `config_str` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- 表的结构 `temps`
--

CREATE TABLE IF NOT EXISTS `temps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(50) DEFAULT NULL,
  `value` text COMMENT '基站id的字符串',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='临时表' AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_fandaydatas`
--

CREATE TABLE IF NOT EXISTS `t_fandaydatas` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `station_id` int(10) DEFAULT NULL COMMENT '基站id',
  `fan_total` int(10) DEFAULT NULL COMMENT '新风开启的条数',
  `data_total` int(10) DEFAULT NULL COMMENT 'datas的条数',
  `record_time` datetime DEFAULT NULL COMMENT '哪一天的',
  PRIMARY KEY (`id`),
  KEY `record_time` (`record_time`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='每日新风节能的条数' AUTO_INCREMENT=126436 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_optional_pairs`
--

CREATE TABLE IF NOT EXISTS `t_optional_pairs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `building_type` tinyint(1) NOT NULL,
  `total_load` tinyint(1) NOT NULL,
  `sav_station_id` int(11) NOT NULL,
  `std_station_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- 表的结构 `userlogs`
--

CREATE TABLE IF NOT EXISTS `userlogs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `data` text,
  `method` varchar(10) DEFAULT NULL,
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `project_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT '1',
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `last_ip` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `last_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `role_id` int(10) DEFAULT NULL,
  `current_project_id` int(10) DEFAULT NULL,
  `name_chn` varchar(50) NOT NULL DEFAULT '匿名',
  `department_id` int(10) DEFAULT NULL,
  `default_city_id` int(10) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `remark` text NOT NULL,
  `recycle` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=152 ;

-- --------------------------------------------------------

--
-- 表的结构 `user_projects`
--

CREATE TABLE IF NOT EXISTS `user_projects` (
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `project_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`project_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `warnings`
--

CREATE TABLE IF NOT EXISTS `warnings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `station_id` int(10) unsigned NOT NULL DEFAULT '0',
  `type` int(4) unsigned NOT NULL DEFAULT '0',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `finish_type` tinyint(1) NOT NULL DEFAULT '0',
  `update_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `start_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `priority` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=42407 ;

-- --------------------------------------------------------

--
-- 表的结构 `weathers`
--

CREATE TABLE IF NOT EXISTS `weathers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `city_id` int(10) unsigned DEFAULT NULL,
  `day` date NOT NULL DEFAULT '0000-00-00',
  `high_tmp` int(2) unsigned NOT NULL DEFAULT '0',
  `low_tmp` int(2) unsigned NOT NULL DEFAULT '0',
  `weather` varchar(50) DEFAULT NULL,
  `fx` varchar(50) DEFAULT NULL,
  `type` int(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22139 ;

-- --------------------------------------------------------

--
-- 表的结构 `work_orders`
--

CREATE TABLE IF NOT EXISTS `work_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `station_id` int(11) NOT NULL,
  `creator_id` int(11) NOT NULL,
  `dispatcher_id` int(11) NOT NULL,
  `creator_remark` text,
  `create_time` datetime NOT NULL,
  `confirm_time` datetime NOT NULL,
  `fix_time` datetime NOT NULL,
  `confirm_fix_time` datetime NOT NULL,
  `is_history` tinyint(3) DEFAULT '1',
  `dispatcher_remark` text,
  `third_party` tinyint(2) DEFAULT '1',
  `status` tinyint(3) DEFAULT '1',
  `is_repaired` tinyint(2) DEFAULT '1',
  `creator_repair_remark` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
