<?php

namespace Stca\Modbus\Message;

use InvalidArgumentException;

class Response extends AbstractMessage
{
    /**
     * @var null|string
     */
    private $protocol;

    /**
     * Sets protocol identifier
     *
     * @param  string $protocol
     * @return Response
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
}
