<?php

declare(strict_types=1);

namespace App\Validator;

use App\Document\Event;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

final class ConstraintValidProgramValidator extends ConstraintValidator
{
    public function __construct()
    {
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof ConstraintValidProgram) {
            throw new UnexpectedTypeException($constraint, ConstraintValidProgram::class);
        }

        if (!$value instanceof Event) {
            throw new UnexpectedValueException($value, Event::class);
        }

        // Extract the program (speeches) from the event
        $program = $value->getProgram();

        // Sort speeches by their start times
        $speeches = $program->toArray();
        usort($speeches, function ($a, $b) {
            return $a->getStartTime() <=> $b->getStartTime();
        });

        // Check for overlapping speeches
        for ($i = 0; $i < count($speeches) - 1; $i++) {
            $currentSpeechEndTime = $speeches[$i]->getEndTime();
            $nextSpeechStartTime = $speeches[$i + 1]->getStartTime();

            if ($currentSpeechEndTime > $nextSpeechStartTime) {
                // Add a violation if there is an overlap
                $this->context
                    ->buildViolation($constraint->overlappingSpeechesMessage)
                    ->addViolation();
                return; // Stop further validation after finding an overlap
            }
        }
    }
}
