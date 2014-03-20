<?php

namespace Afa\Database\PDO;

class Connection implements \Afa\Database\IConnection
{
    /**
     *
     * @var \PDO
     */
    protected $pdoConnection;

    /**
     *
     * @param string $dsn
     * @param string $username
     * @param string $password
     * @throws Exception
     */
    public function __construct($dsn, $username, $password)
    {
        try
        {
            $this->pdoConnection = new \PDO($dsn, $username, $password, array(
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            ));        
        }
        catch (\Exception $e)
        {
            throw new Exception($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * 
     * @param string $query
     * @param array $arguments
     * @return \Afa\Database\InMemoryResult
     */
    public function query($query, array $arguments)
    {
        $statement = $this->pdoConnection->prepare($query);
        $statement->execute($arguments);
        $data = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return new \Afa\Database\InMemoryResult($data);
    }

    /**
     * @param $query
     * @param array $arguments
     */
    public function execute($query, array $arguments)
    {
        $statement = $this->pdoConnection->prepare($query);
        $statement->execute($arguments);
    }
}