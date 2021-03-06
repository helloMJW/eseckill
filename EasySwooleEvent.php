<?php
namespace EasySwoole\EasySwoole;

use App\Bean\TrackerPointBean;
use App\Consumer\TrackerConsumer;
use App\Model\Sys\TrackerPointModel;
use App\Producer\Process as ProducerProcess;
use App\Consumer\Process as ConsumerProcess;
use App\Consumer\OrderConsumer;

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
use EasySwoole\AtomicLimit\AtomicLimit;

use App\Ioc\Log;
use App\Queue\TrackerQueue;



class   EasySwooleEvent implements Event
{

    public static function initialize()
    {
        // TODO: Implement initialize() method.
        date_default_timezone_set('Asia/Shanghai');


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
        //$config->setMaxObjectNum(30);
        $mysqlPool = new Connection($config);
//        $res = $mysqlPool->getClientPool()->status();
        DbManager::getInstance()->addConnection($mysqlPool);

        //REDIS
        $config = new \EasySwoole\Pool\Config();
        $redisConfig1 = new \EasySwoole\Redis\Config\RedisConfig(\EasySwoole\EasySwoole\Config::getInstance()->getConf('REDIS'));
        \EasySwoole\Pool\Manager::getInstance()->register(new \App\Pool\RedisPool($config,$redisConfig1),'redis');

        //KAFKA

        \EasySwoole\Component\Process\Manager::getInstance()->addProcess(new OrderConsumer());

        // 生产者
//        $processConfig= new \EasySwoole\Component\Process\Config();
//        $processConfig->setProcessName('kafka');
//        \EasySwoole\Component\Process\Manager::getInstance()->addProcess(new ProducerProcess());
//        $processConfig1= new \EasySwoole\Component\Process\Config();
//        $processConfig1->setProcessName('kafka2');
        // 消费者
//        \EasySwoole\Component\Process\Manager::getInstance()->addProcess(new ConsumerProcess());



//         AtomicLimit::getInstance()->addItem('default')->setMax(200);
//         AtomicLimit::getInstance()->addItem('api')->setMax(2);
//         AtomicLimit::getInstance()->enableProcessAutoRestore(ServerManager::getInstance()->getSwooleServer(),10*1000);

//         $register->add(EventRegister::onWorkerStart, function(\swoole_server $server, $workerId){

//             \EasySwoole\Component\Timer::getInstance()->loop(1 * 1000, function () {
// //                $server = new \swoole_server();
// //                $server = ServerManager::getInstance()->getSwooleServer();
// //                $workerId = $server->worker_id;
//                 $mysqlPoolStatus = DbManager::getInstance()->getConnection()->getClientPool()->status();
//                 $redisPoolStatus = \EasySwoole\Pool\Manager::getInstance()->get('redis')->status();
// //                var_dump($redisPoolStatus);
// //                var_dump($mysqlPoolStatus);
// //                var_dump(json_encode($mysqlPoolStatus));
//                 Logger::getInstance()->console("mysql pool " . json_encode($redisPoolStatus)  , false, 'DEBUG');
//             });
//         });

    }

    public static function onRequest(Request $request, Response $response): bool
    {
        // TODO: Implement onRequest() method.
        $point = PointContext::getInstance()->createStart('onRequest');
        $point->setStartArg([
            'uri'=>$request->getUri()->__toString(),
            'get'=>$request->getQueryParams()
        ]);

//        if(!AtomicLimit::isAllow('api')) {
//            $response->write(json_encode(array('code' => 400, 'result' => null, 'msg' => 'api refuse')));
//            return false;
//        }

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
//        $trackerQueue = new TrackerQueue();
//        $trackerQueue->main($tracker);
    }
}