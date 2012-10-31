# Modbus
This library allows for quick prototyping of industrial applications with modbus and PHP.
We do a lot of industrial automation at my job, and I wanted to learn more about Modbus, so I implemented a PHP client to get a better understanding of the protocol.

### Connecting to modbus using TCP

```php
<?php

use Stca\Modbus\Client\Tcp as TcpClient;

// connect to modbus
$modbus  = new TcpClient('127.0.0.1');
$modbus->connect();
```

### Read all coil values
```php
<?php

use Stca\Modbus\Message\ReadCoils;

$request = new ReadCoils(1, 0, 299);
$modbus->request($request);

// dump status of all coils
var_dump($request->getResult()->getCoils());

// dump status of coil with address 0
var_dump($request->getResult()->getCoilByAddress(1));

```


### Read all discrete inputs
```php
<?php

use Stca\Modbus\Message\ReadDiscreteInputs;

$request = new ReadDiscreteInputs(1, 0, 299);
$modbus->request($request);

// dump status of all discrete inputs
var_dump($request->getResult()->getDiscreteInputs());

// dump status of discrete input with address 0
var_dump($request->getResult()->getDiscreteInputByAddress(1));
```

### Read all holding registers
```php
<?php

use Stca\Modbus\Message\ReadHoldingRegisters;

$request = new ReadHoldingRegisters(1, 0, 299);
$modbus->request($request);

// dump status of all holding registers
var_dump($request->getResult()->getHoldingRegisters());

// dump status of  holding registers with address 0
var_dump($request->getResult()->getHoldingRegisterByAddress(1));
```

### Writing to a coil
```php
<?php

use Stca\Modbus\Message\WriteSingleCoil;
use Stca\Modbus\Data\Coil;

$request = new WriteSingleCoil(1, 0, Coil::ON);
$modbus->request($request);

$request = new WriteSingleCoil(1, 0, Coil::OFF);
$modbus->request($request);

```

### Writing to a register
```php
<?php

use Stca\Modbus\Message\WriteSingleRegister;

$request = new WriteSingleRegister(1, 0, 0xffff);
$modbus->request($request);

$request = new WriteSingleRegister(1, 2, 0xff);
$modbus->request($request);

```
