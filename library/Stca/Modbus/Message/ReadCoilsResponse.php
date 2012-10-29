<?php

namespace Stca\Modbus\Message;

use Stca\Modbus\Data\Coil;

class ReadCoilsResponse extends AbstractResponse
{
    protected $result = array();

    public function __construct(RawResponse $response, RequestInterface $request)
    {
        parent::__construct($response, $request);

        $this->parse();
    }

    /**
     * Returns all coils
     *
     * @return Coil[]
     */
    public function getCoils()
    {
        return $this->result;
    }

    /**
     * Returns a single coil by it's address
     *
     * @param $address
     * @return null|Coil
     */
    public function getCoilByAddress($address)
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

        $bits = unpack('n', substr($frame, 1));
        $bits = $bits[1];

        $startingAddress = $this->getRequest()->getStartingAddress();

        for ($i = 0; $i <= $byteCount * 8; $i++) {
            if ($i == $this->getRequest()->getQuantityOfCoils()) {
                break;
            }

            $coilAddress = $startingAddress++;
            $this->result[$coilAddress] = new Coil($coilAddress,  ($bits & (1 << $i)) !== 0);
        }

        return $this->result;
    }

    /**
     * @return ReadCoils
     * @throws \RuntimeException
     */
    public function getRequest()
    {
        $request = parent::getRequest();
        if (!$request instanceof ReadCoils) {
            throw new \RuntimeException('This error really should not occur, but its here because php does not support templates');
        }

        return $request;
    }
}
