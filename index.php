<?php

//ini_set('display_errors', true);error_reporting(E_ALL ^ E_NOTICE);

spl_autoload_register(function ($class_name) {
    include 'classes/'.$class_name . '.class.php';
});

                       
$result = (new Solver())->solve("sample.in","<br>"); //_filename_,_separator_

echo $result;

?>
