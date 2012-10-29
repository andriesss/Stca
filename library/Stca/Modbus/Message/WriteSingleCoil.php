<?php

namespace Stca\Modbus\Message;

use InvalidArgumentException;
use Stca\Modbus\Data\InputValidator;

/**
 * This function code is used to write a single output to either ON or OFF in a remote device. The requested ON/OFF
 * state is specified by a constant in the request data field. A value of FF 00 hex requests the output to be ON.
 * A value of 00 00 requests it to be OFF. All other values are illegal and will not affect the output. The Request
 * PDU specifies the address of the coil to be forced. Coils are addressed starting at zero. Therefore coil numbered
 * 1 is addressed as 0. The requested ON/OFF state is specified by a constant in the Coil Value field. A value of
 * 0XFF00 requests the coil to be ON. A value of 0X0000 requests the coil to be off. All other values are illegal and
 * will not affect the coil.
 */
class WriteSingleCoil extends AbstractRequest
{
    /**
     * @var int
     */
    private $coil;

    /**
     * @var boolean
     */
    private $value;

    /**
     * @param int  $slaveAddress
     * @param int  $coil
     * @param bool $value
     */
    public function __construct($slaveAddress, $coil, $value)
    {
        $this->setFunctionCode(RequestInterface::WRITE_SINGLE_COIL);
        $this->setSlaveAddress($slaveAddress);
        $this->setCoil($coil);
        $this->setValue($value);
        $this->setMessageFrame(pack('nn', $coil, $value));
    }

    /**
     * Sets coil address to write to
     *
     * @param $coil
     * @throws InvalidArgumentException
     * @return WriteSingleCoil
     */
    public function setCoil($coil)
    {
        InputValidator::assertValidAddress($coil);

        $this->coil = (int) $coil;
        return $this;
    }

    /**
     * Sets coil value
     *
     * @param $value
     * @return WriteSingleCoil
     * @throws InvalidArgumentException
     */
    public function setValue($value)
    {
        InputValidator::assertValidCoilValue($value);

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

    public function getResult()
    {
        // TODO: Implement getResult() method.
    }
}
