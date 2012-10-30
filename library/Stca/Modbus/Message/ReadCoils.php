<?php

namespace Stca\Modbus\Message;

use Stca\Modbus\Message\Exception\InvalidArgumentException;
use Stca\Modbus\Data\InputValidator;

/**
 * This function code is used to read from 1 to 2000 contiguous status of coils in a remote device. The Request PDU
 * specifies the starting address, i.e. the address of the first coil specified, and the number of coils. In the PDU
 * Coils are addressed starting at zero. Therefor coils numbered 1-16 are addressed as 0-15.
 *
 * The coils in the response message are packed as one coil per bit of the data field. Status is indicated as 1= ON
 * and 0= OFF. The LSB of the first data byte contains the output addressed in the query. The other coils follow
 * toward the high order end of this byte, and from low order to high order in subsequent bytes.
 *
 * If the returned output quantity is not a multiple of eight, the remaining bits in the final data byte will be padded
 * with zeros (toward the high order end of the byte). The Byte Count field specifies the quantity of complete bytes of
 * data.
 */
class ReadCoils extends AbstractRequest
{
    /**
     * @var int
     */
    private $startingAddress;

    /**
     * @var
     */
    private $quantityOfCoils;

    /**
     * @param $slaveAddress
     * @param $startingAddress - the address of the first coil (0x0000 to 0xffff)
     * @param $quantityOfCoils
     */
    public function __construct($slaveAddress, $startingAddress, $quantityOfCoils)
    {
        $this->setFunctionCode(RequestInterface::READ_COILS);
        $this->setSlaveAddress($slaveAddress);
        $this->setStartingAddress($startingAddress);
        $this->setQuantityOfCoils($quantityOfCoils);
        $this->setMessageFrame(pack('nn', $this->getStartingAddress(), $this->getQuantityOfCoils()));
    }

    /**
     * Sets the starting address of the first coil to read from
     *
     * @param  int $startingAddress - the address of the first coil (0x0000 to 0xffff)
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
     * Returns coil address of the first coil to read from
     *
     * @return int
     */
    public function getStartingAddress()
    {
        return $this->startingAddress;
    }

    /**
     * Sets amount of contiguous status of coils to read
     *
     * @param  int $quantityOfCoils - quantity of coils to read (0x01 to 0x7d)
     * @throws InvalidArgumentException
     * @return ReadCoils
     */
    public function setQuantityOfCoils($quantityOfCoils)
    {
        InputValidator::assertValidQuantityOfBits($quantityOfCoils);

        $this->quantityOfCoils = (int) $quantityOfCoils;
        return $this;
    }

    /**
     * Returns amount of contiguous status of coils to read
     *
     * @return int
     */
    public function getQuantityOfCoils()
    {
        return $this->quantityOfCoils;
    }

    /**
     * @return ReadCoilsResponse
     */
    public function getResult()
    {
        static $result;
        if (null === $result) {
            $result = new ReadCoilsResponse($this);
        }

        return $result;
    }
}
