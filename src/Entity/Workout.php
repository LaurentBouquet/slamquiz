<?php

namespace App\Entity;

use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="tbl_workout")
 * @ORM\Entity(repositoryClass="App\Repository\WorkoutRepository")
 */
class Workout
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Quiz", inversedBy="workouts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $quiz;

    /**
     * @ORM\Column(type="datetime")
     */
    private $started_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $ended_at;

    /**
     * @ORM\Column(type="integer")
     */
    private $number_of_questions;

    /**
     * @ORM\Column(type="boolean")
     */
    private $completed;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $score;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuiz(): ?Quiz
    {
        return $this->quiz;
    }

    public function setQuiz(?Quiz $quiz): self
    {
        $this->quiz = $quiz;

        return $this;
    }

    public function getStartedAt(): ?\DateTimeInterface
    {
        return $this->started_at;
    }

    public function setStartedAt(\DateTimeInterface $started_at): self
    {
        $this->started_at = $started_at;

        return $this;
    }

    public function getEndedAt(): ?\DateTimeInterface
    {
        return $this->ended_at;
    }

    public function setEndedAt(?\DateTimeInterface $ended_at): self
    {
        $this->ended_at = $ended_at;

        return $this;
    }

    public function getNumberOfQuestions(): ?int
    {
        return $this->number_of_questions;
    }

    public function setNumberOfQuestions(int $number_of_questions): self
    {
        $this->number_of_questions = $number_of_questions;

        return $this;
    }

    public function getCompleted(): ?bool
    {
        return $this->completed;
    }

    public function setCompleted(bool $completed): self
    {
        $this->completed = $completed;

        return $this;
    }

    public function getScore(): ?float
    {
        return $this->score;
    }

    public function setScore(?float $score): self
    {
        $this->score = $score;

        return $this;
    }
}
