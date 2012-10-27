<?php

namespace Stca\Modbus\Message;

use InvalidArgumentException;

class WriteSingleRegister extends ReadSingleRegister
{
    /**
     * @var boolean
     */
    private $value;

    /**
     * @param int  $slaveAddress
     * @param int  $register
     * @param bool $value
     */
    public function __construct($slaveAddress, $register, $value)
    {
        $this->setFunctionCode(0x6);
        $this->setSlaveAddress($slaveAddress);
        $this->setRegister($register);
        $this->setValue($value);
        $this->setMessageFrame( pack('nn', $register, $value));
    }

    /**
     * Sets register value
     *
     * @param  int $value
     * @return WriteSingleRegister
     * @throws InvalidArgumentException
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Returns register value
     *
     * @return bool
     */
    public function getValue()
    {
        return $this->value;
    }
}
