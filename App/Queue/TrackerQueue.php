<?php


namespace App\Queue;


class TrackerQueue
{
    public function main($data)
    {
        $config = new \EasySwoole\Nsq\Config();
        $config->setNsqdUrl(['192.168.3.67:4150']);
        $config->setNsqlookupUrl(['192.168.3.67:4161']);

        $topic  = "tracker";
//            $nsqlookup = new \EasySwoole\Nsq\Lookup\Nsqlookupd($config->getNsqlookupUrl());
        $hosts = ['192.168.3.67:4150'];
//        $data [0]['id'] = 1;
//        $data [0]['name'] = 'ok ok ok';
//
//        $data [1]['id'] = 2;
//        $data [1]['name'] = 'ok ok ok 2222';
//        $data [1]['chancel'] = array('id' => 111, 'name' => 123213);

        foreach ($hosts as $host) {
            $nsq = new \EasySwoole\Nsq\Nsq();
            $msg = new \EasySwoole\Nsq\Message\Message();
//            foreach ($data as $v) {

                $msg->setPayload(json_encode($data));
                $nsq->push(
                    new \EasySwoole\Nsq\Connection\Producer($host, $config),
                    $topic,
                    $msg
                );
//            }

        }
    }
}