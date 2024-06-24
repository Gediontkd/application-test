<?php

declare(strict_types=1);

namespace App\Resolver;

use App\Document\Event;
use App\Document\Speech;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Resolver\MutationInterface;

class CreateEventResolver implements MutationInterface
{
    private $documentManager;
    private $validator;

    public function __construct(DocumentManager $documentManager, ValidatorInterface $validator)
    {
        $this->documentManager = $documentManager;
        $this->validator = $validator;
    }

    public function __invoke(Argument $args)
    {
        $input = $args['input'];

        $event = new Event();
        $event->setKey($input['key']);
        $event->setName($input['name']);
        $event->setDate(new \DateTime($input['date']));

        foreach ($input['program'] as $speechData) {
            $speech = new Speech();
            $speech->setSpeaker($speechData['speaker']);
            $speech->setTopic($speechData['topic']);
            $speech->setStartTime($speechData['startTime']);
            $speech->setEndTime($speechData['endTime']);
            $event->addSpeech($speech);
        }

        $errors = $this->validator->validate($event);

        if (count($errors) > 0) {
            throw new \Exception((string) $errors);
        }

        $this->documentManager->persist($event);
        $this->documentManager->flush();

        return ['event' => $event];
    }
}
