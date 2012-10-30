<?php

namespace Stca\Modbus\Message;

use Stca\Modbus\Data\HoldingRegister;
use Stca\Modbus\Message\Exception\RuntimeException;

class ReadHoldingRegistersResponse extends AbstractResponse
{
    protected $result = array();

    /**
     * Class constructor, inject request dependency
     *
     * @param RequestInterface $request
     */
    public function __construct(RequestInterface $request)
    {
        parent::__construct($request);

        $this->parse();
    }

    /**
     * Returns all holding registers
     *
     * @return HoldingRegister[]
     */
    public function getHoldingRegisters()
    {
        return $this->result;
    }

    /**
     * Returns a single holding register by it's address
     *
     * @param $address
     * @return null|HoldingRegister
     */
    public function getHoldingRegisterByAddress($address)
    {
        if (!isset($this->result[$address])) {
            return null;
        }

        return $this->result[$address];
    }

    /**
     * Parses raw response
     *
     * @return array
     */
    protected function parse()
    {
        $response = $this->getRequest()->getRawResponse();

        $startingAddress = $this->getRequest()->getStartingAddress();

        // use little endian byte order
        $values = unpack('n' . $response->getByteCount() / 2, substr($response->getMessageFrame(), 1));
        foreach ($values as $registerValue) {
            $address = $startingAddress++;
            $this->result[$address] = new HoldingRegister($address, $registerValue);
        }

        return $this->result;
    }

    /**
     * @return ReadHoldingRegisters
     * @throws RuntimeException
     */
    public function getRequest()
    {
        $request = parent::getRequest();
        if (!$request instanceof ReadHoldingRegisters) {
            throw new RuntimeException('This error really should not occur, but its here because php does not support templates');
        }

        return $request;
    }
}
