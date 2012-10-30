<?php

namespace Stca\Modbus\Message\Exception;

/**
 * Specialized use in conjunction with gateways, indicates that the gateway was unable to allocate an internal
 * communication path from the input port to the output port for processing the request. Usually means that the gateway
 * is misconfigured or overloaded.
 */
class GatewayPathUnavailableException extends \Exception implements ExceptionInterface
{}
