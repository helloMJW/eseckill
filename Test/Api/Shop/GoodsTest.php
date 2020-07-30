<?php
namespace Test\Api\Seckill;

use EasySwoole\HttpClient\HttpClient;
use PHPUnit\Framework\TestCase;


class GoodsTest extends TestCase
{
    protected $baseUrl = 'http://192.168.3.67:9501';

    function testDetail()
    {
        $url = $this->baseUrl . '/goods/1';
        $client = new HttpClient($url);
        $response = $client->get();
        $this->assertEquals($response->getStatusCode(), '200'); // 请求正常
        $data = $response->getBody();
        $this->assertArrayHasKey('id', json_decode($data, true)['result']);
    }
}