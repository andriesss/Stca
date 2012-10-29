<?php

namespace Stca\Modbus\Message;

interface ResponseInterface
{
    /**
     * Sets raw response
     *
     * @param RawResponse $response
     * @param RequestInterface $request
     */
    public function __construct(RawResponse $response, RequestInterface $request);

    /**
     * Returns raw
     *
     * @return RawResponse
     */
    public function getRawResponse();

    /**
     * Returns request
     *
     * @return RequestInterface
     */
    public function getRequest();
}
