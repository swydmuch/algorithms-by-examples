<?php

declare(strict_types=1);


namespace AlgorithmsByExamples\KnapsackProblem;

class SprintPlanner
{
    private TasksCollection $valuableTasks;
    private int $value = 0;

    /**
     * @var array<int, array<int, int>>
     */
    private array $tab;

    private int $rowCount;
    private int $colCount;

    private int $taskCount;

    public function __construct(private readonly int $teamVelocity, private readonly TasksCollection $backlogTasks)
    {
        $this->valuableTasks = new TasksCollection();
        $this->solve();
    }

    public function valuableTasks(): TasksCollection
    {
        return $this->valuableTasks;
    }

    public function valuableTasksValue(): int
    {
        return $this->value;
    }
    private function solve(): void
    {
        $this->initializeTab();
        $this->fillTab();
        $this->setBestValueFromTab();
        $this->setValuableTasksFromTab();
    }

    private function initializeTab(): void
    {
        $this->taskCount = count($this->backlogTasks);
        $this->rowCount = $this->taskCount;
        $this->rowCount++;
        $this->colCount =  $this->teamVelocity;
        $this->colCount++;
        $this->tab = array_fill(0, $this->rowCount, array_fill(0,$this->colCount, 0));
    }

    private function fillTab(): void
    {
        for ($i = 1; $i < $this->rowCount; $i++) {
            for ($consideredVelocity = 1; $consideredVelocity < $this->colCount; $consideredVelocity++) {
                $consideredTask = $this->backlogTasks->get($i - 1);
                $previousValue = $this->tab[$i - 1][$consideredVelocity];

                if ($consideredTask->storyPoint() <= $consideredVelocity) {
                    $previousValueDecreasedByConsideredTask = $this->tab[$i - 1][$consideredVelocity - $consideredTask->storyPoint()];
                    $includeTask = $consideredTask->businessValue() + $previousValueDecreasedByConsideredTask;
                    $excludeTask = $previousValue;
                    $this->tab[$i][$consideredVelocity] = max($includeTask, $excludeTask);
                } else {
                    $this->tab[$i][$consideredVelocity] = $previousValue;
                }
            }
        }
    }

    private function setBestValueFromTab(): void
    {
        $this->value = $this->tab[$this->taskCount][$this->teamVelocity];
    }

    private function setValuableTasksFromTab(): void
    {
        $v = $this->teamVelocity;
        for ($i = $this->taskCount; $i > 0; $i--) {
            if ($this->tab[$i][$v] != $this->tab[$i - 1][$v]) {
                $this->valuableTasks->add($this->backlogTasks->get($i - 1));
                $v = $v - $this->backlogTasks->get($i - 1)->storyPoint();
            }
        }
    }
}