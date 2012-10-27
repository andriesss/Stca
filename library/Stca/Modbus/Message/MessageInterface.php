<?php

namespace Stca\Modbus\Message;

interface MessageInterface
{
    /**
     * Sets the function code
     *
     * The function code tells the server what kind of action to perform.
     *
     * @param int $code - 1 byte integer
     */
    public function setFunctionCode($code);

    /**
     * Returns the function code
     *
     * The function code tells the server what kind of action to perform.
     *
     * @return int - 1 byte integer
     */
    public function getFunctionCode();

    /**
     * Sets the address of the slave
     *
     * @param int $address
     */
    public function setSlaveAddress($address);

    /**
     * Returns the address of the slave
     *
     * @return int
     */
    public function getSlaveAddress();

    /**
     * Composition of the slave address and protocol identifier
     *
     * @return string - 3 byte string
     */
    public function getMessageFrame();

    /**
     * Sets a unique identifier assigned to a message when using the IP protocol
     *
     * @param string $id - 2 byte
     */
    public function setTransactionId($id);

    /**
     * Returns a unique identifier assigned to a message when using the IP protocol
     *
     * @return string - 2 byte string
     */
    public function getTransactionId();
}
