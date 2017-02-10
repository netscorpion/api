<?php

return [
    /*
    'class' => 'yii\db\Connection',
    // 'dsn' => 'oci:dbname=//192.168.10.1:1521/magicash',
    'dsn' => 'oci:dbname=//192.168.10.1:1521/magicash;charset=CL8MSWIN1251',
    
    'username' => 'magicash5',
    'password' => 'nctmagicash5',
    // 'charset' => 'AMERICAN_AMERICA.CL8MSWIN1251',
    // 'charset' => 'utf8',
    */
    'class' => 'yii\db\Connection',
    // 'dsn' => 'oci:dbname=//192.168.10.1:1521/magicash;charset=AMERICAN_AMERICA.CL8MSWIN1251', // Oracle    
    // 'dsn' => 'oci:dbname=//192.168.10.1:1521/magicash;charset=AMERICAN_AMERICA.AL32UTF8', // Oracle
    
    'dsn' => 'oci:dbname=//192.168.10.11:1521/magicash;charset=AMERICAN_AMERICA.CL8MSWIN1251', // Для Работы
    //'dsn' => 'oci:dbname=//192.168.10.11:1521/magicash;charset=utf8',  // Для GII
    'username' => 'magicash5',
    'password' => 'nctmagicash5',
    // 'charset' => 'utf8',     
    ];

