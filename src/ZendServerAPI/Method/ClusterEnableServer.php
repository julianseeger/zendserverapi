<?php
namespace ZendServerAPI\Method;

class ClusterEnableServer extends \ZendServerAPI\Method
{
    private $paramter = null;
    
    public function __construct($server)
    {
        $this->setParameter($server);
        parent::__construct();
    }
    
    function configure ()
    {
        $this->setMethod('POST');
        $this->setFunctionPath('/ZendServerManager/Api/clusterEnableServer');
        $this->setParser(new \ZendServerAPI\Mapper\ServerInfo());
    }

    private function setParameter($parameter)
    {
        $this->parameter = $parameter;
    }
    
    public function getContent()
    {
        return ("serverId=".$this->parameter);
    }
}

?>