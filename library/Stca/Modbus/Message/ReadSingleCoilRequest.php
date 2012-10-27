<?php

namespace Stca\Modbus\Message;

use UnexpectedValueException;

class ReadSingleCoilRequest extends AbstractMessage implements RequestInterface
{
    /**
     * @var int
     */
    private $coil;

    /**
     * @param int $slaveAddress
     * @param int $coil
     */
    public function __construct($slaveAddress, $coil)
    {
        $this->setFunctionCode(0x1);
        $this->setSlaveAddress($slaveAddress);
        $this->setCoil($coil);
        $this->setMessageFrame(pack('n', $this->getCoil()));
    }

    /**
     * @param $coil
     * @return ReadSingleCoilRequest
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
     * @param ResponseMessage $response
     * @throws UnexpectedValueException
     * @return boolean
     */
    public function validateResponse(ResponseMessage $response)
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
