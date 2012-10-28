<?php

namespace Stca\Modbus\DataType;

use InvalidArgumentException;

class Register
{
    public static function assertValidRegisterAddress($register)
    {
        if ($register < 0x0000) {
            throw new InvalidArgumentException('Invalid register value, should be >= 0x0000');
        }

        if ($register > 0xffff) {
            throw new InvalidArgumentException('Invalid register value, should be <= 0xffff');
        }
    }

    public static function assertValidRegisterValue($value)
    {
        if ($value > 0xffff) {
            throw new InvalidArgumentException('Invalid register value, should be <= 0xffff');
        }
    }
}
