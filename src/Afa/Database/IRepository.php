<?php

namespace Afa\Database;

interface IRepository
{
    /**
     *
     * @param ICriteria $criteria
     * @return IEntity
     */
    public function findOne(ICriteria $criteria);
    
    /**
     *
     * @param ICriteria $criteria
     * @return IEntity[]
     */
    public function findMany(ICriteria $criteria);

    /**
     *
     * @param ICommand $command
     */
    public function execute(ICommand $command);
}