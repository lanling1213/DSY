/*
 * 在设计需要用到的数据库中的表
 */

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for dsy_auth_group
-- ----------------------------
DROP TABLE IF EXISTS `dsy_auth_group`;
CREATE TABLE `dsy_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` char(80) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for dsy_auth_group_access
-- ----------------------------
DROP TABLE IF EXISTS `dsy_auth_group_access`;
CREATE TABLE `dsy_auth_group_access` (
  `uid` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for dsy_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `dsy_auth_rule`;
CREATE TABLE `dsy_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(80) NOT NULL DEFAULT '',
  `title` char(20) NOT NULL DEFAULT '',
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `condition` char(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for dsy_system_user
-- ----------------------------
DROP TABLE IF EXISTS `dsy_system_user`;
CREATE TABLE `dsy_system_user` (
  `id` int(12) NOT NULL,
  `stu_id` int(12) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tea_id` int(12) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for dsy_adv
-- ----------------------------
DROP TABLE IF EXISTS `dsy_adv`;
CREATE TABLE `dsy_adv` (
  `adv_id` int(11) DEFAULT NULL,
  `logo` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` text COLLATE utf8_unicode_ci,
  `des` int(5) DEFAULT NULL,
  `url` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for dsy_answer
-- ----------------------------
DROP TABLE IF EXISTS `dsy_answer`;
CREATE TABLE `dsy_answer` (
  `a_id` int(12) NOT NULL AUTO_INCREMENT,
  `q_id` int(11) DEFAULT NULL,
  `a_content` text COLLATE utf8_unicode_ci,
  `a_time` datetime DEFAULT NULL,
  `a_status` int(2) DEFAULT NULL,
  `a_stu_id` int(12) DEFAULT NULL,
  `a_tea_id` int(12) DEFAULT NULL,
  PRIMARY KEY (`a_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for dsy_barrage
-- ----------------------------
DROP TABLE IF EXISTS `dsy_barrage`;
CREATE TABLE `dsy_barrage` (
  `vi_id` int(12) NOT NULL,
  `stu_id` int(12) NOT NULL,
  `vi_time` datetime DEFAULT NULL,
  `bar_content` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`stu_id`,`vi_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for dsy_question
-- ----------------------------
DROP TABLE IF EXISTS `dsy_question`;
CREATE TABLE `dsy_question` (
  `que_id` int(12) NOT NULL AUTO_INCREMENT,
  `que_content` text COLLATE utf8_unicode_ci,
  `que_time` datetime DEFAULT NULL,
  `que_status` int(2) DEFAULT NULL,
  `vi_id` int(12) DEFAULT NULL,
  `stu_id` int(12) DEFAULT NULL,
  `ans_count` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`que_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for dsy_student
-- ----------------------------
DROP TABLE IF EXISTS `dsy_student`;
CREATE TABLE `dsy_student` (
  `stu_id` int(12) NOT NULL,
  `stu_nickname` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `stu_sex` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `stu_creat_time` datetime DEFAULT NULL,
  `stu_head_img` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `class_id` int(5) DEFAULT NULL,
  `stu_phone` int(11) DEFAULT NULL,
  `stu_city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `stu_profession` text COLLATE utf8_unicode_ci,
  `last_login_time` datetime DEFAULT NULL,
  `last_login_ip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_location` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`stu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for dsy_student_agree
-- ----------------------------
DROP TABLE IF EXISTS `dsy_student_agree`;
CREATE TABLE `dsy_student_agree` (
  `stu_id` int(12) NOT NULL,
  `vi_id` int(12) NOT NULL,
  PRIMARY KEY (`stu_id`,`vi_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for dsy_student_collect
-- ----------------------------
DROP TABLE IF EXISTS `dsy_student_collect`;
CREATE TABLE `dsy_student_collect` (
  `collect_id` int(12) NOT NULL AUTO_INCREMENT,
  `vi_id` int(12) DEFAULT NULL,
  `stu_id` int(12) DEFAULT NULL,
  `collect_time` datetime DEFAULT NULL,
  PRIMARY KEY (`collect_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for dsy_student_give
-- ----------------------------
DROP TABLE IF EXISTS `dsy_student_give`;
CREATE TABLE `dsy_student_give` (
  `give_id` int(12) NOT NULL,
  `vi_id` int(12) DEFAULT NULL,
  `give_money` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `give_time` datetime DEFAULT NULL,
  PRIMARY KEY (`give_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for dsy_student_learn
-- ----------------------------
DROP TABLE IF EXISTS `dsy_student_learn`;
CREATE TABLE `dsy_student_learn` (
  `learn_id` int(12) NOT NULL AUTO_INCREMENT,
  `stu_id` int(12) DEFAULT NULL,
  `learn_time` datetime DEFAULT NULL,
  `vi_id` int(12) DEFAULT NULL,
  `learn_percentage` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`learn_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for dsy_teacher
-- ----------------------------
DROP TABLE IF EXISTS `dsy_teacher`;
CREATE TABLE `dsy_teacher` (
  `tea_id` int(12) NOT NULL AUTO_INCREMENT,
  `tea_name` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tea_user` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tea_head_img` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_login_time` datetime DEFAULT NULL,
  `last_login_ip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_location` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tea_play_count` int(10) DEFAULT NULL,
  `tea_collect_count` int(10) DEFAULT NULL,
  `tea_thumb_count` int(10) DEFAULT NULL,
  PRIMARY KEY (`tea_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for dsy_video
-- ----------------------------
DROP TABLE IF EXISTS `dsy_video`;
CREATE TABLE `dsy_video` (
  `vi_id` int(12) NOT NULL,
  `vi_title` text COLLATE utf8_unicode_ci,
  `vi_create_time` datetime DEFAULT NULL,
  `vi_img` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `vi_play_count` int(10) DEFAULT NULL,
  `vi_link` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `vi_long` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `vi_thumb_count` int(10) DEFAULT NULL,
  `vi_collect_count` int(10) DEFAULT NULL,
  `class_id` int(5) DEFAULT NULL,
  `tea_id` int(12) DEFAULT NULL,
  `vi_notes` text COLLATE utf8_unicode_ci,
  `vi_eval_count` int(10) DEFAULT NULL,
  PRIMARY KEY (`vi_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for dsy_video_eval
-- ----------------------------
DROP TABLE IF EXISTS `dsy_video_eval`;
CREATE TABLE `dsy_video_eval` (
  `eval_id` int(12) NOT NULL AUTO_INCREMENT,
  `eval_content` text COLLATE utf8_unicode_ci,
  `eval_time` datetime DEFAULT NULL,
  `eval_number` int(5) DEFAULT NULL,
  `vi_id` int(12) DEFAULT NULL,
  PRIMARY KEY (`eval_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
