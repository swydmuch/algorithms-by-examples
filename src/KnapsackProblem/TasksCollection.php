<?php

declare(strict_types=1);


namespace AlgorithmsByExamples\KnapsackProblem;

use Traversable;

/**
 * @implements  \IteratorAggregate<int, Task>
 */
class TasksCollection implements \Countable, \IteratorAggregate
{
    /**
     * @var array<int, Task>
     */
    private array $tasks = [];

    public function add(Task $task): self
    {
        $this->tasks[] = $task;
        return $this;
    }

    public function get(int $index): Task
    {
        return $this->tasks[$index];
    }

    public function count(): int
    {
        return count($this->tasks);
    }

    public function equals(TasksCollection $other): bool
    {
        if ($this->count() !== $other->count()) {
            return false;
        }

        foreach ($this as $task) {
            $found = false;
            foreach ($other as $otherTask) {
                if ($task->equals($otherTask)) {
                    $found = true;
                }
            }

            if (!$found) {
                return false;
            }

        }

        return true;
    }

    public function getIterator(): Traversable
    {
        return new \ArrayIterator($this->tasks);
    }
}