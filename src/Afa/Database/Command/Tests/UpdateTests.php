<?php

namespace Afa\Database\Command\Tests;

class UpdateTests extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function run_NonEmptyValuesSingleWhereCondition_UpdatesDataUsingConnection()
    {
        $arguments = array(
            'column1' => 1,
            'column2' => 'a',
            'id' => 2,
        );

        $expectedSql = 'UPDATE table SET column1 = :column1, column2 = :column2 WHERE id = :id';

        $connectionMock = $this->getMock('Afa\Database\IConnection');
        $connectionMock->expects($this->once())
            ->method('execute')
            ->with($expectedSql, $arguments);

        $command = new \Afa\Database\Command\Update('table', array(
            'column1' => 1,
            'column2' => 'a',
        ), array(
            'id' => 2,
        ));

        $command->execute($connectionMock);
    }

    /**
     * @test
     */
    public function run_NonEmptyValuesMultipleWhereConditions_UpdatesDataUsingConnection()
    {
        $arguments = array(
            'column1' => 1,
            'column2' => 'a',
            'id' => 2,
            'id2' => 3
        );

        $expectedSql = 'UPDATE table SET column1 = :column1, column2 = :column2 WHERE id = :id AND id2 = :id2';

        $connectionMock = $this->getMock('Afa\Database\IConnection');
        $connectionMock->expects($this->once())
            ->method('execute')
            ->with($expectedSql, $arguments);

        $command = new \Afa\Database\Command\Update('table', array(
            'column1' => 1,
            'column2' => 'a',
        ), array(
            'id' => 2,
            'id2' => 3,
        ));

        $command->execute($connectionMock);
    }

}