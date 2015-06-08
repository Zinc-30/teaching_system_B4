-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2015-06-08 18:51:51
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
-- 表的结构 `teaching_homework`
--

CREATE TABLE IF NOT EXISTS `teaching_homework` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `student_id` int(11) NOT NULL,
  `addtime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comment` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `score` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `teaching_resdir`
--

CREATE TABLE IF NOT EXISTS `teaching_resdir` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `fid` int(11) NOT NULL,
  `cid` int(10) NOT NULL,
  `description` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `homework` tinyint(1) NOT NULL DEFAULT '0',
  `ddl` int(11) NOT NULL,
  `uploader` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `addtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=33 ;

--
-- 转存表中的数据 `teaching_resdir`
--

INSERT INTO `teaching_resdir` (`id`, `fid`, `cid`, `description`, `name`, `url`, `homework`, `ddl`, `uploader`, `addtime`) VALUES
(23, 0, 0, '', '英语', './Upload/英语', 0, 0, '', '2015-06-08 15:32:59'),
(24, 23, 1, '', '老师', './Upload/23/24', 0, 0, '', '2015-06-08 15:32:59');

-- --------------------------------------------------------

--
-- 表的结构 `teaching_resource`
--

CREATE TABLE IF NOT EXISTS `teaching_resource` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `fid` int(20) NOT NULL,
  `context` mediumtext COLLATE utf8_unicode_ci,
  `hits` int(6) DEFAULT NULL,
  `addtime` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='资源' AUTO_INCREMENT=21 ;

--
-- 转存表中的数据 `teaching_resource`
--

INSERT INTO `teaching_resource` (`id`, `name`, `fid`, `context`, `hits`, `addtime`) VALUES
(2, 'sad', 1, 'todo', 0, '2015-05-29 21:57:51'),
(3, 'ssad', 1, 'todo', 0, '2015-05-29 21:58:44'),
(4, '556874c881fbd.txt', 1, 'todo', 0, '2015-05-29 22:16:40'),
(5, '55689403646fb.docx', 1, NULL, 0, '2015-05-30 00:29:55'),
(6, '55689578196a5.docx', 1, NULL, 0, '2015-05-30 00:36:08'),
(7, '556897546c8fd.txt', 1, '#include <iostream>\r\n\r\nusing namespace std;\r\n\r\nint main()\r\n{\r\n    int i,j,k,l,m,n,o,p;\r\n    int step[5000000];\r\n    char line[5];\r\n    int ee[18];\r\n    int a[5000000];\r\n    ee[0]=1;\r\n    for (i=1;i<=17;i++) ee[i]=ee[i-1]*2;\r\n    for (i=1;i<=4;i++)\r\n    {\r\n        for (j=1;j<=4;j++)\r\n        {\r\n            cin>>line[j];\r\n            if (line[j]==''w'') k=k+ee[(i-1)*4+j];\r\n        }\r\n    }\r\n    int now,next,up,down,left,right;\r\n    a[0]=k;step[1]=1;now=0;next=1;\r\n    do\r\n    {\r\n        for (i=1;i<=16;i++)\r\n            if (a[now]&ee[i]==0)\r\n            {\r\n                k=a[now];\r\n                k=k+ee[i];\r\n                if (i+4<=16) k=k^ee[i+4];\r\n                if (i-4>0) k=k^ee[i-4];\r\n                if (i%4!=0) k=k^ee[i+1];\r\n                if (i%4!=1) k=k^ee[i-1];\r\n                a[next]=k;\r\n                step[next]=step[now]+1;\r\n                if ((k==0)||(k==ee[17])) {cout<<step[next];return 0;}\r\n                next=next+1;\r\n            }\r\n        now=now+1;\r\n    } while (next>4500000);\r\n    cout<<"Impossible";\r\n    return 0;\r\n}\r\n', 0, '2015-05-30 00:44:04'),
(8, '556ba996467d1.txt', 1, '5', 0, '2015-06-01 08:38:46'),
(9, '5573007e3605a.txt', 1, '5', 0, '2015-06-06 22:15:28'),
(10, '557300b2a52f2.txt', 1, '5', 0, '2015-06-06 22:16:18'),
(11, '55730242a9ffd.txt', 1, '5', 0, '2015-06-06 22:22:58'),
(12, '557428574a352.txt', 1, '5', 0, '2015-06-07 19:17:47'),
(13, '5574e8104adf4.txt', 1, '5', 0, '2015-06-08 08:55:44'),
(14, '5_29.txt', 1, '5', 0, '2015-06-08 09:14:06'),
(15, '辛浩.txt', 1, '0', 0, '2015-06-08 09:23:36'),
(16, '辛浩.txt', 1, '', 0, '2015-06-08 09:26:01'),
(17, '心意.txt', 1, '5月党支部会议\r\n请假：夏立伟，王禹杰\r\n\r\n总之会内容：\r\n	1.万博同学，手续审核。\r\n	2.五好党支部。\r\n	3.学院活动，6.7号素拓活动\r\n	4.下周五，书记副书记报告会。\r\n万博发展：\r\n六月活动：马演出\r\n分享：\r\n价值多元化：\r\n	1.有市场，新闻媒体的堕落\r\n	2.国家要有包容性，但是自己的三观要有底线，不多指责别人，不如内省自己\r\n	3.适合自己，不影响他人\r\n	4.等价交换，人不能自己独自的存活\r\n\r\n贪污腐败治理\r\n	1.贪官，精神污染。\r\n	2.人性善恶，西方定义恶，东方善。\r\n	3.监狱现身说法：国企董事长，交通局局长。\r\n\r\n成为受欢迎的人：\r\n	1.无私奉献\r\n	2.榜样的力量\r\n	3.等价交换，不要忘了自己的成长（自私（对更强学习）是为了更好的无私（对弱者））\r\n\r\n最烦：不为国家家庭做贡献，只会发牢骚的。。。（负能量）', 0, '2015-06-08 09:39:19'),
(18, '2.txt', 0, '1231inasdasd', 0, '2015-06-09 00:13:20'),
(19, '2.txt', 0, '1231inasdasd', 0, '2015-06-09 00:31:45'),
(20, '2.txt', 24, '1231inasdasd', 0, '2015-06-09 00:33:29');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
