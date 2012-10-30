<?php

namespace Stca\Modbus\Message;

use Stca\Modbus\Data\DiscreteInput;
use Stca\Modbus\Message\Exception\RuntimeException;

class ReadDiscreteInputsResponse extends AbstractResponse
{
    /**
     * Returns all coils
     *
     * @return DiscreteInput[]
     */
    public function getDiscreteInputs()
    {
        return $this->result;
    }

    /**
     * Returns a single discrete input by it's address
     *
     * @param $address
     * @return null|DiscreteInput
     */
    public function getDiscreteInputByAddress($address)
    {
        if (!isset($this->result[$address])) {
            return null;
        }

        return $this->result[$address];
    }

    /**
     * @return ReadDiscreteInputs
     * @throws RuntimeException
     */
    public function getRequest()
    {
        $request = parent::getRequest();
        if (!$request instanceof ReadDiscreteInputs) {
            throw new RuntimeException('This error really should not occur, but its here because php does not support templates');
        }

        return $request;
    }

    /**
     * Parses raw response
     *
     * @return array
     */
    protected function parse()
    {
        $response = $this->getRequest()->getRawResponse();

        // use little endian byte order
        $bits = unpack('v', substr($response->getMessageFrame(), 1));
        $bits = $bits[1];

        $startingAddress = $this->getRequest()->getStartingAddress();

        $result = array();
        for ($i = 0; $i <= $response->getByteCount() * 8; $i++) {
            if ($i == $this->getRequest()->getQuantityOfInputs()) {
                break;
            }

            $address = $startingAddress++;
            $result[$address] = new DiscreteInput($address,  ($bits & (1 << $i)) !== 0);
        }

        return $result;
    }

}
