<?php

namespace Afa\Database\Command\Tests;

class DeleteTests extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function run_OneWhereCondition_DeletesUsingConnection()
    {
        $arguments = array(
            'id' => 2,
        );

        $expectedSql = 'DELETE FROM table WHERE id = :id';

        $connectionMock = $this->getMock('Afa\Database\IConnection');
        $connectionMock->expects($this->once())
            ->method('execute')
            ->with($expectedSql, $arguments);

        $command = new \Afa\Database\Command\Delete('table', array(
            'id' => 2,
        ));

        $command->execute($connectionMock);
    }

    /**
     * @test
     */
    public function run_MultipleWhereCondition_DeletesUsingConnection()
    {
        $arguments = array(
            'id' => 2,
            'column' => 3,
        );

        $expectedSql = 'DELETE FROM table WHERE id = :id AND column = :column';

        $connectionMock = $this->getMock('Afa\Database\IConnection');
        $connectionMock->expects($this->once())
            ->method('execute')
            ->with($expectedSql, $arguments);

        $command = new \Afa\Database\Command\Delete('table', array(
            'id' => 2,
            'column' => 3,
        ));

        $command->execute($connectionMock);
    }

}