<?php

namespace Stca\Modbus\Message;

use Stca\Modbus\Message\RequestInterface;
use Stca\Modbus\Message\Exception\UnexpectedValueException;
use Stca\Modbus\Message\Exception\IllegalFunctionCallException;
use Stca\Modbus\Message\Exception\IllegalDataAddressException;
use Stca\Modbus\Message\Exception\IllegalDataValueException;
use Stca\Modbus\Message\Exception\SlaveDeviceFailureException;
use Stca\Modbus\Message\Exception\AcknowledgeException;
use Stca\Modbus\Message\Exception\SlaveDeviceBusyException;
use Stca\Modbus\Message\Exception\MemoryParityErrorException;
use Stca\Modbus\Message\Exception\GatewayPathUnavailableException;
use Stca\Modbus\Message\Exception\GatewayTargetDeviceFailedToRespondException;

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
     * @throws IllegalFunctionCallException
     * @throws IllegalDataAddressException
     * @throws IllegalDataValueException
     * @throws SlaveDeviceFailureException
     * @throws AcknowledgeException
     * @throws SlaveDeviceBusyException
     * @throws MemoryParityErrorException
     * @throws GatewayPathUnavailableException
     * @throws GatewayTargetDeviceFailedToRespondException
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

        if ($this->getFunctionCode() !== $response->getFunctionCode()) {
            if ($this->getFunctionCode() + 0x80 == $response->getFunctionCode()) {
                $result = unpack('cexceptionCode', $response->getMessageFrame());
                switch ($result['exceptionCode']) {
                    case 0x01:
                        throw new IllegalFunctionCallException();

                    case 0x02:
                        throw new IllegalDataAddressException();

                    case 0x03:
                        throw new IllegalDataValueException();

                    case 0x04:
                        throw new SlaveDeviceFailureException();

                    case 0x05:
                        throw new AcknowledgeException();

                    case 0x06:
                        throw new SlaveDeviceBusyException();

                    case 0x08:
                        throw new MemoryParityErrorException();

                    case 0x0a:
                        throw new GatewayPathUnavailableException();

                    case 0x0b:
                        throw new GatewayTargetDeviceFailedToRespondException();
                }
            }

            throw new UnexpectedValueException(
                sprintf('Function code mismatch. Expected %s, got %s', $this->getFunctionCode(), $response->getFunctionCode())
            );
        }

        return true;
    }
}
