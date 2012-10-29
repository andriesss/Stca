<?php

namespace Stca\Modbus\Data;

/**
 * This type of data can be alterable by an application program.
 * It's a single bit object type that supports read-write
 */
class Coil extends AbstractData
{
    const ON  = 0xff00;
    const OFF = 0x0000;

    /**
     * @return bool
     */
    public function isOn()
    {
        return $this->getValue() == true;
    }
}
