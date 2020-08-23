<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TaskRepository::class)
 */
class Task
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $task_name;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $Incomplete;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $InProgress;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $Complete;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTaskName(): ?string
    {
        return $this->task_name;
    }

    public function setTaskName(string $task_name): self
    {
        $this->task_name = $task_name;

        return $this;
    }

    public function getIncomplete(): ?bool
    {
        return $this->Incomplete;
    }

    public function setIncomplete(?bool $Incomplete): self
    {
        $this->Incomplete = $Incomplete;

        return $this;
    }

    public function getInProgress(): ?bool
    {
        return $this->InProgress;
    }

    public function setInProgress(?bool $InProgress): self
    {
        $this->InProgress = $InProgress;

        return $this;
    }

    public function getComplete(): ?bool
    {
        return $this->Complete;
    }

    public function setComplete(?bool $Complete): self
    {
        $this->Complete = $Complete;

        return $this;
    }
}
