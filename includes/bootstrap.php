<?php
declare(strict_types=1); session_start();
$f=dirname(__DIR__).'/config.php';
if(!file_exists($f)) exit('Setup: copy config.example.php to config.php and add database credentials.');
$c=require $f; define('APP_NAME',$c['app']['name']??'Maison & Co.'); define('BASE_URL',rtrim($c['app']['base_url']??'','/'));
try{$d=$c['db'];$pdo=new PDO("mysql:host={$d['host']};dbname={$d['name']};charset=utf8mb4",$d['user'],$d['pass'],[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,PDO::ATTR_EMULATE_PREPARES=>false]);}catch(Throwable $e){error_log($e->getMessage());http_response_code(500);exit('Database connection failed. Check config.php.');}
require_once __DIR__.'/functions.php';
