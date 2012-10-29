<?php

namespace Stca\Modbus\Message;

use Stca\Modbus\Data\DiscreteInput;

class ReadDiscreteInputsResponse extends AbstractResponse
{
    protected $result = array();

    /**
     * @param RawResponse      $response
     * @param RequestInterface $request
     */
    public function __construct(RawResponse $response, RequestInterface $request)
    {
        parent::__construct($response, $request);

        $this->parse();
    }

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
     * Parses raw response
     *
     * @return array
     */
    protected function parse()
    {
        $frame = $this->getRawResponse()->getMessageFrame();
        $byteCount = ord(substr($frame, 0, 1));

        // use little endian byte order
        $bits = unpack('v', substr($frame, 1));
        $bits = $bits[1];

        $startingAddress = $this->getRequest()->getStartingAddress();

        for ($i = 0; $i <= $byteCount * 8; $i++) {
            if ($i == $this->getRequest()->getQuantityOfInputs()) {
                break;
            }

            $address = $startingAddress++;
            $this->result[$address] = new DiscreteInput($address,  ($bits & (1 << $i)) !== 0);
        }

        return $this->result;
    }

    /**
     * @return ReadDiscreteInputs
     * @throws \RuntimeException
     */
    public function getRequest()
    {
        $request = parent::getRequest();
        if (!$request instanceof ReadDiscreteInputs) {
            throw new \RuntimeException('This error really should not occur, but its here because php does not support templates');
        }

        return $request;
    }
}
