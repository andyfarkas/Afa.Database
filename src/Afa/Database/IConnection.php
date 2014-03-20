<?php

namespace Afa\Database;

interface IConnection
{
    /**
     * 
     * @param string $query
     * @param mixed[] $arguments
     * @return IResult
     */
    public function query($query, array $arguments);

    /**
     * @param $query
     * @param array $arguments
     */
    public function execute($query, array $arguments);

}
