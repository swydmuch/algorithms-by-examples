<?php

declare(strict_types=1);


namespace AlgorithmsByExamples\Tests\KnapsackProblem;

use AlgorithmsByExamples\KnapsackProblem\Task;
use AlgorithmsByExamples\KnapsackProblem\SprintPlanner;
use AlgorithmsByExamples\KnapsackProblem\TasksCollection;
use PHPUnit\Framework\TestCase;

class SprintPlannerTest extends TestCase
{
    private TasksCollection $tasks;
    protected function setUp(): void
    {
        $this->tasks = (new TasksCollection())->add(new Task("Improve UX of main page", 2, 50))
            ->add(new Task("Fix critic bug in API", 8, 100))
            ->add(new Task("Code refactoring", 2, 30))
            ->add(new Task("Optimization app speed", 5, 40))
            ->add(new Task("Correct button position", 1, 10))
            ->add(new Task("Add filter option", 5, 60));
    }

    public function testFindValuableTasks(): void
    {
        $expectedTasks = (new TasksCollection())->add($this->tasks->get(5))
            ->add($this->tasks->get(4))
            ->add($this->tasks->get(1))
            ->add($this->tasks->get(0));

        $sprint = new SprintPlanner(16, $this->tasks);

        $this->assertEquals(220, $sprint->valuableTasksValue());
        $this->assertTrue($sprint->valuableTasks()->equals($expectedTasks));
    }

    public function testEmptyTasksCollection(): void
    {
        $sprint = new SprintPlanner(16, new TasksCollection());

        $this->assertEquals(0, $sprint->valuableTasksValue());
    }

    public function testZeroVelocity(): void
    {
        $sprint = new SprintPlanner(0, $this->tasks);

        $this->assertEquals(0, $sprint->valuableTasksValue());
    }

    public function testBigVelocity(): void
    {
        $sprint = new SprintPlanner(23, $this->tasks);

        $this->assertEquals(290, $sprint->valuableTasksValue());
        $this->assertTrue($sprint->valuableTasks()->equals($this->tasks));
    }

    public function testZeroVelocityAndEmptyTasksCollection(): void
    {
        $sprint = new SprintPlanner(0, new TasksCollection());

        $this->assertEquals(0, $sprint->valuableTasksValue());
    }

    public function testSmallVelocity(): void
    {
        $sprint = new SprintPlanner(1, $this->tasks);

        $this->assertEquals(10, $sprint->valuableTasksValue());
        $this->assertEquals("Correct button position", $sprint->valuableTasks()->get(0)->name());
    }
}
