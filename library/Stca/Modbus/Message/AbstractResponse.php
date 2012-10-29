<?php

namespace Stca\Modbus\Message;

abstract class AbstractResponse implements ResponseInterface
{
    /**
     * @var RawResponse
     */
    private $rawResponse;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * Sets raw response
     *
     * @param RawResponse $response
     * @param RequestInterface $request
     * @return mixed
     */
    public function __construct(RawResponse $response, RequestInterface $request)
    {
        $this->rawResponse = $response;
        $this->request     = $request;

        return $this;
    }

    /**
     * Returns raw
     *
     * @return RawResponse
     */
    public function getRawResponse()
    {
        return $this->rawResponse;
    }

    /**
     * Returns request
     *
     * @return RequestInterface
     */
    public function getRequest()
    {
        return $this->request;
    }
}
