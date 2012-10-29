<?php

namespace Stca\Modbus\Data;

class Coil
{
    const ON  = 0xff00;
    const OFF = 0x0000;

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
     * @return bool
     */
    public function isOn()
    {
        return true;
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
}
