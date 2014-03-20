<?php

namespace Afa\Database\Command\Tests;

class InsertTests extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function run_NonEmptyArray_InsertsDataUsingConnection()
    {
        $table = 'table';

        $expectedSql = 'INSERT INTO table (column1, column2) VALUES (:column1, :column2)';
        $expectedArguments = array(
            'column1' => 1,
            'column2' => 'a',
        );

        $connectionMock = $this->getMock('Afa\Database\IConnection');
        $connectionMock->expects($this->once())
                        ->method('execute')
                        ->with($expectedSql, $expectedArguments);

        $command = new \Afa\Database\Command\Insert($table, $expectedArguments);
        $command->execute($connectionMock);
    }

}