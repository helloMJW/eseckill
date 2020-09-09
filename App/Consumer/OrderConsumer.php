<?php


namespace App\Consumer;

use App\Logic\MiaoshaOrderLogic;
use Enqueue\RdKafka\RdKafkaConnectionFactory;
use EasySwoole\Component\Process\AbstractProcess;

class OrderConsumer extends AbstractProcess
{
    protected function run($arg)
    {
        go(function (){
            $miaoshaOrderLogic = new MiaoshaOrderLogic();
            $groupId = uniqid('', true);
            $connectionFactory = new RdKafkaConnectionFactory([
                'global' => [
                    'group.id' => '5f575c3e8e0c48.97735624',
                    'metadata.broker.list' => '192.168.3.118:32772',
                    'enable.auto.commit' => 'false',
                ],
                'topic' => [
                    'auto.offset.reset' => 'beginning',
                ],
            ]);
            $context = $connectionFactory->createContext();
            $fooQueue = $context->createQueue('order');
            $consumer = $context->createConsumer($fooQueue);
//            $message = $consumer->receive();
//            $consumer->acknowledge($message);

            while (true) {
                $message = $consumer->receive(500);
                if($message) {
                    //TODO::消费订单消息
//                    var_dump($message->getProperty('goodsId'));
                    $miaoshaOrderLogic->save($message->getProperty('goodsId'), $message->getProperty('uid'));
                    $consumer->acknowledge($message);
                }
            }

        });
    }
}