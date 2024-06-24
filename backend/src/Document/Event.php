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
     * @var ?string
     * @MongoDB\Id(strategy="UUID")
     */
    protected ?string $id = null;

    /**
     * @var string
     * @MongoDB\Field(type="string")
     */
    protected string $key = '';

    /**
     * @var string
     * @MongoDB\Field(type="string")
     */
    protected string $name = '';

    /**
     * @var array
     * @MongoDB\Field(type="collection")
     */
    protected array $participants = [];

    /**
     * @var DateTimeInterface
     * @MongoDB\Field(type="date")
     */
    protected DateTimeInterface $date;

    /**
     * @var Collection
     * @MongoDB\EmbedMany(targetDocument="Speech")
     * @ConstraintValidProgram()
     */
    protected Collection $program;

    public function __construct()
    {
        $this->date = new DateTime();
        $this->program = new ArrayCollection();
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

    // Getters and setters for key, name, participants, date, and program can be added here if needed
}
