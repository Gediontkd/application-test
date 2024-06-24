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

        $program = $value->getProgram();

        $speeches = $program->toArray();
        usort($speeches, function ($a, $b) {
            return $a->getStartTime() <=> $b->getStartTime();
        });

        for ($i = 0; $i < count($speeches) - 1; $i++) {
            $currentSpeechEndTime = $speeches[$i]->getEndTime();
            $nextSpeechStartTime = $speeches[$i + 1]->getStartTime();

            if ($currentSpeechEndTime > $nextSpeechStartTime) {
                
                $this->context
                    ->buildViolation($constraint->overlappingSpeechesMessage)
                    ->addViolation();
                return;
            }
        }
    }
}
