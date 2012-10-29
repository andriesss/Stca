<?php

namespace Stca\Modbus\Message;

use UnexpectedValueException;
use InvalidArgumentException;
use Stca\Modbus\Data\InputValidator;

/**
 * This function code is used to read from 1 to 2000 contiguous status of discrete inputs in a remote device. The
 * Request PDU specifies the starting address, i.e. the address of the first input specified, and the number of inputs.
 * In the PDU Discrete Inputs are addressed starting at zero. Therefore Discrete inputs numbered 1-16 are addressed
 * as 0-15.
 *
 * The discrete inputs in the response message are packed as one input per bit of the data field. Status is indicated
 * as 1= ON; 0= OFF. The LSB of the first data byte contains the input addressed in the query. The other inputs follow
 * toward the high order end of this byte, and from low order to high order in subsequent bytes.
 *
 * If the returned input quantity is not a multiple of eight, the remaining bits in the final data byte
 * will be padded with zeros (toward the high order end of the byte). The Byte Count field
 * specifies the quantity of complete bytes of data.
 */
class ReadDiscreteInputs extends AbstractMessage implements RequestInterface
{
    /**
     * @var int
     */
    private $startingAddress;

    /**
     * @var
     */
    private $quantityOfInputs;

    /**
     * @param $slaveAddress
     * @param $startingAddress
     * @param $quantityOfInputs
     */
    public function __construct($slaveAddress, $startingAddress, $quantityOfInputs)
    {
        $this->setFunctionCode(RequestInterface::READ_DISCRETE_INPUTS);
        $this->setSlaveAddress($slaveAddress);
        $this->setStartingAddress($startingAddress);
        $this->setQuantityOfInputs($quantityOfInputs);
        $this->setMessageFrame(pack('nn', $this->getStartingAddress(), $this->getQuantityOfInputs()));
    }

    /**
     * @param $startingAddress
     * @throws InvalidArgumentException
     * @return ReadCoils
     */
    public function setStartingAddress($startingAddress)
    {
        InputValidator::assertValidAddress($startingAddress);

        $this->startingAddress = (int) $startingAddress;
        return $this;
    }

    /**
     * Returns discrete input address
     *
     * @return int
     */
    public function getStartingAddress()
    {
        return $this->startingAddress;
    }

    /**
     * Sets amount of contiguous status of discrete inputs to read
     *
     * @param $quantityOfInputs
     * @throws InvalidArgumentException
     * @return ReadCoils
     */
    public function setQuantityOfInputs($quantityOfInputs)
    {
        InputValidator::assertValidQuantityOfBits($quantityOfInputs);

        $this->quantityOfInputs = (int) $quantityOfInputs;
        return $this;
    }

    /**
     * Returns amount of contiguous status of discrete inputs to read
     *
     * @return int
     */
    public function getQuantityOfInputs()
    {
        return $this->quantityOfInputs;
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
