<?php

namespace Stca\Modbus\DataType;

use InvalidArgumentException;

class Coil
{
    const ON  = 0xff00;
    const OFF = 0x0000;

    public static function assertValidCoilAddress($coil)
    {
        if ($coil < 0x0000) {
            throw new InvalidArgumentException('Invalid coil address, should be >= 0x0000');
        }

        if ($coil > 0xffff) {
            throw new InvalidArgumentException('Invalid coil address, should be <= 0xffff');
        }
    }

    public static function assertValidQuantityOfCoils($quantityOfCoils)
    {
        if ($quantityOfCoils < 1) {
            throw new InvalidArgumentException('Invalid quantity of coils, should be >= 1');
        }

        if ($quantityOfCoils > 0x7d0) {
            throw new InvalidArgumentException('Invalid quantity of coils, should be <= 0x7d0');
        }
    }

    public static function assertValidCoilValue($value)
    {
        if ($value !== self::ON && $value !== self::OFF) {
            throw new InvalidArgumentException(
                sprintf('Invalid coil value. Should be %x or %x', self::ON, self::OFF)
            );
        }
    }
}
