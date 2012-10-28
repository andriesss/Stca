<?php

namespace Stca\Modbus\Message;

use InvalidArgumentException;

class WriteSingleCoil extends ReadSingleCoil
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
        $this->setFunctionCode(5);
        $this->setSlaveAddress($slaveAddress);
        $this->setCoil($register);
        $this->setValue($value);
        $this->setMessageFrame(pack('nn', $register, $value));
    }

    /**
     * Sets coil value (true = on, false = off)
     *
     * @param $value
     * @return WriteSingleCoil
     * @throws InvalidArgumentException
     */
    public function setValue($value)
    {
        if (!is_bool($value)) {
            throw new InvalidArgumentException('Value should be a boolean, got: ' . gettype($value));
        }

        $this->value = $value;
        return $this;
    }

    /**
     * Returns coil value (true = on, false = off)
     *
     * @return bool
     */
    public function getValue()
    {
        return $this->value;
    }
}
