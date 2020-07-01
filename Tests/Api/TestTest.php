<?php
namespace Tests\Api;
use PHPUnit\Framework\TestCase;

class TestTest extends TestCase
{
    function testIndex()
    {
        $name = 'mjwa';
        $this->assertEquals('mjw', $name);
    }
}