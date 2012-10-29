<?php

namespace Stca\Modbus\Data;

abstract class AbstractData
{
    /**
     * @var int
     */
    private $address;

    /**
     * @var boolean
     */
    private $value;

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
        $this->value = (bool) $value;
        return $this;
    }

    protected function getValue()
    {
        return $this->value;
    }
}
