<?php

namespace ZendPsrLog;

use Mockery as m;

class LoggerInterfaceTest extends \PHPUnit_Framework_TestCase
{
    public function testInterfaceExtendsZendLoggerInterface()
    {
        $this->assertInstanceOf('Zend\Log\LoggerInterface', m::mock('ZendPsrLog\LoggerInterface'));
    }
}
