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
     * Class constructor, inject request dependency
     *
     * @param RequestInterface $request
     * @return mixed
     */
    public function __construct(RequestInterface $request)
    {
        $this->request = $request;

        return $this;
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
