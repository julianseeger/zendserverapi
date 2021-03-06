<?php

/**
 * test case.
 */
class ProductionTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        if(DISABLE_REAL_INTERFACE === true)
            $this->markTestSkipped();
        $server = new \ZendService\ZendServerAPI\Server("prod");
        try {
            $server->clusterGetServerStatus();
        } catch(\Exception $e) {
            $this->markTestSkipped("No ZendSerer available for production testing");
        }
    }
    
    public function testAddRemoveServer()
    {
        $server = new \ZendService\ZendServerAPI\Server("prod");
        $serversList = $server->clusterGetServerStatus();
        foreach($serversList->getServerInfos() as $serverInfo)
        {
            $server->clusterRemoveServer($serverInfo->getId(), true);
        }
        
        $serversList = $server->clusterGetServerStatus();
        $this->assertEquals(array(), $serversList->getServerInfos());
        
        $server->clusterAddServer('zendserver2', 'http://192.168.2.4:10081/ZendServer', 'test', false, true);
        $serverInfo = $server->waitForStableState('zendserver2');
        $this->assertEquals("zendserver2", $serverInfo->getName());
        $this->assertEquals("OK", $serverInfo->getStatus());
    }
    
    public function testEnableDisableServer()
    {
        $server = new \ZendService\ZendServerAPI\Server("prod");
        $serversList = $server->clusterGetServerStatus();
        if($serversList->getServerInfos() === array())
            $this->markTestSkipped("No servers in the cluster - skipped enable/disable test");
        $serverInfo = $serversList->getFirst();
        
        $serverInfo = $server->clusterDisableServer($serverInfo->getId());
        $this->assertEquals("disabled", $serverInfo->getStatus());
        
        $serverInfo = $server->clusterEnableServer($serverInfo->getId());
        $serversList = $server->restartPhp(array($serverInfo->getId()));
        $serverInfo = $server->waitForStableState($serverInfo->getId());
        
        $this->assertEquals("OK", $serverInfo->getStatus());
    }
    
    public function testProdConfigurationExport()
    {
        $configuration = new \ZendService\ZendServerAPI\Configuration("example62");
        $fileInfo = $configuration->configurationExport('/var/www/zendserverapi/export');
        
        $date = gmdate('Ymd', time());
        $this->assertEquals("ZendServerConfig-".$date.".zcfg", $fileInfo->getFilename());
        
        $this->assertEquals($configuration->getExportDirectory(), $fileInfo->getPath());
        $this->assertFileExists((string)$fileInfo->getRealPath());
        unlink($fileInfo->getRealPath());
        $this->assertFileNotExists((string)$fileInfo->getRealPath());

        $fileInfo = $configuration->configurationExport('/var/www/zendserverapi/export', 'Test2.zcfg');
        $this->assertEquals("Test2.zcfg", $fileInfo->getFilename());
        
        $this->assertEquals($configuration->getExportDirectory(), $fileInfo->getPath());
        $this->assertFileExists((string)$fileInfo->getRealPath());
        unlink($fileInfo->getRealPath());
        $this->assertFileNotExists((string)$fileInfo->getRealPath());
    }
    
    public function testProdConfigImport()
    {
        $configuration = new \ZendService\ZendServerAPI\Configuration("prod");
        $serversListImport = $configuration->configurationImport('/var/www/zendserverapi/export/Test1.zcfg');
        
        $server = new \ZendService\ZendServerAPI\Server("prod");
        $server->restartPhp();
        $serversList = $server->clusterGetServerStatus();
        $serverInfo = $serversList->getFirst();
        $serverInfo = $server->waitForStableState($serverInfo->getId());
        $this->assertEquals('OK', $serverInfo->getStatus());
    }
}

