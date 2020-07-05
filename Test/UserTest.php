<?php


namespace Test;


use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    function testIndex()
    {
        $name = 'mjw';
        $this->assertEquals('mjw', $name);
    }
}