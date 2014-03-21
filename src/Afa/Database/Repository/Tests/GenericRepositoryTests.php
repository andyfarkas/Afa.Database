<?php

namespace Afa\Database\Repository\Tests;

class GenericRepositoryTests extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function findOne_EmptyResult_ThrowsObjectNotFoundException()
    {        
        $resultMock = $this->getMock('Afa\Database\IResult');
        $resultMock->expects($this->any())
                    ->method('current')
                    ->will($this->returnValue(false));
        
        $connectionMock = $this->getMock('Afa\Database\IConnection');
        $criteriaMock = $this->getMock('Afa\Database\ICriteria');
        $criteriaMock->expects($this->any())
                        ->method('execute')
                        ->with($connectionMock)
                        ->will($this->returnValue($resultMock));
        
        $repository = new \Afa\Database\Repository\Generic($connectionMock);
        $this->setExpectedException('Afa\Database\Repository\Exception\ObjectNotFound');
        $repository->findOne($criteriaMock);
    }
    
    /**
     * @test
     */
    public function findOne_OneRowResult_ReturnsCreatedEntity()
    {        
        $dbResult = array(
            'id' => 1,
        );
        $resultMock = $this->getMock('Afa\Database\IResult');
        $resultMock->expects($this->once())
                    ->method('current')
                    ->will($this->returnValue($dbResult));
        
        $connectionMock = $this->getMock('Afa\Database\IConnection');
        $criteriaMock = $this->getMock('Afa\Database\ICriteria');
        $criteriaMock->expects($this->any())
                        ->method('execute')
                        ->with($connectionMock)
                        ->will($this->returnValue($resultMock));
        
        $entityMock = $this->getMock('Afa\Database\IEntity');
        $criteriaMock->expects($this->any())
                    ->method('createEntity')
                    ->with($dbResult)
                    ->will($this->returnValue($entityMock));
        
        $repository = new \Afa\Database\Repository\Generic($connectionMock);        
        $result = $repository->findOne($criteriaMock);
        
        $this->assertEquals($entityMock, $result);
    }
    
    /**
     * @test
     */
    public function findOne_MultipleRowsResult_ThrowsMultipleObjectsFoundException()
    {                
        $resultMock = $this->getMock('Afa\Database\IResult');
        $resultMock->expects($this->any())
                    ->method('count')
                    ->will($this->returnValue(2));
        
        $connectionMock = $this->getMock('Afa\Database\IConnection');
        $criteriaMock = $this->getMock('Afa\Database\ICriteria');
        $criteriaMock->expects($this->any())
                        ->method('execute')
                        ->with($connectionMock)
                        ->will($this->returnValue($resultMock));                
        
        $repository = new \Afa\Database\Repository\Generic($connectionMock);        
        
        $this->setExpectedException('Afa\Database\Repository\Exception\MultipleObjectsFound');
        $repository->findOne($criteriaMock);               
    }
    
    /**
     * @test
     */
    public function findMany_NonEmptyResult_ReturnsArrayOfEntities()
    {
        $dbRow = array(
            'id' => 1,
        );
        
        $entityMock = $this->getMock('Afa\Database\IEntity');
        $expected = array(
            $entityMock,
            $entityMock
        );
        
        $resultMock = new \Afa\Database\Result\InMemory(array($dbRow, $dbRow));
        
        $criteriaMock = $this->getMock('Afa\Database\ICriteria');
        $criteriaMock->expects($this->at(1))
                        ->method('createEntity')
                        ->with($dbRow)
                        ->will($this->returnValue($entityMock));
        
        $criteriaMock->expects($this->at(2))
                        ->method('createEntity')
                        ->with($dbRow)
                        ->will($this->returnValue($entityMock));
        
        $connectionMock = $this->getMock('Afa\Database\IConnection');
        $criteriaMock->expects($this->any())
                        ->method('execute')
                        ->with($connectionMock)
                        ->will($this->returnValue($resultMock));

        $repository = new \Afa\Database\Repository\Generic($connectionMock);
        $result = $repository->findMany($criteriaMock);
        
        $this->assertEquals($expected, $result);
    }
    
    /**
     * @test
     */
    public function findMany_EmptyResult_ReturnsEmptyArray()
    {                        
        $expected = array();        
        $resultMock = new \Afa\Database\Result\InMemory(array());
        
        $criteriaMock = $this->getMock('Afa\Database\ICriteria');                
        $connectionMock = $this->getMock('Afa\Database\IConnection');
        $criteriaMock->expects($this->any())
                        ->method('execute')
                        ->with($connectionMock)
                        ->will($this->returnValue($resultMock));

        $repository = new \Afa\Database\Repository\Generic($connectionMock);
        $result = $repository->findMany($criteriaMock);
        
        $this->assertEquals($expected, $result);
    }
}