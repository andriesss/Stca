<?php

namespace Stca\Modbus\Message\Exception;

/**
 * Specialized use in conjunction with programming commands. The server (or slave) is engaged in processing a
 * long–duration program command. The client (or master) should retransmit the message later when the server (or slave)
 * is free.
 */
class SlaveDeviceBusyException extends \Exception implements ExceptionInterface
{}
