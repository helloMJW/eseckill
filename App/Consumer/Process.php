<?php


namespace App\Consumer;
error_reporting(0);
use EasySwoole\Component\Process\AbstractProcess;
use EasySwoole\EasySwoole\Logger;
use EasySwoole\Kafka\Config\ConsumerConfig;
use EasySwoole\Kafka\Kafka;

class Process extends AbstractProcess
{
    protected function run($arg)
    {

        go(function () {
//            $topic      = "test";
//            $config     = new \EasySwoole\Nsq\Config();
//            $config->setNsqdUrl(['192.168.3.67:4150']);
//            $config->setNsqlookupUrl(['192.168.3.67:4161']);
//            $nsqlookup  = new \EasySwoole\Nsq\Lookup\Nsqlookupd($config->getNsqlookupUrl());
//            $hosts      = $nsqlookup->lookupHosts($topic);
//
//            foreach ($hosts as $host) {
//                $nsq = new \EasySwoole\Nsq\Nsq();
//
//                $nsq->subscribe(
//                    new \EasySwoole\Nsq\Connection\Consumer($host, $config, $topic, 'test.consuming'),
//                    function ($item) {
//                        var_dump($item['message']);
//                    }
//                );
//            }

            $config = new ConsumerConfig();
            $config->setRefreshIntervalMs(1000);
            $config->setMetadataBrokerList('192.168.3.118:32772');
            $config->setBrokerVersion('0.9.0');
            $config->setGroupId('test');

            $config->setTopics(['easy-kafka']);
            $config->setOffsetReset('earliest');

            $kafka = new kafka($config);

            // 设置消费回调
//            $func = function ($topic, $partition, $message) {
//                var_dump($topic);
//                var_dump($partition);
//                var_dump($message);
//            };
//            $kafka->consumer()->subscribe($func);

            try{
                $func = function ($topic, $partition, $message) {
                    var_dump($topic);
                    var_dump($partition);
                    var_dump($message);
                };
                $kafka->consumer()->subscribe($func);
            } catch (\Exception $e) {
                var_dump($e->getMessage());
            }

        });
    }
}