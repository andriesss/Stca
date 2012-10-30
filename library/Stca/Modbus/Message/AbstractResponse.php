<?php

namespace Stca\Modbus\Message;

abstract class AbstractResponse implements ResponseInterface
{
    /**
     * @var mixed
     */
    protected $result;

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
        $this->result  = $this->parse();

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

    /**
     * Implement logic to parse raw response
     *
     * @return mixed
     */
    abstract protected function parse();
}
