<?php

if (!defined('THINK_PATH')) exit();

return array (
//ThinkPHP 配置
'DB_TYPE'       => 'mysql',
'DB_HOST'       => 'localhost',
'DB_PORT'       => '3306',
'DB_NAME'       => 'teaching_system',
'DB_USER'       => 'root',
'DB_PWD'        => '',
'DB_PREFIX'     => 'teaching_',
'DB_CHARSET'    => 'utf8',
'DISPATCH_ON'   => true,
'DEBUG_MODE'    => true,
'TMPL_CACHE_ON' => false,

//Cookie 设置，兼UCenter同步登录设置
// 'COOKIE_EXPIRE' => 3600,			// Coodie有效期
// 'COOKIE_DOMAIN' => '',			// Cookie有效域名
// 'COOKIE_PATH' => '/share/',				// Cookie路径
// 'COOKIE_PREFIX' => 'share_',				// Cookie前缀 避免冲突

// //UCenter 接口配置文件

// 'UC_CONNECT' => 'post',			// 连接 UCenter 的方式: mysql/NULL, 默认为空时为 fscoketopen()
// 									// mysql 是直接连接的数据库, 为了效率, 建议采用 mysql

// //数据库相关 (mysql 连接时, 并且没有设置 UC_DBLINK 时, 需要配置以下变量)
// //'UC_DBHOST' => '10.76.8.20',			// UCenter 数据库主机
// 'UC_DBHOST' => '10.202.68.48',			// UCenter 数据库主机
// 'UC_DBUSER' => 'qsc_usercenter',				// UCenter 数据库用户名
// 'UC_DBPW' => 'w8CfWzAp6JJB6J4u',					// UCenter 数据库密码
// 'UC_DBNAME' => 'qsc_usercenter',				// UCenter 数据库名称
// 'UC_DBCHARSET' => 'utf8',			// UCenter 数据库字符集
// 'UC_DBTABLEPRE' => 'uc_',			// UCenter 数据库表前缀

// //通信相关
// 'UC_KEY' => 'edg3B9zbvfL3H9Ve4dC32cH8h361m96067zd7ad3u7d8JeE330i3C221i3delcf7',	// 与 UCenter 的通信密钥, 要与 UCenter 保持一致
// 'UC_API' => 'http://www.qsc.zju.edu.cn/apps/qsc_user_center',	// UCenter 的 URL 地址, 在调用头像时依赖此常量
// 'UC_CHARSET' => 'utf8',						// UCenter 的字符集
// //'UC_IP' => 'localhost',
// 'UC_IP' => '10.202.68.44',								// UCenter 的 IP, 当 UC_CONNECT 为非 mysql 方式时, 并且当前应用服务器解析域名有问题时, 请设置此值
// 'UC_APPID' => 2,							// 当前应用的 ID
// 'PP_API' => 'http://www.qsc.zju.edu.cn/app/passport/',
);

?>