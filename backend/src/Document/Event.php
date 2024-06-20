<?php

declare(strict_types=1);

namespace App\Document;

use App\Contract\Document\ConcurrencySafeDocumentInterface;
use App\Contract\Document\EquatableDocumentInterface;
use App\DocumentModel\EventModel;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use App\Validator\ConstraintValidProgram;

/**
 * @MongoDB\Document(collection="events")
 * @MongoDB\HasLifecycleCallbacks
 */
class Event extends AbstractConcurrencySafeDocument implements
    ConcurrencySafeDocumentInterface,
    EquatableDocumentInterface
{
    /**
     * @var string
     * @MongoDB\Id(strategy="UUID")
     */
    protected $id;

    /**
     * @var string
     * @MongoDB\Field(type="string")
     */
    protected $key;

    /**
     * @var string
     * @MongoDB\Field(type="string")
     */
    protected $name;

    /**
     * @var string[]
     * @MongoDB\Field(type="collection")
     */
    protected $participants;

    /**
     * @var DateTimeInterface
     * @MongoDB\Field(type="date")
     */
    protected $date;

    /**
     * @var Collection
     * @MongoDB\EmbedMany(targetDocument="Speech")
     * @ConstraintValidProgram()
     */
    protected $program;

    public function __construct()
    {
        $this->key = '';
        $this->name = '';
        $this->participants = [];
        $this->date = new DateTime();
        $this->program = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function setKey(string $key): self
    {
        $this->key = $key;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getParticipants(): array
    {
        return $this->participants;
    }

    public function setParticipants(array $participants): self
    {
        $this->participants = $participants;
        return $this;
    }

    public function getDate(): DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(DateTimeInterface $date): self
    {
        $this->date = $date;
        return $this;
    }

    public function getProgram(): Collection
    {
        return $this->program;
    }

    public function setProgram(Collection $program): self
    {
        $this->program = $program;
        return $this;
    }

    public static function getDocumentModelName(): string
    {
        return EventModel::class;
    }

    public function getDocumentName(): string
    {
        return Event::class;
    }

    public function isEqualTo(EquatableDocumentInterface $document): bool
    {
        return $document instanceof Event
            && $this->key === $document->getKey();
    }
}
