<?php

namespace Afa\Database\Entity;

interface IBuilder
{
    /**
     *
     * @param array $data
     * @return \Afa\Database\IEntity
     */
    public function createEntity(array $data);
}