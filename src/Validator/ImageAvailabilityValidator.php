<?php

namespace App\Validator;

use App\Service\Image\RemoteImageServiceInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class ImageAvailabilityValidator extends ConstraintValidator
{
    public function __construct(
        private readonly RemoteImageServiceInterface $remoteImageService
    ) {
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof ImageAvailability) {
            throw new UnexpectedTypeException($constraint, ImageAvailability::class);
        }

        if (!$value) {
            return;
        }

        if (!$this->remoteImageService->isRemoteImageAvailable($value)) {
            $this->context
                ->buildViolation($constraint->message)
                ->setParameter('{{ url }}', $value)
                ->addViolation();
        }
    }
}
