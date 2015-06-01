-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2015-06-01 16:06:28
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
  `supervisor_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `teaching_resdir`
--

CREATE TABLE IF NOT EXISTS `teaching_resdir` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `description` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `addtime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `teaching_resdir`
--

INSERT INTO `teaching_resdir` (`id`, `description`, `addtime`, `updatetime`, `name`) VALUES
(1, '测试目录', '2015-05-30 09:18:17', '2015-05-30 09:18:17', 'dir1'),
(2, '第二次测试目录', '2015-05-30 09:20:53', '2015-05-30 09:20:53', 'TEST'),
(3, '', '2015-05-31 09:26:40', '2015-05-31 09:26:40', 'new'),
(4, '', '2015-05-31 09:27:17', '2015-05-31 09:27:17', 'new'),
(5, '', '2015-05-31 10:46:55', '2015-05-31 10:46:55', 'dir1');

-- --------------------------------------------------------

--
-- 表的结构 `teaching_resource`
--

CREATE TABLE IF NOT EXISTS `teaching_resource` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `category` int(20) NOT NULL,
  `description` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `context` mediumtext COLLATE utf8_unicode_ci,
  `hits` int(6) DEFAULT NULL,
  `addtime` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='资源' AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `teaching_resource`
--

INSERT INTO `teaching_resource` (`id`, `name`, `category`, `description`, `context`, `hits`, `addtime`) VALUES
(2, 'sad', 1, 'test', 'todo', 0, '2015-05-29 21:57:51'),
(3, 'ssad', 1, 'test', 'todo', 0, '2015-05-29 21:58:44'),
(4, '556874c881fbd.txt', 1, '#include <iostream>\r\n\r\nusing namespace std;\r\n\r\nint main()\r\n{\r\n    int i,j,k,l,m,n,o,p;\r\n    int step[5000000];\r\n    char line[5];\r\n    int ee[18];\r\n    int a[5000000];\r\n    ee[0]=1;\r\n    for (i=1;i<=1', 'todo', 0, '2015-05-29 22:16:40'),
(5, '55689403646fb.docx', 1, '', NULL, 0, '2015-05-30 00:29:55'),
(6, '55689578196a5.docx', 1, '', NULL, 0, '2015-05-30 00:36:08'),
(7, '556897546c8fd.txt', 1, '', '#include <iostream>\r\n\r\nusing namespace std;\r\n\r\nint main()\r\n{\r\n    int i,j,k,l,m,n,o,p;\r\n    int step[5000000];\r\n    char line[5];\r\n    int ee[18];\r\n    int a[5000000];\r\n    ee[0]=1;\r\n    for (i=1;i<=17;i++) ee[i]=ee[i-1]*2;\r\n    for (i=1;i<=4;i++)\r\n    {\r\n        for (j=1;j<=4;j++)\r\n        {\r\n            cin>>line[j];\r\n            if (line[j]==''w'') k=k+ee[(i-1)*4+j];\r\n        }\r\n    }\r\n    int now,next,up,down,left,right;\r\n    a[0]=k;step[1]=1;now=0;next=1;\r\n    do\r\n    {\r\n        for (i=1;i<=16;i++)\r\n            if (a[now]&ee[i]==0)\r\n            {\r\n                k=a[now];\r\n                k=k+ee[i];\r\n                if (i+4<=16) k=k^ee[i+4];\r\n                if (i-4>0) k=k^ee[i-4];\r\n                if (i%4!=0) k=k^ee[i+1];\r\n                if (i%4!=1) k=k^ee[i-1];\r\n                a[next]=k;\r\n                step[next]=step[now]+1;\r\n                if ((k==0)||(k==ee[17])) {cout<<step[next];return 0;}\r\n                next=next+1;\r\n            }\r\n        now=now+1;\r\n    } while (next>4500000);\r\n    cout<<"Impossible";\r\n    return 0;\r\n}\r\n', 0, '2015-05-30 00:44:04'),
(8, '556ba996467d1.txt', 1, '', '5', 0, '2015-06-01 08:38:46');

-- --------------------------------------------------------

--
-- 表的结构 `teaching_workdir`
--

CREATE TABLE IF NOT EXISTS `teaching_workdir` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `deadline` datetime NOT NULL,
  `requirement` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
