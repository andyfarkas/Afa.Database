<?php

namespace Afa\Database\SqlRelay;

class Connection implements \Afa\Database\IConnection
{
    /**
     *
     * @var resource
     */
    protected $sqlRelayConnection;
    
    /**
     * 
     * @param string $host
     * @param int $port
     * @param string $user
     * @param string $password
     * @param int $retryTime
     * @param int $numberOfTries
     */
    public function __construct($host, $port, $user, $password, $retryTime, $numberOfTries)
    {
        $this->sqlRelayConnection = sqlrcon_alloc($host, $port, null, $user, $password, $retryTime, $numberOfTries);
        
    }
    
    /**
     * 
     * @param string $query
     * @param array $arguments
     * @return \Afa\Database\IResult
     * @throws \Afa\Database\SqlRelay\Exception
     */
    public function query($query, array $arguments)
    {
        $cursor = $this->execQuery($query, $arguments);
        return new Result($cursor);
    }

    /**
     * @param $query
     * @param array $arguments
     * @return mixed
     * @throws Exception
     */
    protected function execQuery($query, array $arguments)
    {
        $cursor = sqlrcur_alloc($this->sqlRelayConnection);
        sqlrcur_prepareQuery($cursor, $query);

        foreach($arguments as $variableName => $value)
        {
            sqlrcur_inputBind($cursor, $variableName, $value);
        }

        $success = sqlrcur_executeQuery($cursor);

        if (!$success)
        {
            $errorMessage = sqlrcur_errorMessage($cursor);
            throw new Exception($errorMessage);
        }

        return $cursor;
    }

    public function __destruct()
    {
        if ($this->sqlRelayConnection != null)
        {
            sqlrcon_free($this->sqlRelayConnection);
        }
    }

    /**
     * @param string $query
     * @param array $arguments
     */
    public function execute($query, array $arguments)
    {
        $this->execQuery($query, $arguments);
    }
}