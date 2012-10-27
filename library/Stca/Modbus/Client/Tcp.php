<?php

namespace Stca\Modbus\Client;

use Stca\Modbus\Message\RequestInterface;
use Stca\Modbus\Message\ResponseMessage;
use RuntimeException;
use InvalidArgumentException;

class Tcp extends AbstractClient
{
    /**
     * @var string
     */
    protected $host;

    /**
     * @var int
     */
    protected $port = 502;

    /**
     * @var resource
     */
    private $socket;

    /**
     * @param string $host
     * @param int $port
     * @param int $timeout
     */
    public function __construct($host, $port = 502, $timeout = 30)
    {
        $this->setHost($host);
        $this->setPort($port);
        $this->setTimeout($timeout);
    }

    /**
     * Returns protocol identifier
     *
     * @return int
     */
    public function getProtocolIdentifier()
    {
        return 0x0000;
    }

    /**
     * Setup a tcp connection to modbus
     *
     * @return Tcp
     * @throws RuntimeException
     */
    public function connect()
    {
        if ($this->isConnected()) {
            return $this;
        }

        $start = time();

        do {
            $this->socket = stream_socket_client($this->getConnectionString(), $errno, $errstr, $this->getTimeout());
            if (false === $this->socket) {
                throw new \RuntimeException($errstr, $errno);
            }

            if (!$this->socket) {
                sleep($this->getTimeout());
            }
        } while (!$this->socket && (time() - $start) < $this->getTimeout());

        if ($this->socket) {
            stream_set_timeout($this->socket, 1);
            stream_set_blocking($this->socket, 1);
        } else {
            throw new RuntimeException('Could not connect to server.');
        }

        return $this;
    }

    /**
     * Disconnects tcp connection to modbus
     */
    public function disconnect()
    {
        unset($this->socket);
        return $this;
    }

    /**
     * Returns is socket is still connected
     *
     * @return bool
     */
    public function isConnected()
    {
        if (is_resource($this->socket)) {
            $meta = stream_get_meta_data($this->socket);
            return $meta['timed_out'] === false;
        }

        return false;
    }

    public function request(RequestInterface $request)
    {
        $request->setTransactionId($this->generateTransactionIdentifier());
        $frame = $this->buildFrame($request);

        $this->write($frame);
        return $this->read();
    }

    /**
     * @throws RuntimeException
     */
    protected function assertConnected()
    {
        if (!$this->isConnected()) {
            throw new \RuntimeException('Socket is not connected.');
        }
    }

    /**
     * Writes a message to the modbus socket
     *
     * @param  string $message in binary
     * @return Tcp
     */
    protected function write($message)
    {
        $this->assertConnected();

        fwrite($this->socket, $message);
        return $this;
    }

    /**
     * @return string
     */
    protected function read()
    {
        $this->assertConnected();

        $response = new ResponseMessage();
        $response->setTransactionId(bin2hex(fread($this->socket, 2)));
        $response->setProtocol(bin2hex(fread($this->socket, 2)));

        $length = fread($this->socket, 2);
        $data   = fread($this->socket, (int) bin2hex($length));

        $response->setFunctionCode(bin2hex(substr($data, 1, 1)));
        $response->setSlaveAddress(bin2hex(substr($data, 0, 1)));
        $response->setMessageFrame(bin2hex(substr($data, 3)));

        return $response;
    }

    /**
     * @param string $host - hostname or ip address of modbus master
     * @return Tcp
     * @throws InvalidArgumentException
     */
    protected function setHost($host)
    {
        if (!is_string($host)) {
            throw new InvalidArgumentException('Invalid host provided. Expected string, got ' . gettype($host));
        }

        $this->host = $host;

        return $this;
    }

    /**
     * @param int $port - tcp port number to connect on
     * @return Tcp
     * @throws InvalidArgumentException
     */
    protected function setPort($port)
    {
        if (!is_integer($port)) {
            throw new InvalidArgumentException('Invalid port provided. Expected integer, got ' . gettype($port));
        }

        $this->port = $port;

        return $this;
    }

    /**
     * @return string
     */
    protected function getConnectionString()
    {
        return 'tcp://' . $this->host . ':' . $this->port;
    }
}
