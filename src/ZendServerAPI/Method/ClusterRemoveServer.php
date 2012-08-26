<?php
namespace ZendServerAPI\Method;

class ClusterRemoveServer extends \ZendServerAPI\Method
{
    function configure ()
    {
        $this->setMethod('POST');
        $this->setFunctionPath('/ZendServerManager/Api/clusterRemoveServer');
        $this->setParser(new \ZendServerAPI\Mapper\ServerInfo());
    }
}

?>