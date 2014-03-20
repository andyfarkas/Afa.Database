<?php

namespace Afa\Database\PDO;

class Configurator implements \Afa\Database\IConfigurator
{
    /**
     * @var array
     */
    protected $dbConfig = array();

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->dbConfig = $config;
    }

    /**
     * @return \Afa\Database\IConnection
     */
    public function createConnection()
    {
        return new Connection($this->dbConfig['dns'], $this->dbConfig['username'], $this->dbConfig['password']);
    }
}