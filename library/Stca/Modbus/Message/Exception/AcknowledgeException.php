<?php

namespace Stca\Modbus\Message\Exception;

/**
 * Specialized use in conjunction with programming commands. The server (or slave) has accepted the request
 * and is processing it, but a long duration of time will be required to do so. This response is returned to prevent
 * a timeout error from occurring in the client (or master). The client (or master) can next issue a Poll Program
 * Complete message to determine if processing is completed.
 */
class AcknowledgeException extends \Exception implements ExceptionInterface
{

}
