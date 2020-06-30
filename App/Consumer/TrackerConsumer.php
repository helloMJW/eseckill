<?php


namespace App\Consumer;


use App\Model\Sys\TrackerPointModel;
use EasySwoole\Component\Process\AbstractProcess;

class TrackerConsumer extends AbstractProcess
{
    protected function run($arg)
    {

        go(function () {
            $topic      = "tracker";
            $config     = new \EasySwoole\Nsq\Config();
            $config->setNsqdUrl(['192.168.3.67:4150']);
            $config->setNsqlookupUrl(['192.168.3.67:4161']);
            $nsqlookup  = new \EasySwoole\Nsq\Lookup\Nsqlookupd($config->getNsqlookupUrl());
            $hosts      = $nsqlookup->lookupHosts($topic);

            foreach ($hosts as $host) {
                $nsq = new \EasySwoole\Nsq\Nsq();

                $nsq->subscribe(
                    new \EasySwoole\Nsq\Connection\Consumer($host, $config, $topic, 'tracker.consuming'),
                    function ($item) {
                        $trackerPointModel = new TrackerPointModel();
                        $trackerPointModel->storage(json_decode($item['message'], true));
                    }

                );
            }
        });
    }
}