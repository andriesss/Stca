<?php

namespace Stca\Modbus\Message;

use UnexpectedValueException;
use InvalidArgumentException;
use Stca\Modbus\Data\InputValidator;

class ReadHoldingRegisters extends AbstractRequest
{
    /**
     * @var int
     */
    private $startingAddress;

    /**
     * @var
     */
    private $quantityOfRegisters;

    /**
     * @param int $slaveAddress
     * @param int $startingAddress
     * @param int $quantityOfRegisters
     */
    public function __construct($slaveAddress, $startingAddress, $quantityOfRegisters)
    {
        $this->setFunctionCode(RequestInterface::READ_HOLDING_REGISTERS);
        $this->setSlaveAddress($slaveAddress);
        $this->setStartingAddress($startingAddress);
        $this->setQuantityOfRegisters($quantityOfRegisters);
        $this->setMessageFrame(pack('nn', $startingAddress, $quantityOfRegisters));
    }


    /**
     * @param $startingAddress
     * @throws InvalidArgumentException
     * @return ReadHoldingRegisters
     */
    public function setStartingAddress($startingAddress)
    {
        InputValidator::assertValidAddress($startingAddress);

        $this->startingAddress = (int) $startingAddress;
        return $this;
    }

    /**
     * Returns coil address
     *
     * @return int
     */
    public function getStartingAddress()
    {
        return $this->startingAddress;
    }

    /**
     * Sets amount of contiguous status of holding registers to read
     *
     * @param $quantityOfCoils
     * @throws InvalidArgumentException
     * @return ReadCoils
     */
    public function setQuantityOfRegisters($quantityOfCoils)
    {
        InputValidator::assertValidQuantityOfRegisters($quantityOfCoils);

        $this->quantityOfRegisters = (int) $quantityOfCoils;
        return $this;
    }

    /**
     * Returns amount of contiguous status of holding registers to read
     *
     * @return int
     */
    public function getQuantityOfRegisters()
    {
        return $this->quantityOfRegisters;
    }

    /**
     * @return ReadHoldingRegistersResponse
     */
    public function getResult()
    {
        static $result;
        if (null === $result) {
            $result = new ReadHoldingRegistersResponse($this->getRawResponse(), $this);
        }

        return $result;
    }
}
