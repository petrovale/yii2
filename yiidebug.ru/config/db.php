<?php


  return [
      'class' => 'yii\db\Connection',
      'dsn' => 'mysql:host=localhost;dbname=yii2basic',
      'username' => 'root',
      'password' => '',
     'charset' => 'utf8',
  ];

 
 //Так как подключение к БД часто нужно в нескольких местах, распространённой практикой является его настройка как компонента приложения:
/**
 * return [
 *     // ...
 *     'components' => [
 *         // ...
 *         'db' => [
 *             'class' => 'yii\db\Connection',
 *             'dsn' => 'mysql:host=localhost;dbname=yii2basic',
 *             'username' => 'root',
 *             'password' => '',
 *             'charset' => 'utf8',
 *         ],
 *     ],
 *     // ...
 * ];
 */