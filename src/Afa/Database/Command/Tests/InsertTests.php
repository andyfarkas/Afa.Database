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

    /**
     * @test
     */
    public function run_SuccessfulInsertCommand_ReturnsLastInsertedIdInResult()
    {
        $lastInsertId = 1;
        $expectedResult = new \Afa\Database\Result\LastInsertId($lastInsertId);
        $connectionMock = $this->getMock('Afa\Database\IConnection');
        $connectionMock->expects($this->any())
                        ->method('execute');
        $connectionMock->expects($this->any())
                        ->method('lastInsertId')
                        ->will($this->returnValue($lastInsertId));

        $command = new \Afa\Database\Command\Insert('table', $arguments = array());
        $result = $command->execute($connectionMock);

        $this->assertEquals($expectedResult, $result);
    }

}