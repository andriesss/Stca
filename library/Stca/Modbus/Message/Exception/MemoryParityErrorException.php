<?php

namespace Stca\Modbus\Message\Exception;

/**
 * Specialized use in conjunction with function codes 20 and 21 and reference type 6, to indicate that
 * the extended file area failed to pass a consistency check.
 *
 * The server (or slave) attempted to read record file, but detected a parity error in the memory. The client
 * (or master) can retry the request, but service may be required on the server (or slave) device.
 */
class MemoryParityErrorException extends \Exception implements ExceptionInterface
{}
