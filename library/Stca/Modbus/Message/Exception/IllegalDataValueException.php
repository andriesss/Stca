<?php

namespace Stca\Modbus\Message\Exception;

/**
 * A value contained in the query data field is not an allowable value for server (or slave). This indicates a fault in
 * the structure of the remainder of a complex request, such as that the implied length is incorrect. It specifically
 * does NOT mean that a data item submitted for storage in a register has a value outside the expectation of the
 * application program, since the MODBUS protocol is unaware of the significance of any particular value of any particular
 * register
 */
class IllegalDataValueException extends \Exception implements ExceptionInterface
{}
