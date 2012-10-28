<?php

namespace Stca\Modbus\DataType;

use InvalidArgumentException;

class DiscreteInput
{
    const ON  = 0xff00;
    const OFF = 0x0000;

    public static function assertValidDiscreteInputAddress($coil)
    {
        if ($coil < 0x0000) {
            throw new InvalidArgumentException('Invalid discrete input address, should be >= 0x0000');
        }

        if ($coil > 0xffff) {
            throw new InvalidArgumentException('Invalid discrete input address, should be <= 0xffff');
        }
    }

    public static function assertValidQuantityOfDiscreteInputs($quantityOfInputs)
    {
        if ($quantityOfInputs < 1) {
            throw new InvalidArgumentException('Invalid quantity of discrete inputs, should be >= 1');
        }

        if ($quantityOfInputs > 0x7d0) {
            throw new InvalidArgumentException('Invalid quantity of discrete inputs, should be <= 0x7d0');
        }
    }
}
