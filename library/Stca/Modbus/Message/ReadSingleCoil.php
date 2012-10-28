<?php

namespace Stca\Modbus\Message;

use UnexpectedValueException;

class ReadSingleCoil extends AbstractMessage implements RequestInterface
{
    /**
     * @var int
     */
    private $coil;

    /**
     * @param int $slaveAddress
     * @param int $register
     */
    public function __construct($slaveAddress, $register)
    {
        $this->setFunctionCode(1);
        $this->setSlaveAddress($slaveAddress);
        $this->setCoil($register);
        $this->setMessageFrame(pack('nn', $this->getCoil(), 1));
    }

    /**
     * @param $coil
     * @return ReadSingleCoil
     */
    public function setCoil($coil)
    {
        $this->coil = (int) $coil;
        return $this;
    }

    /**
     * Returns coil address
     *
     * @return int
     */
    public function getCoil()
    {
        return $this->coil;
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
