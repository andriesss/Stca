<?php

namespace Stca\Modbus\Message\Exception;

/**
 * Specialized use in conjunction with gateways, indicates that no response was obtained from the
 * target device. Usually means that the device is not present on the network.
 */
class GatewayTargetDeviceFailedToRespondException extends \Exception implements ExceptionInterface
{}
