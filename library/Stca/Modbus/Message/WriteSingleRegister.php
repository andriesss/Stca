<?php

namespace Stca\Modbus\Message;

use InvalidArgumentException;
use Stca\Modbus\DataType\Register;

/**
 * This function code is used to write a single holding register in a remote device. The Request PDU specifies the
 * address of the register to be written. Registers are addressed starting at zero. Therefore register numbered 1
 * is addressed as 0. The normal response is an echo of the request, returned after the register contents have
 * been written.
 */
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
        $this->setFunctionCode(6);
        $this->setSlaveAddress($slaveAddress);
        $this->setRegister($register);
        $this->setValue($value);
        $this->setMessageFrame(pack('nn', $register, $value));
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
        Register::assertValidRegisterValue($value);

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
