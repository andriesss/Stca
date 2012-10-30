<?php

namespace Stca\Modbus\Message\Exception;

/**
 * An unrecoverable error occurred while the server (or slave) was attempting to perform the requested action
 */
class SlaveDeviceFailureException extends \RuntimeException implements ExceptionInterface
{}
