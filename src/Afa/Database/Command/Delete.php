<?php

namespace Afa\Database\Command;

class Delete implements \Afa\Database\ICommand
{

    /**
     * @var string
     */
    protected $table;

    /**
     * @var array
     */
    protected $where = array();

    /**
     * @param string $table
     * @param array $where
     */
    public function __construct($table, array $where)
    {
        $this->table = $table;
        $this->where = $where;
    }

    /**
     * @param \Afa\Database\IConnection $connection
     */
    public function execute(\Afa\Database\IConnection $connection)
    {
        $columns = array_keys($this->where);
        $whereString = implode(' AND ', array_map(function($column)
        {
            return $column . ' = :' . $column;
        }, $columns));
        $sql = sprintf('DELETE FROM %s WHERE %s', $this->table, $whereString);
        $connection->execute($sql, $this->where);
    }
}