<?php

return array(
    
    //SAE下的共享数据库配置

    // 'DB_PREFIX'         =>  'ee_',

    // 'DB_HOST'           =>  'w.rdc.sae.sina.com.cn', // 服务器地址
    // 'DB_NAME'           =>  'app_classtest',        // 数据库名
    // 'DB_USER'           =>  'lzyoo3jx2o',    // 用户名
    // 'DB_PWD'            =>  'ik221mylmw4h1x0kyi51j32k01150hx0j4jk30xi',         // 密码
    // 'DB_PORT'           =>  3306,        // 端口


    // 'DB_PREFIX'         =>  'ee_',

    // 'DB_HOST'           =>  'dcmrwrmlsspf.mysql.sae.sina.com.cn', // 服务器地址
    // 'DB_NAME'           =>  'newer',        // 数据库名
    // 'DB_USER'           =>  'admin',    // 用户名
    // 'DB_PWD'            =>  '123456',         // 密码
    // 'DB_PORT'           =>   10008,        // 端口

    'DB_DEPLOY_TYPE'=> 1, // 设置分布式数据库支持
    'DB_RW_SEPARATE'=> true,
    'DB_TYPE'       => 'mysql', //分布式数据库类型必须相同
    'DB_HOST'       => 'dcmrwrmlsspf.mysql.sae.sina.com.cn,ndtkieffkqsq.mysql.sae.sina.com.cn,xgqjznvfcxto.mysql.sae.sina.com.cn,nvidthffpcbv.mysql.sae.sina.com.cn,hnljzbphxbej.mysql.sae.sina.com.cn,lscbaalvxqyt.mysql.sae.sina.com.cn,shlmtquapzbk.mysql.sae.sina.com.cn,fmreymmakttq.mysql.sae.sina.com.cn',
    'DB_NAME'       => 'newer', //如果相同可以不用定义多个
    'DB_USER'       => 'admin',
    'DB_PWD'        => '123456',
    'DB_PORT'       => 10008,
    'DB_PREFIX'     => 'ee_',
    );



