<?php


namespace App\HttpController;


use EasySwoole\EasySwoole\SysConst;
use EasySwoole\Http\AbstractInterface\Controller;
use EasySwoole\Component\Di;

class Test extends Controller
{
    public function index(){

//        $di = Di::getInstance()->get('myLog');
//        $di->console('ss');
//        var_dump($di);

//        $config = new \EasySwoole\Nsq\Config();
//        $config->setNsqdUrl(['192.168.3.67:4150']);
//        $config->setNsqlookupUrl(['192.168.3.67:4161']);
//
//        $topic  = "test";
////            $nsqlookup = new \EasySwoole\Nsq\Lookup\Nsqlookupd($config->getNsqlookupUrl());
//        $hosts = ['192.168.3.67:4150'];
//
//        foreach ($hosts as $host) {
//            $nsq = new \EasySwoole\Nsq\Nsq();
//            var_dump($nsq);
//            for ($i = 0; $i < 10; $i++) {
//                $msg = new \EasySwoole\Nsq\Message\Message();
//                $msg->setPayload("test$i");
//                $nsq->push(
//                    new \EasySwoole\Nsq\Connection\Producer($host, $config),
//                    $topic,
//                    $msg
//                );
//            }
//        }
    }
}