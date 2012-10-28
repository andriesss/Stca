<?php

namespace Stca\Modbus\Message;

use InvalidArgumentException;

/**
 * This function code is used to write a single output to either ON or OFF in a remote device. The requested ON/OFF
 * state is specified by a constant in the request data field. A value of FF 00 hex requests the output to be ON.
 * A value of 00 00 requests it to be OFF. All other values are illegal and will not affect the output. The Request
 * PDU specifies the address of the coil to be forced. Coils are addressed starting at zero. Therefore coil numbered
 * 1 is addressed as 0. The requested ON/OFF state is specified by a constant in the Coil Value field. A value of
 * 0XFF00 requests the coil to be ON. A value of 0X0000 requests the coil to be off. All other values are illegal and
 * will not affect the coil.
 */
class WriteSingleCoil extends ReadSingleCoil
{
    const ON  = 0xff00;
    const OFF = 0x0000;

    /**
     * @var boolean
     */
    private $value;

    /**
     * @param int  $slaveAddress
     * @param int  $register
     * @param bool $value
     */
    public function __construct($slaveAddress, $register, $value)
    {
        $this->setFunctionCode(5);
        $this->setSlaveAddress($slaveAddress);
        $this->setCoil($register);
        $this->setValue($value);
        $this->setMessageFrame(pack('nn', $register, $value));
    }

    /**
     * Sets coil value (true = on, false = off)
     *
     * @param $value
     * @return WriteSingleCoil
     * @throws InvalidArgumentException
     */
    public function setValue($value)
    {
        if ($value !== self::ON && $value !== self::OFF) {
            throw new InvalidArgumentException('Invalid coil value. See WriteSingleCoil::OFF and WriteSingleCoil::ON');
        }

        $this->value = $value;
        return $this;
    }

    /**
     * Returns coil value
     *
     * @return bool
     */
    public function getValue()
    {
        return $this->value;
    }
}
