<?php

namespace Stca\Modbus\Message;

use InvalidArgumentException;

class WriteSingleCoilRequest extends ReadSingleCoilRequest
{
    /**
     * @var boolean
     */
    private $value;

    /**
     * @param int  $slaveAddress
     * @param int  $coil
     * @param bool $value
     */
    public function __construct($slaveAddress, $coil, $value)
    {
        $this->setFunctionCode(0x5);
        $this->setSlaveAddress($slaveAddress);
        $this->setCoil($coil);
        $this->setValue($value);
        $this->setMessageFrame(pack('nn', $coil, $value));
    }

    /**
     * Sets coil value (true = on, false = off)
     *
     * @param $value
     * @return WriteSingleCoilRequest
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
