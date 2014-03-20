<?php

namespace Afa\Database\Command;

class Insert implements \Afa\Database\ICommand
{
    /**
     * @var array
     */
    protected $data = array();

    /**
     * @var string
     */
    protected $table;

    /**
     * @param $table
     * @param array $data
     */
    public function __construct($table, array $data)
    {
        $this->data = $data;
        $this->table = $table;
    }

    /**
     * @param \Afa\Database\IConnection $connection
     */
    public function execute(\Afa\Database\IConnection $connection)
    {
        $columns = array_keys($this->data);
        $variables = array_map(function($column)
        {
            return ':' . $column;
        }, $columns);

        $columnsString = implode(', ', $columns);
        $valuesString = implode(', ', $variables);
        $sql = sprintf('INSERT INTO %s (%s) VALUES (%s)', $this->table, $columnsString, $valuesString);

        $connection->execute($sql, $this->data);
    }
}