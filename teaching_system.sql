-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2015-06-22 10:03:16
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `teaching_system`
--

-- --------------------------------------------------------

--
-- 表的结构 `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `password` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `admin`
--

INSERT INTO `admin` (`id`, `name`, `create_time`, `password`) VALUES
(1, 'admin   ', '2015-06-02 13:20:11', 'admin'),
(2, 'test   ', '2015-06-02 05:20:11', 'test');

-- --------------------------------------------------------

--
-- 表的结构 `course`
--

CREATE TABLE IF NOT EXISTS `course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fid` int(11) NOT NULL COMMENT '资源目录id',
  `name` varchar(20) NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `credit` int(11) NOT NULL DEFAULT '0',
  `type` varchar(20) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- 转存表中的数据 `course`
--

INSERT INTO `course` (`id`, `fid`, `name`, `create_time`, `credit`, `type`, `description`) VALUES
(1, 0, 'math', '2015-06-03 14:08:00', 444, '数学课', NULL),
(2, 0, 'php', '2015-06-03 14:08:05', 2, 'cs课', NULL),
(3, 0, 'english', '2015-06-03 14:08:08', 100, '英语课', NULL),
(4, 0, '微积分1', '2015-06-06 07:15:08', 4, NULL, NULL),
(5, 0, '微积分2', '2015-06-06 07:15:08', 2, NULL, NULL),
(6, 0, '微积分3', '2015-06-06 07:15:39', 3, NULL, NULL),
(7, 0, '大学英语1', '2015-06-06 07:15:39', 3, NULL, NULL),
(8, 0, '工程图学', '2015-06-06 07:16:50', 2, NULL, NULL),
(9, 0, '物理实验', '2015-06-06 07:16:50', 2, NULL, NULL),
(10, 0, '常微分', '2015-06-06 07:17:09', 1, NULL, NULL),
(11, 0, '偏微分', '2015-06-06 07:17:09', 2, NULL, NULL),
(12, 0, '程序设计基础', '2015-06-06 07:18:00', 4, NULL, NULL),
(13, 0, '面向对象程序设计', '2015-06-06 07:18:00', 2, NULL, NULL),
(14, 0, '计算机网络基础', '2015-06-06 07:18:22', 2, NULL, NULL),
(15, 0, '人工智能', '2015-06-06 07:18:22', 2, NULL, NULL),
(16, 0, '数值分析', '2015-06-06 07:19:07', 3, NULL, NULL),
(17, 0, '嵌入式系统', '2015-06-06 07:19:07', 2, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `course_class`
--

CREATE TABLE IF NOT EXISTS `course_class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `fid` int(11) NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `class_info` varchar(300) DEFAULT NULL COMMENT ' 时间，地点',
  `capacity` int(11) NOT NULL COMMENT '班级可容人数',
  `certainty` int(11) NOT NULL,
  `uncertainty` int(11) NOT NULL,
  `lab` int(11) NOT NULL COMMENT '是否需要实验室',
  `campus` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `course_id` (`course_id`),
  KEY `teacher_id` (`teacher_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `course_class`
--

INSERT INTO `course_class` (`id`, `course_id`, `teacher_id`, `fid`, `create_time`, `class_info`, `capacity`, `certainty`, `uncertainty`, `lab`, `campus`) VALUES
(4, 1, 1, 0, '2015-06-02 13:11:40', '{"class_info":\n    [\n        {\n            "day":"monday",\n            "time" :[1,2,3,4],\n            "classroom":"207"\n        },\n        {\n            "day":"monday",\n            "time" :[11,12,13],\n            "classroom":"207"\n        }\n    ]\n}', 5, 5, 0, 0, ''),
(5, 2, 2, 0, '2015-06-02 13:11:40', '{"class_info":\n    [\n        {\n            "day":"friday",\n            "time" :[1,2,3,4],\n            "classroom":"207"\n        },\n        {\n            "day":"friday",\n            "time" :[11,12,13],\n            "classroom":"207"\n        }\n    ]\n}', 7, 6, 0, 0, ''),
(6, 3, 3, 0, '2015-06-02 13:11:40', '{"class_info":\n    [\n        {\n            "day":"monday",\n            "time" :[1,2],\n            "classroom":"207"\n        },\n        {\n            "day":"monday",\n            "time" :[13],\n            "classroom":"207"\n        }\n    ]\n}', 3, 4, 0, 0, ''),
(8, 2, 1, 0, '2015-06-03 13:01:50', '{"class_info":\n    [\n        {\n            "day":"monday",\n            "time" :[1,2,3,4],\n            "classroom":"207"\n        },\n        {\n            "day":"tuesday",\n            "time" :[11,12,13],\n            "classroom":"207"\n        }\n    ]\n}', 1, 3, 0, 0, '');

-- --------------------------------------------------------

--
-- 表的结构 `homework`
--

CREATE TABLE IF NOT EXISTS `homework` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fid` int(11) NOT NULL COMMENT '文件夹id',
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `student_id` int(11) NOT NULL,
  `addtime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comment` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `score` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `homework`
--

INSERT INTO `homework` (`id`, `fid`, `name`, `student_id`, `addtime`, `comment`, `score`) VALUES
(1, 0, '3.txt', 2, '2015-06-09 17:58:44', '', 0),
(2, 36, '3.txt', 2, '2015-06-09 18:04:35', '', 0),
(3, 11, 'Course2_ch2.pdf', 1, '2015-06-22 15:32:09', '', 0);

-- --------------------------------------------------------

--
-- 表的结构 `login_record`
--

CREATE TABLE IF NOT EXISTS `login_record` (
  `id` int(11) NOT NULL,
  `type` varchar(45) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='登录数据记录';

--
-- 转存表中的数据 `login_record`
--

INSERT INTO `login_record` (`id`, `type`, `time`, `ip`) VALUES
(1, 'admin', '0000-00-00 00:00:00', '0.0.0.0'),
(1, 'admin', '0000-00-00 00:00:00', '0.0.0.0'),
(1, 'admin', '0000-00-00 00:00:00', '0.0.0.0'),
(1, 'admin', '2015-06-14 11:59:22', '0.0.0.0');

-- --------------------------------------------------------

--
-- 表的结构 `resdir`
--

CREATE TABLE IF NOT EXISTS `resdir` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `fid` int(11) NOT NULL,
  `cid` int(10) NOT NULL,
  `description` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `homework` tinyint(1) NOT NULL DEFAULT '0',
  `ddl` timestamp NOT NULL,
  `uploader` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `addtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=12 ;

--
-- 转存表中的数据 `resdir`
--

INSERT INTO `resdir` (`id`, `fid`, `cid`, `description`, `name`, `url`, `homework`, `ddl`, `uploader`, `addtime`, `order`) VALUES
(1, 0, 4, '', '偏微分', './Upload/4', 0, '0000-00-00 00:00:00', '', '2015-06-22 06:26:20', 0),
(2, 1, 0, '', '数学资料', './Upload/4/数学资料', 0, '0000-00-00 00:00:00', '', '2015-06-22 06:26:24', 0),
(3, 0, 5, '', '程序设计基础', './Upload/5', 0, '0000-00-00 00:00:00', '', '2015-06-22 06:27:35', 0),
(4, 0, 6, '', '面向对象程序设计', './Upload/6', 0, '0000-00-00 00:00:00', '', '2015-06-22 06:27:40', 0),
(5, 0, 8, '', '程序设计基础', './Upload/8', 0, '0000-00-00 00:00:00', '', '2015-06-22 06:27:44', 0),
(6, 1, 0, '', 'ppt', './Upload/4/ppt', 0, '0000-00-00 00:00:00', '', '2015-06-22 06:33:59', 0),
(7, 1, 0, '', 'doc', './Upload/4/doc', 0, '0000-00-00 00:00:00', 'xin', '2015-06-22 06:36:47', 0),
(11, 1, 0, '', '1', './Upload/4/1', 1, '2015-06-25 02:50:07', 'xin', '2015-06-22 06:57:59', 0);

-- --------------------------------------------------------

--
-- 表的结构 `resource`
--

CREATE TABLE IF NOT EXISTS `resource` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `fid` int(20) NOT NULL,
  `context` mediumtext COLLATE utf8_unicode_ci,
  `hits` int(6) DEFAULT NULL,
  `addtime` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='资源' AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `resource`
--

INSERT INTO `resource` (`id`, `name`, `fid`, `context`, `hits`, `addtime`) VALUES
(2, 'lab5_3120000271_辛浩.pdf', 2, NULL, 1, '2015-06-22 14:38:26'),
(5, '3.txt', 6, 'xinhao\r\n', 0, '2015-06-22 14:39:31'),
(6, 'lab6_3120000271_辛浩.pdf', 2, NULL, 0, '2015-06-22 14:41:04'),
(7, 'lab6_3120000271_辛浩.pdf', 6, NULL, 0, '2015-06-22 14:41:26'),
(8, 'Course1_ch0-1 [兼容模式].pdf', 6, NULL, 0, '2015-06-22 14:42:17'),
(9, 'Course3_ch3-4-31_2015.pdf', 11, NULL, 0, '2015-06-22 15:14:28');

-- --------------------------------------------------------

--
-- 表的结构 `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `create_time` timestamp NULL DEFAULT NULL,
  `admission_year` int(11) NOT NULL,
  `phone` varchar(13) DEFAULT NULL,
  `major` varchar(30) DEFAULT NULL,
  `password` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- 转存表中的数据 `student`
--

INSERT INTO `student` (`id`, `name`, `create_time`, `admission_year`, `phone`, `major`, `password`) VALUES
(1, '张三', '2015-06-02 13:06:50', 2012, '12345678901', '计算机科学', '202cb962ac59075b964b07152d234b70'),
(2, '李四', '2015-06-02 13:06:50', 2012, '12345678901', '软件工程', '202cb962ac59075b964b07152d234b70'),
(3, '王五', '2015-06-02 13:06:50', 2011, '12345678901', '计算机科学', '202cb962ac59075b964b07152d234b70'),
(4, '赵六', '2015-06-02 13:06:50', 2012, '12345678901', '软件工程', '202cb962ac59075b964b07152d234b70'),
(5, '香港记者', '2015-06-02 13:06:50', 2013, '12345678901', '新闻学', '202cb962ac59075b964b07152d234b70'),
(6, '西方记者', '2015-06-02 13:06:50', 2014, '12345678901', '新闻学', '202cb962ac59075b964b07152d234b70'),
(7, '台湾记者', '2015-06-02 13:06:50', 2015, '12345678901', '中文', '202cb962ac59075b964b07152d234b70'),
(16, '华莱士', '2015-06-10 15:17:50', 2012, '911', '哲♂学', '202cb962ac59075b964b07152d234b70');

-- --------------------------------------------------------

--
-- 表的结构 `student_course`
--

CREATE TABLE IF NOT EXISTS `student_course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `course_class_id` int(11) NOT NULL,
  `confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `finished` tinyint(1) NOT NULL DEFAULT '0',
  `grade` int(11) NOT NULL COMMENT '成绩',
  PRIMARY KEY (`id`),
  KEY `student_id` (`student_id`),
  KEY `course_class_id` (`course_class_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

--
-- 转存表中的数据 `student_course`
--

INSERT INTO `student_course` (`id`, `student_id`, `course_class_id`, `confirmed`, `finished`, `grade`) VALUES
(1, 1, 4, 1, 0, 0),
(5, 2, 4, 1, 0, 0),
(7, 2, 6, 1, 0, 0),
(9, 3, 4, 1, 0, 0),
(10, 3, 5, 1, 0, 0),
(11, 3, 6, 1, 0, 0),
(13, 4, 4, 1, 0, 0),
(14, 4, 5, 1, 0, 0),
(15, 4, 6, 1, 0, 0),
(16, 4, 8, 1, 0, 0),
(17, 6, 8, 1, 0, 0),
(18, 5, 8, 1, 0, 0),
(19, 6, 5, 1, 0, 0),
(20, 5, 5, 1, 0, 0),
(21, 7, 4, 1, 0, 0),
(22, 7, 5, 1, 0, 0),
(23, 7, 6, 1, 0, 0),
(25, 2, 5, 1, 0, 0);

--
-- 触发器 `student_course`
--
DROP TRIGGER IF EXISTS `Course_Delete`;
DELIMITER //
CREATE TRIGGER `Course_Delete` AFTER DELETE ON `student_course`
 FOR EACH ROW BEGIN
    UPDATE `course_class` SET certainty=(
        SELECT count(*) 
        FROM student_course 
        WHERE student_course.course_class_id=OLD.course_class_id AND confirmed=1 AND finished=0
    ), uncertainty=(
        SELECT count(*) 
        FROM student_course 
        WHERE student_course.course_class_id=OLD.course_class_id AND confirmed=0 AND finished=0
    ) WHERE id=OLD.course_class_id;
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `Course_Insert`;
DELIMITER //
CREATE TRIGGER `Course_Insert` AFTER INSERT ON `student_course`
 FOR EACH ROW BEGIN
    UPDATE `course_class` SET certainty=(
        SELECT count(*) 
        FROM student_course 
        WHERE student_course.course_class_id=NEW.course_class_id AND confirmed=1 AND finished=0
    ), uncertainty=(
        SELECT count(*) 
        FROM student_course 
        WHERE student_course.course_class_id=NEW.course_class_id AND confirmed=0 AND finished=0
    ) WHERE id=NEW.course_class_id;
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `Course_Update`;
DELIMITER //
CREATE TRIGGER `Course_Update` AFTER UPDATE ON `student_course`
 FOR EACH ROW BEGIN
    UPDATE `course_class` SET certainty=(
        SELECT count(*) 
        FROM student_course 
        WHERE student_course.course_class_id=NEW.course_class_id AND confirmed=1 AND finished=0
    ), uncertainty=(
        SELECT count(*) 
        FROM student_course 
        WHERE student_course.course_class_id=NEW.course_class_id AND confirmed=0 AND finished=0
    ) WHERE id=NEW.course_class_id;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- 表的结构 `student_course_add`
--

CREATE TABLE IF NOT EXISTS `student_course_add` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `course_class_id` int(11) NOT NULL,
  `confirmed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `student_course_add_ibfk_1` (`student_id`),
  KEY `student_course_add_ibfk_2` (`course_class_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- 转存表中的数据 `student_course_add`
--

INSERT INTO `student_course_add` (`id`, `student_id`, `course_class_id`, `confirmed`) VALUES
(1, 5, 4, 0),
(2, 5, 6, 1),
(3, 6, 8, 1),
(4, 5, 8, 1),
(5, 6, 5, 1),
(6, 5, 5, 1),
(8, 7, 4, 1),
(9, 7, 5, 1),
(13, 7, 6, 1),
(14, 2, 5, 1);

-- --------------------------------------------------------

--
-- 表的结构 `teacher`
--

CREATE TABLE IF NOT EXISTS `teacher` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `password` varchar(128) DEFAULT NULL,
  `title` varchar(20) DEFAULT NULL,
  `phone` varchar(13) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `teacher`
--

INSERT INTO `teacher` (`id`, `name`, `create_time`, `password`, `title`, `phone`, `email`, `description`) VALUES
(1, '东方记者', '2015-06-02 12:03:41', '202cb962ac59075b964b07152d234b70', '长者', '12345678901', 'zhangzhe@zju.edu.cn', '你们呀，还要学习一个'),
(2, '西方记者', '2015-06-02 12:03:56', '202cb962ac59075b964b07152d234b70', '哲学家', '12345678901', 'hualaishi@zju.edu.cn', '比你们不知高到哪里去了'),
(3, '南方记者', '2015-06-02 12:04:07', '202cb962ac59075b964b07152d234b70', '新闻学家', '12345678901', 'north@zju.edu.cn', '不要总想弄个大新闻'),
(4, '北方记者', '2015-06-10 15:33:28', '202cb962ac59075b964b07152d234b70', NULL, '12345678900', 'south@zju.edu.cn', 'I''m angry');

-- --------------------------------------------------------

--
-- 表的结构 `timeset`
--

CREATE TABLE IF NOT EXISTS `timeset` (
  `year_id` varchar(15) NOT NULL,
  `xk1_s` date DEFAULT NULL,
  `xk1_e` date DEFAULT NULL,
  `xk2_s` date DEFAULT NULL,
  `xk2_e` date DEFAULT NULL,
  `xk3_s` date DEFAULT NULL,
  `xk3_e` date DEFAULT NULL,
  `bx1_s` date DEFAULT NULL,
  `bx1_e` date DEFAULT NULL,
  `bx2_s` date DEFAULT NULL,
  `bx2_e` date DEFAULT NULL,
  `bx3_s` date DEFAULT NULL,
  `bx3_e` date DEFAULT NULL,
  PRIMARY KEY (`year_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `timeset`
--

INSERT INTO `timeset` (`year_id`, `xk1_s`, `xk1_e`, `xk2_s`, `xk2_e`, `xk3_s`, `xk3_e`, `bx1_s`, `bx1_e`, `bx2_s`, `bx2_e`, `bx3_s`, `bx3_e`) VALUES
('2014-2015-1', '2015-06-20', '2015-06-27', '2015-09-01', '2015-09-08', '2015-09-20', '2015-09-23', '2015-07-01', '2015-07-03', '2015-09-11', '2015-09-13', '2015-09-25', '2015-09-27'),
('2014-2015-2', '2015-06-20', '2015-06-27', '2015-09-01', '2015-09-08', '2015-09-20', '2015-09-23', '2015-07-01', '2015-07-03', '2015-09-11', '2015-09-13', '2015-09-25', '2015-09-27');

--
-- 限制导出的表
--

--
-- 限制表 `course_class`
--
ALTER TABLE `course_class`
  ADD CONSTRAINT `course_class_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`),
  ADD CONSTRAINT `course_class_ibfk_2` FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`id`);

--
-- 限制表 `student_course`
--
ALTER TABLE `student_course`
  ADD CONSTRAINT `student_course_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`),
  ADD CONSTRAINT `student_course_ibfk_2` FOREIGN KEY (`course_class_id`) REFERENCES `course_class` (`id`);

--
-- 限制表 `student_course_add`
--
ALTER TABLE `student_course_add`
  ADD CONSTRAINT `student_course_add_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`),
  ADD CONSTRAINT `student_course_add_ibfk_2` FOREIGN KEY (`course_class_id`) REFERENCES `course_class` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
