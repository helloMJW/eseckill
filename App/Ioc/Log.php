<?php


namespace App\Ioc;


use EasySwoole\Log\Logger;

class Log extends Logger
{
    function log(?string $msg,int $logLevel = self::LOG_LEVEL_INFO,string $category = 'debug')
    {
        var_dump('loglog');
    }

    function console(?string $msg,int $logLevel = self::LOG_LEVEL_INFO,string $category = 'debug')
    {
        var_dump('console');
    }
}