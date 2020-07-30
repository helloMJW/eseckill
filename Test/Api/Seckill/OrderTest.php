<?php

namespace Test\Api\Seckill;

use EasySwoole\HttpClient\HttpClient;
use Test\Api\Base;

class OrderTest extends Base
{
    function testIndex()
    {
        $url = $this->baseUrl . '/GoodsTest/Detail?id=1';
        $client = new HttpClient($url);
        $response = $client->get();
        $this->assertEquals('mjw', 'mjw');
    }
}