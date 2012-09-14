<?php
namespace ZendServerAPITest;
/**
 * test case.
 */
class ApplicationGetStatusTest extends \PHPUnit_Framework_TestCase
{
    public function testLink()
    {
        $method = new \ZendServerAPI\Method\ApplicationGetStatus(array(1,2));

       $this->assertEquals("/ZendServerManager/Api/applicationGetStatus?applications%5B0%5D=1&applications%5B1%5D=2", $method->getLink());
    }
}
