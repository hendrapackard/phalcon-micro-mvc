<?php

use Phalcon\Mvc\Model\Message;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness;
use Phalcon\Validation\Validator\InclusionIn;

class Robots extends \Phalcon\Mvc\Model
{

    public function validation()
    {
        $validator = new Validation();

        // Type must be: droid, mechanical or virtual
        $validator->add(
            "type",
            new InclusionIn(
                [
                    'message' => 'Type must be "droid", "mechanical", or "virtual"',
                    'domain' => [
                        'droid',
                        'mechanical',
                        'virtual',
                    ],
                ]
            )
        );

        // Robot name must be unique
        $validator->add(
            'name',
            new Uniqueness(
                [
                    'field'   => 'name',
                    'message' => 'The robot name must be unique',
                ]
            )
        );

        // Year cannot be less than zero
        if ($this->year < 0) {
            $this->appendMessage(
                new Message('The year cannot be less than zero')
            );
        }

        // Check if any messages have been produced
        return $this->validate($validator);
    }

}
