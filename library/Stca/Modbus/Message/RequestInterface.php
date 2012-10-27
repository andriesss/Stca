<?php

namespace Stca\Modbus\Message;

interface RequestInterface extends MessageInterface
{
    /**
     * Validate the specified response against the current request.
     *
     * @param Response $response
     * @return boolean
     */
    public function validateResponse(Response $response);
}
