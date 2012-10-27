<?php

namespace Stca\Modbus\Client;

use Stca\Modbus\Message\RequestInterface;

interface ClientInterface
{
    /**
     * Sets up connection with modbus
     *
     * @return mixed
     */
    public function connect();

    /**
     * Returns if connection to modbus is active
     *
     * @return mixed
     */
    public function isConnected();

    /**
     * Disconnects from modbus
     *
     * @return mixed
     */
    public function disconnect();

    /**
     * Sends the given request to modbus
     *
     * @param RequestInterface $request
     * @return mixed
     */
    public function request(RequestInterface $request);

    /**
     * Returns protocol identifier
     *
     * @return mixed
     */
    public function getProtocolIdentifier();
}
