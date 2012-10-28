<?php

namespace Stca\Modbus\Message;

use UnexpectedValueException;
use InvalidArgumentException;

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
        $this->setFunctionCode(3);
        $this->setSlaveAddress($slaveAddress);
        $this->setRegister($register);
        $this->setMessageFrame(pack('nn', $register, 1));
    }

    /**
     * @param $register
     * @throws InvalidArgumentException
     * @return ReadSingleCoil
     */
    public function setRegister($register)
    {
        if ($register > 0xffff) {
            throw new InvalidArgumentException('Invalid register value. Should be <= 0xffff');
        }

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
