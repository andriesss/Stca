<?php

namespace Stca\Modbus\Data;

use Stca\Modbus\Data\Exception\InvalidArgumentException;

/**
 * There are two single byte types in modbus:
 *
 * - Coil, which can be read and written to;
 * - Discrete input, which can be read from;
 */
class InputValidator
{
    /**
     * Asserts that the given register value is valid
     *
     * A valid register value is smaller than 0xffff
     *
     * @param  int $value
     * @throws InvalidArgumentException
     */
    public static function assertValidRegisterValue($value)
    {
        if ($value > 0xffff) {
            throw new InvalidArgumentException('Invalid register value, should be <= 0xffff');
        }
    }

    /**
     * Asserts that the given address is valid
     *
     * A valid address
     *
     * @param  int $address
     * @throws InvalidArgumentException
     */
    public static function assertValidAddress($address)
    {
        if ($address < 0x0000) {
            throw new InvalidArgumentException('Invalid address, should be >= 0x0000');
        }

        if ($address > 0xffff) {
            throw new InvalidArgumentException('Invalid address, should be <= 0xffff');
        }
    }

    /**
     * Asserts that the given quantity of bits is valid
     *
     * @param  int $quantityOfBits
     * @throws InvalidArgumentException
     */
    public static function assertValidQuantityOfBits($quantityOfBits)
    {
        if ($quantityOfBits < 1) {
            throw new InvalidArgumentException('Invalid quantity of bits, should be >= 1');
        }

        if ($quantityOfBits > 0x7d0) {
            throw new InvalidArgumentException('Invalid quantity of bits, should be <= 0x7d0');
        }
    }

    /**
     * Asserts that the given quantity of registers is valid
     *
     * @param  int $quantityOfRegisters
     * @throws InvalidArgumentException
     */
    public static function assertValidQuantityOfRegisters($quantityOfRegisters)
    {
        if ($quantityOfRegisters < 1) {
            throw new InvalidArgumentException('Invalid quantity of registers, should be >= 1');
        }

        if ($quantityOfRegisters > 0x7d) {
            throw new InvalidArgumentException('Invalid quantity of registers, should be <= 0x7d');
        }
    }

    /**
     * Asserts that the given coil value is valid
     *
     * @param  int $value
     * @throws InvalidArgumentException
     */
    public static function assertValidCoilValue($value)
    {
        if ($value !== Coil::ON && $value !== Coil::OFF) {
            throw new InvalidArgumentException(
                sprintf('Invalid coil value. Should be %x or %x', Coil::ON, Coil::OFF)
            );
        }
    }
}
