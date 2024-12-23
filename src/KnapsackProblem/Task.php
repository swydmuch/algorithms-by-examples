<?php

declare(strict_types=1);


namespace AlgorithmsByExamples\KnapsackProblem;

readonly class Task
{
    public function __construct(
        private string $name,
        private int    $storyPoint,
        private int    $businessValue
    )
    {}

    public function name(): string
    {
        return $this->name;
    }

    public function storyPoint(): int
    {
        return $this->storyPoint;
    }

    public function businessValue(): int
    {
        return $this->businessValue;
    }

    public function equals(Task $task): bool
    {
        return $this->name() === $task->name()
            && $this->storyPoint() === $task->storyPoint()
            && $this->businessValue() === $task->businessValue();
    }
}