# Modbus
This library allows for quick prototyping of industrial applications with modbus and PHP.
We do a lot of industrial aumation at my job, and I wanted to learn more about Modbus, so I implemented a PHP client to get a better understanding of the protocol.

## Prototyping of plc's

```php
<?php

use Stca\Modbus\Client\Tcp as TcpClient;
use Stca\Modbus\Data\Coil;
use Stca\Modbus\Message\WriteSingleCoil;
use Stca\Modbus\Message\ReadSingleRegister;

class Pump
{
    private $modbus;

    public function __construct()
    {
        $this->modbus = new TcpClient('127.0.0.1');
    }

    public function shutdown()
    {
        $this->modbus->connect()->request(new WriteSingleCoil(1, 1, Coil::OFF));
    }

    public function start()
    {
        $this->modbus->connect()->request(new WriteSingleCoil(1, 1, Coil::ON));
    }

    public function reboot()
    {
        $this->shutdown();
        $this->start();
    }

    public function getOilLevel()
    {
        return $this->modbus->connect()->request(new ReadSingleRegister(1, 1));
    }
}
