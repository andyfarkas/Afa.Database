<?php

namespace Afa\Database;

interface ICommand
{
    /**
     * @param IConnection $connection
     * @return IResult
     */
    public function execute(IConnection $connection);
}