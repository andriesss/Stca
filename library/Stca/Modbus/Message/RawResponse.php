<?php

namespace Stca\Modbus\Message;

use Stca\Modbus\Message\AbstractMessage;
use InvalidArgumentException;

class RawResponse extends AbstractMessage
{
    /**
     * @var null|string
     */
    private $protocol;

    /**
     * Sets protocol identifier
     *
     * @param  string $protocol
     * @return RawResponse
     * @throws InvalidArgumentException
     */
    public function setProtocol($protocol)
    {
        if ($protocol > 0xffff) {
            throw new InvalidArgumentException('Invalid protocol. Should be 2-byte max.');
        }

        $this->protocol = (int) $protocol;

        return $this;
    }

    /**
     * Returns protocol identifier
     *
     * @return null|string
     */
    public function getProtocol()
    {
        return $this->protocol;
    }

    /**
     * Returns byte count
     *
     * This is the the total length of the data in the response
     *
     * @return int
     */
    public function getByteCount()
    {
        return ord(substr($this->getMessageFrame(), 0, 1));
    }
}
