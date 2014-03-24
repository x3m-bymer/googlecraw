<?php
/**
 * Created by PhpStorm.
 * User: noname
 * Date: 23.03.14
 * Time: 21:56
 */
require('config.php');

switch ($_POST['cmd']) {
    case 'clear_dir':
        echo clear_dir('./'.$config['new_task_dir'].'/');
        break ;
    case 'new_file' :
        echo new_file($_POST['data']);
        break ;
    default:
        // значение по умолчанию
        echo process_file_list($config['new_task_dir']);
}

// упрощенная функция scandir
function myscandir($dir)
{
    $list = scandir($dir);
    unset($list[0],$list[1]);
    return array_values($list);
}

// функция очищения папки
function clear_dir($dir)
{
    $list = myscandir($dir);

    foreach ($list as $file)
    {
        if (is_dir($dir.$file))
        {
            clear_dir($dir.$file.'/');
            rmdir($dir.$file);
        }
        else
        {
            unlink($dir.$file);
        }
    }
    return 'clear dir complete';
}

function process_file_list($path) //получить листинг директории
{
    $flist = '';
    foreach (glob("$path/*") as $filename) {
        $flist.= basename($filename)."\n";
    }

    return $flist;
}

function new_file($data)
{
    global $config;
    if(!$data) return "data empty";
    $out = array(
        'dt_create' => time(),
        'data' => explode("\n",$data),
        'status' => $config['new_task_dir']
    );
    if (!file_exists ($config['new_task_dir'])){
        $res = mkdir($config['new_task_dir'], 0777);
        if(!$res) return "error create directory";
    }

    file_put_contents("{$config['new_task_dir']}/new_".time().'.json', json_encode($out));
    return "ok";
}


/*if(!$_POST["data"]){
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

if($_POST["ls"]){
    echo get_flist($config['new_task_dir']);
    exit();
}

file_put_contents("{$config['new_task_dir']}/new_".time(), json_encode($out));
echo "OK";

function get_flist($path){
    $flist = '';
    foreach (glob("$path/*") as $filename) {
        $flist.= basename($filename)."\n";
    }

    return $flist;
}*/