<?php

set_include_path('library');

spl_autoload_register(function($className) {
    require(str_replace('\\', '/', ltrim($className, '\\')) . '.php');
});

use Stca\Modbus\Client\Tcp as TcpClient;
use Stca\Modbus\Message\WriteSingleCoil;
use Stca\Modbus\Message\ReadSingleCoil;
use Stca\Modbus\Message\WriteSingleRegister;
use Stca\Modbus\Message\ReadSingleRegister;

$client = new TcpClient('127.0.0.1');
$client->connect();

var_dump($client->request(new WriteSingleCoil(1, 1, true)));
var_dump($client->request(new ReadSingleCoil(1, 1)));
var_dump($client->request(new WriteSingleRegister(1, 1, 100)));
var_dump($client->request(new ReadSingleRegister(1, 1)));
