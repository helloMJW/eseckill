<?php


namespace App\Ioc;


use EasySwoole\Log\LoggerInterface;
use EasySwoole\Log\Logger;

class Log implements LoggerInterface
{

    private $logger;

    function __construct()
    {
        $this->logger = new Logger(EASYSWOOLE_LOG_DIR);
    }

    function log(?string $msg,int $logLevel = self::LOG_LEVEL_INFO,string $category = 'debug')
    {
        return $this->logger->log($msg, $logLevel, $category);
    }

    function console(?string $msg,int $logLevel = self::LOG_LEVEL_INFO,string $category = 'debug')
    {
        $this->logger->console($msg, $logLevel, $category);
    }
}