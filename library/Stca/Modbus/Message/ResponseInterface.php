<?php

namespace Stca\Modbus\Message;

interface ResponseInterface
{
    /**
     * Class constructor, inject request dependency
     *
     * @param RequestInterface $request
     */
    public function __construct(RequestInterface $request);

    /**
     * Returns request
     *
     * @return RequestInterface
     */
    public function getRequest();
}
