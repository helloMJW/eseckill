<?php


namespace App\Producer;


use Enqueue\RdKafka\RdKafkaConnectionFactory;

class OrderProducer
{

    public function main($order) {
        $connectionFactory = new RdKafkaConnectionFactory([
            'global' => [
                'group.id' => 'order',
                'metadata.broker.list' => '192.168.3.118:32772',
                'enable.auto.commit' => 'false',
            ],
            'topic' => [
                'auto.offset.reset' => 'beginning',
            ],
        ]);

        $context = $connectionFactory->createContext();

        $message = $context->createMessage('skill order message', $order);

        $topic = $context->createQueue('order');

        $context->createProducer()->send($topic, $message);
    }
}