<?php

namespace Stca\Modbus\Message;

interface RequestInterface extends MessageInterface
{
    /**
     * Validate the specified response against the current request.
     *
     * @param ResponseMessage $response
     * @return boolean
     */
    public function validateResponse(ResponseMessage $response);
}
