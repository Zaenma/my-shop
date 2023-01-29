<?php

namespace src\Utils;

class ValidatorError{

    /**
     * Key of the field
     *
     * @var [type]
     */
    private $key; 

    /**
     * The rule of validation
     *
     * @var [type]
     */
    private $rule;

    /**
     * Thes messages of errors
     *
     * @var array
     */
    private $messages = [
        "required" => "Le champs %s est requis"
    ];

    public function __construct(string $key, string $rule) {
        $this->key = $key;
        $this->rule = $rule;
    }

    public function __toString()
    {
        return sprintf($this->messages[$this->rule], $this->key);
    }
}