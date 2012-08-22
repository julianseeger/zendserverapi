<?php

namespace ZendServerAPI\Exception;

class ServerSide extends \Exception {
	public function __construct($error)
	{
		$xml = simplexml_load_string($error);
		$errorCode = (string)$xml->errorData->errorCode;
		$errorMessage = (string)$xml->errorData->errorMessage;
	
		parent::__construct($errorCode . ': ' . $errorMessage, 500);
	}
}

?>