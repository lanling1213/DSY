<?php
return array(

    //数据库设置
    'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_HOST'   => '127.0.0.1', // 服务器地址
    'DB_NAME'   => 'dsy', // 数据库名
    'DB_USER'   => 'root', // 用户名
    'DB_PWD'    => '', // 密码
    'DB_PORT'   => '3306', // 端口
    'DB_PREFIX' => 'dsy_', // 数据库表前缀

    /* SESSION设置 */
    'SESSION_AUTO_START' => false, // 是否自动开启Session
    'SESSION_OPTIONS'    => array(), // session 配置数组 支持type name id path expire domain 等参数
    'SESSION_TYPE'       => '', // session hander类型 默认无需设置 除非扩展了session hander驱动
    'SESSION_PREFIX'     => 'DSY', // session 前缀

    'DEFAULT_MODULE'     => 'V1', // 默认模块
    'DEFAULT_CONTROLLER' =>  'Index', // 默认控制器名称
    'DEFAULT_ACTION'      =>  'index', // 默认操作名称

    /*URL_MODEL*/
    'URL_MODEL'          => 2,
    'URL_HTML_SUFFIX'   => '',
    'URL_PATHINFO_DEPR' => '/',
    'URL_ROUTER_ON'      => true,

    // 配置邮件发送服务器
    'MAIL_HOST' =>'smtp.163.com',//smtp服务器的名称
    'MAIL_SMTPAUTH' =>TRUE, //启用smtp认证
    'MAIL_USERNAME' =>'lan_shiming@163.com',//你的邮箱名
    'MAIL_FROM' =>'lan_shiming@163.com',//发件人地址
    'MAIL_FROMNAME'=>'Thinkphp',//发件人姓名
    'MAIL_PASSWORD' =>'lanling661256',//邮箱密码
    'MAIL_CHARSET' =>'utf-8',//设置邮件编码
    'MAIL_ISHTML' =>TRUE, // 是否HTML格式邮件
);