<?php

namespace Stca\Modbus\Message\Exception;

/**
 * The data address received in the query is not an allowable address for the server (or slave). More specifically,
 * the combination of reference number and transfer length is invalid. For a controller with 100 registers, the PDU
 * addresses the first register as 0, and the last one as 99. If a request is submitted with a starting register address
 * of 9 and a quantity of registers of 4, then this request will successfully operate (address-wise at least)
 * on registers 96, 97, 98, 99. If a request is submitted with a starting register address of 96 and a quantity of
 * registers of 5, then this request will fail with Exception Code 0x02 “Illegal Data Address” since it attempts to
 * operate on registers 96, 97, 98, 99 and 100, and there is no register with address 100.
 */
class IllegalDataAddressException extends \Exception implements ExceptionInterface
{}
