<?php

namespace Afa\Database\SqlRelay;

class Result implements \Afa\Database\IResult
{
    /**
     *
     * @var int
     */
    protected $currentRow = 0;

    /**
     *
     * @var resource
     */
    protected $cursor;

    /**
     * 
     * @param resource $cursor
     */
    public function __construct($cursor)
    {
        $this->cursor = $cursor;
    }

    /**
     * 
     * @return mixed[]
     */
    public function current()
    {
        return sqlrcur_getRowAssoc($this->cursor, $this->currentRow);
    }

    /**
     * 
     * @return int
     */
    public function key()
    {
        return $this->currentRow;
    }

    public function next()
    {
        $this->currentRow++;
    }

    public function rewind()
    {
        $this->currentRow = 0;
    }

    /**
     * 
     * @return bool
     */
    public function valid()
    {
        return $this->current() !== false;
    }
    
    public function __destruct()
    {
        sqlrcur_free($this->cursor);
    }

    /**
     * 
     * @return int
     */
    public function count()
    {
        return sqlrcur_rowCount($this->cursor);
    }

}