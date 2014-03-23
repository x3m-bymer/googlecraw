<?php
/**
 * Created by PhpStorm.
 * User: noname
 * Date: 23.03.14
 * Time: 21:56
 */
require('config.php');

if(!$_POST["data"]){
    echo "error";
    exit();
}

if (!file_exists ($config['new_task_dir'])){
    $res = mkdir($config['new_task_dir'], 0777);
}
if(!res){
    echo "error create directory";
    exit();
}

$out = array(
    'dt_create' => time(),
    'data' => $_POST['data'],
    'status' => $config['new_task_dir']
);

file_put_contents("new/new_".time(), json_encode($out));

