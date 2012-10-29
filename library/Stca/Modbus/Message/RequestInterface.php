<?php

namespace Stca\Modbus\Message;

interface RequestInterface extends MessageInterface
{
    // single bit access
    const READ_DISCRETE_INPUTS = 0x02;
    const READ_COILS           = 0x01;
    const WRITE_SINGLE_COIL    = 0x05;
    const WRITE_MULTIPLE_COILS = 0x0f;

    // 16 bit access
    const READ_INPUT_REGISTER    = 0x04;
    const READ_HOLDING_REGISTERS = 0x03;
    const WRITE_SINGLE_REGISTER  = 0x06;

    /**
     * Sets raw response
     *
     * @param $response
     * @return mixed
     */
    public function setRawResponse(RawResponse $response);

    /**
     * Returns raw response
     *
     * @return mixed
     */
    public function getRawResponse();

    /**
     * Validate the specified response against the current request.
     *
     * @param RawResponse $response
     * @return boolean
     */
    public function validateResponse(RawResponse $response);

    public function getResult();
}
