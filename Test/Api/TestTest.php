<?php
namespace Test\Api;
use PHPUnit\Framework\TestCase;

use EasySwoole\HttpClient\HttpClient;

class TestTest extends TestCase
{
    private $baseUrl = 'http://192.168.3.67:9501';

    function testIndex()
    {
        $url = $this->baseUrl . '/Test';
        $client = new HttpClient($url);
        $response = $client->get();
        $this->assertEquals('mjw', 'mjw');
    }
}