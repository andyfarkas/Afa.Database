<?php

namespace Afa\Database\Repository;

class Generic implements \Afa\Database\IRepository
{
    
    /**
     *
     * @var \Afa\Database\IConnection
     */
    protected $connection;
    
    /**
     * 
     * @param \Afa\Database\IConnection $connection
     */
    public function __construct(\Afa\Database\IConnection $connection)
    {
        $this->connection = $connection;
    }
    
    /**
     * 
     * @param \Afa\Database\ICriteria $criteria
     * @return \Afa\Database\IEntity[]
     */
    public function findMany(\Afa\Database\ICriteria $criteria)
    {
        $result = $criteria->execute($this->connection);
        $resultSet = array();
        foreach ($result as $row)
        {
            $resultSet[] = $criteria->createEntity($row);
        }
        
        return $resultSet;
    }

    /**
     *
     * @param \Afa\Database\ICriteria $criteria
     * @throws Exception\ObjectNotFound
     * @throws Exception\MultipleObjectsFound
     * @return \Afa\Database\IEntity
     */
    public function findOne(\Afa\Database\ICriteria $criteria)
    {
        $result = $criteria->execute($this->connection);
        
        if (count($result) > 1)
        {
            throw new Exception\MultipleObjectsFound('Multiple objects found but expected only one.');
        }
        
        $rowData = $result->current();
        if ($rowData === false)
        {
            throw new Exception\ObjectNotFound('Requested object was not found.');
        }
        
        return $criteria->createEntity($rowData);
    }

    /**
     *
     * @param \Afa\Database\ICommand $command
     */
    public function execute(\Afa\Database\ICommand $command)
    {
        $command->execute($this->connection);
    }
}