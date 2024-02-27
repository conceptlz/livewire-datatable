<?php
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
function addApiLog($tag,$message = '')
{
    $log = new Logger('Api');
    $log->pushHandler(new StreamHandler(storage_path('logs/Api.log')), Logger::INFO);
    $log->info($tag, array($message));
}