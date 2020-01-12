<?php

$db['db_host']= 'localhost';
$db['db_user']='root';
$db['db_pass']='';
$db['db_name']= 'cms';

foreach($db as $name => $value){
    define(strtoupper($name),$value);
}

/*
echo "<pre>";
print_r($db);
echo "</pre>";
*/


$con=mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);

if($con){
    
    
}


?>