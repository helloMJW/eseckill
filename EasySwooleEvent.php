<?php
namespace EasySwoole\EasySwoole;

use App\Bean\TrackerPointBean;
use App\Consumer\TrackerConsumer;
use App\Model\Sys\TrackerPointModel;
use App\Producer\Process as ProducerProcess;
use App\Consumer\Process as ConsumerProcess;

use App\Utility\CommonUtility;
use EasySwoole\Component\Di;
use EasySwoole\EasySwoole\Swoole\EventRegister;
use EasySwoole\EasySwoole\AbstractInterface\Event;
use EasySwoole\Http\Request;
use EasySwoole\Http\Response;
use EasySwoole\ORM\Db\Connection;
use EasySwoole\ORM\DbManager;
use EasySwoole\Tracker\Point;
use EasySwoole\Tracker\PointContext;

use App\Ioc\Log;
use App\Queue\TrackerQueue;



class   EasySwooleEvent implements Event
{

    public static function initialize()
    {
        // TODO: Implement initialize() method.
        date_default_timezone_set('Asia/Shanghai');

        //Di::getInstance()->set(SysConst::TRIGGER_HANDLER, Log::class);
    }

    public static function mainServerCreate(EventRegister $register)
    {
        // TODO: Implement mainServerCreate() method.


        //热加载
        $hotReloadOptions = new \EasySwoole\HotReload\HotReloadOptions;
        $hotReload = new \EasySwoole\HotReload\HotReload($hotReloadOptions);
        $hotReloadOptions->setMonitorFolder([EASYSWOOLE_ROOT . '/App']);

        $server = ServerManager::getInstance()->getSwooleServer();
        $hotReload->attachToServer($server);

        //MYSQL
        $config = new \EasySwoole\ORM\Db\Config(Config::getInstance()->getConf('MYSQL'));
        DbManager::getInstance()->addConnection(new Connection($config));

        //REDIS
        $config = new \EasySwoole\Pool\Config();
        $redisConfig1 = new \EasySwoole\Redis\Config\RedisConfig(\EasySwoole\EasySwoole\Config::getInstance()->getConf('REDIS'));
        \EasySwoole\Pool\Manager::getInstance()->register(new \App\Pool\RedisPool($config,$redisConfig1),'redis');

        //KAFKA

        // 生产者
         // \EasySwoole\Component\Process\Manager::getInstance()->addProcess(new ProducerProcess());

        // 消费者
         \EasySwoole\Component\Process\Manager::getInstance()->addProcess(new TrackerConsumer());



    }

    public static function onRequest(Request $request, Response $response): bool
    {
        // TODO: Implement onRequest() method.
        $point = PointContext::getInstance()->createStart('onRequest');
        $point->setStartArg([
            'uri'=>$request->getUri()->__toString(),
            'get'=>$request->getQueryParams()
        ]);

        return true;
    }

    public static function afterRequest(Request $request, Response $response): void
    {
        // TODO: Implement afterAction() method.
        $point = PointContext::getInstance()->startPoint();
        $point->end();
        $array = Point::toArray($point);
        $trackerObj = new TrackerPointBean($array[0]);
        if(!$trackerObj->getProperty('isNext')) {
            $trackerObj->addProperty('isNext', 0);
        }
        if(!$trackerObj->getProperty('isNext')) {
            $trackerObj->addProperty('isNext', 0);
        }
        $tracker = $trackerObj->toArray();
        CommonUtility::UnderlineCase($tracker);

//        $trackerPointModel = new TrackerPointModel();
//        $res = $trackerPointModel->storage($tracker);

//        var_dump($tracker);
        $trackerQueue = new TrackerQueue();
        $trackerQueue->main($tracker);
    }
}