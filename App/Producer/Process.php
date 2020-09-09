<?php


namespace App\Producer;
error_reporting(0);
use EasySwoole\Component\Process\AbstractProcess;
use EasySwoole\Kafka\Config\ProducerConfig;
use EasySwoole\Kafka\Kafka;

class Process extends AbstractProcess
{
    protected function run($arg)
    {

        go(function () {
//            $config = new \EasySwoole\Nsq\Config();
//            $config->setNsqdUrl(['192.168.3.67:4150']);
//            $config->setNsqlookupUrl(['192.168.3.67:4161']);
//
//            $topic  = "my.bb";
////            $nsqlookup = new \EasySwoole\Nsq\Lookup\Nsqlookupd($config->getNsqlookupUrl());
//            $hosts = ['192.168.3.67:4150'];
//
//            foreach ($hosts as $host) {
//                $nsq = new \EasySwoole\Nsq\Nsq();
//                for ($i = 0; $i < 10; $i++) {
//                    $msg = new \EasySwoole\Nsq\Message\Message();
//                    $msg->setPayload(array($i => "test$i"));
//                    $nsq->push(
//                        new \EasySwoole\Nsq\Connection\Producer($host, $config),
//                        $topic,
//                        $msg
//                    );
//                }
//            }


            $config = new ProducerConfig();
            $config->setMetadataBrokerList('192.168.3.118:32772');
            $config->setBrokerVersion('0.9.0');
            $config->setRequiredAck(1);

            $kafka = new kafka($config);
            try {
                $result = $kafka->producer()->send([
                    [
                        'topic' => 'easy-kafka',
                        'value' => 'message--',
                        'key'   => 'key--',
                    ],
                ]);
            }catch (\Exception $e) {
                echo 'Excetion' . $e->getMessage();
            }

//
            var_dump($result);
            var_dump('ok');
        });
    }
}