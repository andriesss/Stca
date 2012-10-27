<?php

namespace Stca\Modbus\Client;

use Stca\Modbus\Message\RequestInterface;
use InvalidArgumentException;

abstract class AbstractClient implements ClientInterface
{
    /**
     * @var int
     */
    private $timeout = 60;

    /**
     * @var int
     */
    private $transactionIdentifier;

    /**
     * @param int $timeout - socket timeout in seconds
     * @return Tcp
     * @throws InvalidArgumentException
     */
    protected function setTimeout($timeout)
    {
        if (!is_integer($timeout)) {
            throw new InvalidArgumentException('Invalid timeout provided. Expected integer, got ' . gettype($timeout));
        }

        if ($timeout < 1) {
            throw new InvalidArgumentException('Invalid timeout provided. Should be minimum 1 second');
        }

        $this->timeout = $timeout;

        return $this;
    }

    /**
     * Returns connection timeout in seconds
     *
     * @return int
     */
    protected function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * Generates a transaction identifier
     */
    protected function generateTransactionIdentifier()
    {
        // if transaction identifier exceeds 2 byte size, start over
        if ($this->transactionIdentifier === 0xffff) {
            $this->transactionIdentifier = 0;
        } else {
            $this->transactionIdentifier++;
        }

        return $this->transactionIdentifier;
    }

    protected function buildFrame(RequestInterface $request)
    {
        $body = pack('CC', $request->getSlaveAddress(), $request->getFunctionCode()) . $request->getMessageFrame();
        return pack('nnn', $request->getTransactionId(), $this->getProtocolIdentifier(), strlen($body)) . $body;
    }
}
