<?php

namespace Stca\Modbus\Message;

interface RequestInterface extends MessageInterface
{
    /**
     * Validate the specified response against the current request.
     *
     * @param MessageInterface $response
     * @return boolean
     */
    public function validateResponse(MessageInterface $response);
}
