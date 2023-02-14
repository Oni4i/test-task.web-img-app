<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class ImageAvailability extends Constraint
{
    public string $message = 'The image by url {{ url }} is not available';
}