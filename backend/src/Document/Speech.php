<?php

declare(strict_types=1);

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\EmbeddedDocument
 */
class Speech
{
    /**
     * @var string
     * @MongoDB\Field(type="string")
     */
    protected $topic;

    /**
     * @var string
     * @MongoDB\Field(type="string")
     */
    protected $speaker;

    /**
     * @var int
     * @MongoDB\Field(type="int")
     */
    protected $startTime;

    /**
     * @var int
     * @MongoDB\Field(type="int")
     */
    protected $endTime;

    public function __construct()
    {
        $this->topic = '';
        $this->speaker = '';
        $this->startTime = 0;
        $this->endTime = 1;
    }

    public function getTopic(): string
    {
        return $this->topic;
    }

    public function setTopic(string $topic): self
    {
        $this->topic = $topic;
        return $this;
    }

    public function getSpeaker(): string
    {
        return $this->speaker;
    }

    public function setSpeaker(string $speaker): self
    {
        $this->speaker = $speaker;
        return $this;
    }

    public function getStartTime(): int
    {
        return $this->startTime;
    }

    public function setStartTime(int $startTime): self
    {
        $this->startTime = $startTime;
        return $this;
    }

    public function getEndTime(): int
    {
        return $this->endTime;
    }

    public function setEndTime(int $endTime): self
    {
        $this->endTime = $endTime;
        return $this;
    }
}
