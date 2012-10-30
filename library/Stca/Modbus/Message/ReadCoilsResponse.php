<?php

namespace Stca\Modbus\Message;

use Stca\Modbus\Data\Coil;
use Stca\Modbus\Message\Exception\RuntimeException;

class ReadCoilsResponse extends AbstractResponse
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
        $response = $this->getRequest()->getRawResponse();

        // use little endian byte order
        $bits = unpack('v', substr($response->getMessageFrame(), 1));
        $bits = $bits[1];

        $startingAddress = $this->getRequest()->getStartingAddress();

        for ($i = 0; $i <= $response->getByteCount() * 8; $i++) {
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
     * @throws RuntimeException
     */
    public function getRequest()
    {
        $request = parent::getRequest();
        if (!$request instanceof ReadCoils) {
            throw new RuntimeException('This error really should not occur, but its here because php does not support templates');
        }

        return $request;
    }
}
