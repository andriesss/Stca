<?php

namespace Stca\Modbus\Message;

use UnexpectedValueException;
use InvalidArgumentException;
use Stca\Modbus\Data\InputValidator;

class ReadSingleRegister extends AbstractRequest
{
    /**
     * @var int
     */
    private $register;

    /**
     * @param int $slaveAddress
     * @param int $register
     */
    public function __construct($slaveAddress, $register)
    {
        $this->setFunctionCode(RequestInterface::READ_HOLDING_REGISTERS);
        $this->setSlaveAddress($slaveAddress);
        $this->setRegister($register);
        $this->setMessageFrame(pack('nn', $register, 1));
    }

    /**
     * @param $register
     * @throws InvalidArgumentException
     * @return ReadSingleRegister
     */
    public function setRegister($register)
    {
        InputValidator::assertValidAddress($register);

        $this->register = (int) $register;
        return $this;
    }

    /**
     * Returns register address
     *
     * @return int
     */
    public function getRegister()
    {
        return $this->register;
    }

    public function getResult()
    {
        // TODO: Implement getResult() method.
    }
}
