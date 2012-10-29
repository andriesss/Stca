<?php

namespace Stca\Modbus\Message;

use Stca\Modbus\Message\RequestInterface;
use UnexpectedValueException;

abstract class AbstractRequest extends AbstractMessage implements RequestInterface
{
    /**
     * @var RawResponse
     */
    private $rawResponse;

    /**
     * Sets raw response
     *
     * @param RawResponse $response
     * @return mixed
     */
    public function setRawResponse(RawResponse $response)
    {
        $this->rawResponse = $response;
        return $this;
    }

    /**
     * Returns raw
     *
     * @return RawResponse
     */
    public function getRawResponse()
    {
        return $this->rawResponse;
    }

    /**
     * Validate the specified response against the current request.
     *
     * @param RawResponse $response
     * @throws UnexpectedValueException
     * @return boolean
     */
    public function validateResponse(RawResponse $response)
    {
        if ($this->getTransactionId() !== $response->getTransactionId()) {
            throw new UnexpectedValueException(
                sprintf('Transaction id mismatch. Expected %s, got %s', $this->getTransactionId(), $response->getTransactionId())
            );
        }

        if ($this->getSlaveAddress() !== $response->getSlaveAddress()) {
            throw new UnexpectedValueException(
                sprintf('Slave address mismatch. Expected %s, got %s', $this->getSlaveAddress(), $response->getSlaveAddress())
            );
        }

        return true;
    }
}
