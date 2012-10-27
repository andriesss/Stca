<?php

namespace Stca\Modbus\Message;

use UnexpectedValueException;

class ReadSingleRegister extends AbstractMessage implements RequestInterface
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
        $this->setFunctionCode(0x3);
        $this->setSlaveAddress($slaveAddress);
        $this->setRegister($register);
        $this->setMessageFrame(pack('nn', $register, $register -1));
    }

    /**
     * @param $register
     * @return ReadSingleCoil
     */
    public function setRegister($register)
    {
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

    /**
     * Validate the specified response against the current request.
     *
     * @param Response $response
     * @throws UnexpectedValueException
     * @return boolean
     */
    public function validateResponse(Response $response)
    {
        if ($this->getTransactionId() !== $response->getTransactionId()) {
            throw new UnexpectedValueException(
                sprintf('Transaction id mismatch. Expected %s, got %s', $this->getTransactionId(), $response->getTransactionId())
            );
        }

        if ($this->getSlaveAddress() !== $response->getSlaveAddress()) {
            throw new UnexpectedValueException(
                sprintf('Slave address mismatch. Expected %s, got %s', $this->getSlaveAddress(), $response->getSlaveAddress())
            );
        }

        return true;
    }
}
