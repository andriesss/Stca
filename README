

<?php

class Pump
{
	private $modbus;

	public function __construct()
	{
		$this->modbus = new TcpClient('127.0.0.1');
	}

	public function shutdown()
	{
		$this->modbus->connect()->request(new WriteSingleCoil(1, 1, false));
	}

	public function start()
	{
		$this->modbus->connect()->request(new WriteSingleCoil(1, 1, true));
	}

	public function reboot()
	{
		$this->shutdown();
		$this->start();
	}
}

