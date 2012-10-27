<?php

namespace Stca\Modbus\Message;

use InvalidArgumentException;

abstract class AbstractMessage implements MessageInterface
{
    /**
     * Function code
     *
     * @var int
     */
    private $functionCode;

    /**
     * Slave address
     *
     * @var int
     */
    private $slaveAddress;

    /**
     * Binary data of message frame
     *
     * @var string
     */
    private $messageFrame;

    /**
     * Transaction identifier
     *
     * @var string
     */
    private $transactionId;

    /**
     * Sets the function code
     *
     * The function code tells the server what kind of action to perform.
     *
     * @param int $code - Max 1 byte integer
     * @throws InvalidArgumentException
     * @return AbstractMessage
     */
    public function setFunctionCode($code)
    {
        if ($code > 0xff) {
            throw new InvalidArgumentException('Invalid function code. Should be 1-byte max.');
        }

        $this->functionCode = (int) $code;
        return $this;
    }

    /**
     * Returns the function code
     *
     * The function code tells the server what kind of action to perform.
     *
     * @return int - 1 byte integer
     */
    public function getFunctionCode()
    {
        return $this->functionCode;
    }

    /**
     * Sets the address of the slave
     *
     * @param int $address
     * @throws InvalidArgumentException
     * @return AbstractMessage
     */
    public function setSlaveAddress($address)
    {
        if ($address > 0xffff) {
            throw new InvalidArgumentException('Invalid slave address. Should be 2-byte max.');
        }

        $this->slaveAddress = (int) $address;
        return $this;
    }

    /**
     * Returns the address of the slave
     *
     * @return int
     */
    public function getSlaveAddress()
    {
        return $this->slaveAddress;
    }

    /**
     * Sets the composition of the message frame
     *
     * @param string $frame - frame containing binary data
     * @return AbstractMessage
     */
    public function setMessageFrame($frame)
    {
        $this->messageFrame = $frame;
        return $this;
    }

    /**
     * Composition of the slave address and protocol identifier
     *
     * @return string
     */
    public function getMessageFrame()
    {
        return $this->messageFrame;
    }

    /**
     * Sets a unique identifier assigned to a message when using the IP protocol
     *
     * @param string $id - 2 byte
     * @throws InvalidArgumentException
     * @return AbstractMessage
     */
    public function setTransactionId($id)
    {
        if ($id > 0xffff) {
            throw new InvalidArgumentException('Invalid transaction id. Should be 2-byte max.');
        }

        $this->transactionId = (int) $id;
        return $this;
    }

    /**
     * Returns a unique identifier assigned to a message when using the IP protocol
     *
     * @return string - 2 byte string
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }
}
