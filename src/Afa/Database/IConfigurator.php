<?php

namespace Afa\Database;

interface IConfigurator
{
    /**
     * @return IConnection
     */
    public function createConnection();
}