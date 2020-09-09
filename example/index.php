<?php

require 'config.php';
require '../src/Connection.php';
require '../src/QueryBuilder.php';
require '../src/DataSave.php';
require 'User.php';

use example\User;

$user = new User;

/**************************************
********** CREATE REGISTER ************
$newUser = [
    'name' => 'Lailson das Virgens',
    'email' => 'lailsondev@gmail.com',
    'cpf' => '06470547524',
    'phone' => '34991279379'
];

var_dump($user->save($newUser));
*************************************/

/**************************************
 ********** UPDATE REGISTER ***********
$newUser = [
'id' => 8,
'name' => 'Lailson das Virgens',
'email' => 'lailsondev@gmail.com',
'cpf' => '06470547524',
'phone' => '34991279379'
];

var_dump($user->save($newUser, 'id'));
 *************************************/

/**************************************
 ********* DESTROY REGISTER ***********

var_dump($user->destroy('id', 8));

 **************************************
 *************************************/

/**************************************
 ********* SHOW ALL REGISTER **********

var_dump($user->show());

 **************************************
 *************************************/

/**************************************
 ******** FIND BY ID REGISTER *********

var_dump($user->findById('id', 8));

 **************************************
 *************************************/