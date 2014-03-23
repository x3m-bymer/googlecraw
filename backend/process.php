<?php
/**
 * Created by PhpStorm.
 * User: noname
 * Date: 23.03.14
 * Time: 21:56
 */
if(!$_POST["data"]){
    echo "error";
    exit();
}

$arr = explode("\n", $_POST["data"]);
var_dump($arr);