<?php

declare(strict_types=1);


namespace AlgorithmsByExamples\Tests\KnapsackProblem;

use AlgorithmsByExamples\KnapsackProblem\Task;
use AlgorithmsByExamples\KnapsackProblem\TasksCollection;
use PHPUnit\Framework\TestCase;

class TasksCollectionTest extends TestCase
{
    public function testAddTask(): void
    {
        $collection = new TasksCollection();
        $task = new Task("Nazwa", 1, 10);
        $collection->add($task);
        $this->assertCount(1, $collection);
        $this->assertEquals($task, $collection->get(0));
    }

    public function testCompareTwoEqualCollection(): void
    {
        $task = new Task("Nazwa", 1, 10);
        $firstCollection = new TasksCollection();
        $firstCollection->add($task);
        $secondCollection = new TasksCollection();
        $secondCollection->add($task);
        $this->assertTrue($firstCollection->equals($secondCollection));
        $this->assertTrue($secondCollection->equals($firstCollection));

    }

    public function testCompareTwoNotEqualCollection(): void
    {
        $firstTask = new Task("Nazwa 1", 1, 10);
        $secondTask = new Task("Nazwa 2", 1, 10);
        $firstCollection = new TasksCollection();
        $firstCollection->add($firstTask);
        $secondCollection = new TasksCollection();
        $secondCollection->add($secondTask);
        $this->assertFalse($firstCollection->equals($secondCollection));
        $this->assertFalse($secondCollection->equals($firstCollection));

    }

    public function testCompareToEmptyCollection(): void
    {
        $firstTask = new Task("Nazwa 1", 1, 10);
        $firstCollection = new TasksCollection();
        $firstCollection->add($firstTask);
        $secondCollection = new TasksCollection();
        $this->assertFalse($firstCollection->equals($secondCollection));
        $this->assertFalse($secondCollection->equals($firstCollection));

    }
}
