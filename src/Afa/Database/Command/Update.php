<?php

namespace Afa\Database\Command;

class Update implements \Afa\Database\ICommand
{

    /**
     * @var string
     */
    protected $table;

    /**
     * @var array
     */
    protected $data = array();

    /**
     * @var array
     */
    protected $where = array();

    /**
     * @param string $table
     * @param array $data
     * @param array $where
     */
    public function __construct($table, array $data, array $where)
    {
        $this->table = $table;
        $this->data = $data;
        $this->where = $where;
    }

    /**
     * @param \Afa\Database\IConnection $connection
     */
    public function execute(\Afa\Database\IConnection $connection)
    {
        $columns = array_keys($this->data);
        $setString = implode(', ', array_map(function($column)
        {
            return $column . ' = :' . $column;
        }, $columns));

        $whereColumns = array_keys($this->where);
        $whereString = implode(' AND ', array_map(function($column)
        {
            return $column . ' = :' . $column;
        }, $whereColumns));

        $sql = sprintf('UPDATE %s SET %s WHERE %s', $this->table, $setString, $whereString);

        $arguments = array_merge($this->data, $this->where);
        $connection->execute($sql, $arguments);
    }
}