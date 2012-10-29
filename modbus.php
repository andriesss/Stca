<?php

set_include_path('library');

spl_autoload_register(function($className) {
    require(str_replace('\\', '/', ltrim($className, '\\')) . '.php');
});

use Stca\Modbus\Client\Tcp as TcpClient;
use Stca\Modbus\Data\Coil;
use Stca\Modbus\Message\WriteSingleCoil;
use Stca\Modbus\Message\WriteSingleRegister;

use Stca\Modbus\Message\ReadCoils;
use Stca\Modbus\Message\ReadDiscreteInputs;
use Stca\Modbus\Message\ReadSingleRegister;

$client = new TcpClient('127.0.0.1');
//$client = new TcpClient('10.1.35.250', 10502);
$client->connect();

$request = new ReadCoils(1, 0, 9);
$response = $client->request($request);
var_dump($request->getResult()->getCoils());

//var_dump($client->request(new WriteSingleCoil(1, 1, Coil::ON)));
//var_dump($client->request(new WriteSingleRegister(1, 1, 100)));
