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

if (!file_exists ( "new" )){
    $res = mkdir("new", 0777);
}
if(!res){
    echo "error create new directory";
    exit();
}

file_put_contents("new/new_".time(), $_POST["data"]);

