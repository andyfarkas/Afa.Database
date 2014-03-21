<?php

namespace Afa\Database\Result;

class InMemory implements \Afa\Database\IResult
{
    /**
     *
     * @var array
     */
    protected $data;
    
    /**
     * 
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }
    
    /**
     * 
     * @return int
     */
    public function count()
    {
        return count($this->data);
    }

    /**
     * 
     * @return mixed
     */
    public function current()
    {
        return current($this->data);
    }

    /**
     * 
     * @return mixed
     */
    public function key()
    {
        return key($this->data);
    }

    public function next()
    {
        next($this->data);
    }

    public function rewind()
    {
        reset($this->data);
    }

    /**
     * 
     * @return boolean
     */
    public function valid()
    {
        return array_key_exists($this->key(), $this->data);
    }

}