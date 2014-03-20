<?php

namespace Afa\Database\SqlRelay;

class Configurator implements  \Afa\Database\IConfigurator
{

    /**
     * @var mixed[]
     */
    protected $data = array();

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return \Afa\Database\IConnection
     */
    public function createConnection()
    {
        return new Connection($this->data['host'], $this->data['port'], $this->data['user'], $this->data['password'], $this->data['retryTime'], $this->data['numberOfRetries']);
    }
}