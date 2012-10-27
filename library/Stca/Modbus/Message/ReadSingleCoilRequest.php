<?php

namespace Stca\Modbus\Message;

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
     * Composition of the slave address and protocol identifier
     *
     * @return string - 3 byte string
     */
    public function getMessageFrame()
    {
        return pack('CCn', $this->getSlaveAddress(), $this->getFunctionCode(), $this->getCoil());
    }

    /**
     * Validate the specified response against the current request.
     *
     * @param MessageInterface $response
     * @return boolean
     */
    public function validateResponse(MessageInterface $response)
    {
        // TODO: Implement validateResponse() method.
    }
}
