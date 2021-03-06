<?php

namespace Stca\Modbus\Message;

use Stca\Modbus\Message\Exception\InvalidArgumentException;
use Stca\Modbus\Data\InputValidator;

/**
 * This function code is used to write a single holding register in a remote device. The Request PDU specifies the
 * address of the register to be written. Registers are addressed starting at zero. Therefore register numbered 1
 * is addressed as 0. The normal response is an echo of the request, returned after the register contents have
 * been written.
 */
class WriteSingleRegister extends AbstractRequest
{
    /**
     * @var int
     */
    private $register;

    /**
     * @var int
     */
    private $value;

    /**
     * @param int  $slaveAddress
     * @param int  $register
     * @param bool $value
     */
    public function __construct($slaveAddress, $register, $value)
    {
        $this->setFunctionCode(RequestInterface::WRITE_SINGLE_REGISTER);
        $this->setSlaveAddress($slaveAddress);
        $this->setRegister($register);
        $this->setValue($value);
        $this->setMessageFrame(pack('nn', $register, $value));
    }

    /**
     * @param $register
     * @return WriteSingleRegister
     */
    public function setRegister($register)
    {
        InputValidator::assertValidAddress($register);

        $this->register = (int) $register;
        return $this;
    }

    /**
     * @return int
     */
    public function getRegister()
    {
        return $this->register;
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
        InputValidator::assertValidRegisterValue($value);

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

    public function getResult()
    {
        // todo
    }
}
