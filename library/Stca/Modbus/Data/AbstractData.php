<?php

namespace Stca\Modbus\Data;

abstract class AbstractData
{
    /**
     * @var int
     */
    private $address;

    /**
     * @var mixed
     */
    private $value;

    /**
     * @param $address
     * @param $value
     */
    public function __construct($address, $value)
    {
        $this->setAddress($address);
        $this->setValue($value);
    }

    /**
     * @return int
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param $address
     * @return Coil
     */
    protected function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @param $value
     * @return Coil
     */
    protected function setValue($value)
    {
        $this->value = $value;
        return $this;
    }
}
