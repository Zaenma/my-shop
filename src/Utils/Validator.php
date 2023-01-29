<?php

namespace src\Utils;

class Validator
{
    /**
     * Params posted
     *
     * @var [array]
     */
    private $params;

    /**
     * Errors
     *
     * @var array
     */
    private $errors = [];
    public function __construct(array $params)
    {
        $this->params = $params;
    }

    // function require string...$keys
    // {
    //     foreach ($keys as $key) {
    //         if (!array_key_exists($key, $this->params)) {
    //             $this->addError($key, "required");
    //         }
    //     }
    // }

    /**
     * Vérifie que le champs n'est pas vide
     *
     * @param string ...$keys
     * @return boolean
     */
    public function isEmpty(string...$keys)
    {
        foreach ($keys as $key) {
            if (empty($this->getValue($key)) || is_null($this->getValue($key))) {
                $this->addError($key, "required");
            }
        }
    }
    /**
     * Vérifie que le message ne contient pas des caractères bizarres
     *
     * @param string $key
     * @return void
     */
    public function message_valide(string $key)
    {
        $patern = "/^([a-zA-Z0-9]+-)+$/";

        if (!preg_match($patern, $this->params[$key])) {
            $this->errors[$key] = "Le champs Commentaire n'est pas valode";
        }
    }

    /**
     * Vérifier la taille du champs
     *
     * @param string $key
     * @param integer|null $min
     * @param integer|null $max
     * @return self
     */
    public function length(string $key, ?int $min, ?int $max = null): self
    {
        $value = $this->getValue($key);
        $length = mb_strlen($value);

        if (!is_null($min) && !is_null($max) && ($length < $min || $length > $max)) {
            $this->errors[$key] = "Le champs $key doit contenir entre $min et $max caractères";
            return $this;
        }
        if (!is_null($min) && $length < $min) {
            $this->errors[$key] = "Le champs $key doit contenir au minimum $min caractères";
            return $this;
        }

        if (!is_null($max) && $length > $max) {
            $this->errors[$key] = "Le champs $key doit contenir au minimum $min caractères";
            return $this;
        }
        return $this;
    }

    public function dateTime(string $key, string $format = "Y-m-d")
    {
        $value = $this->getValue($key);

        $dateTime = \DateTime::createFromFormat($format, $value);
        $errors = \DateTime::getLastErrors();
        if ($errors['error_count'] > 0) {
            $this->getErrors[$key] = "La date n'est pas valide";
        }
    }

    /**
     * Password validate function
     *
     * @param string $pass password
     * @return boolean
     */
    public function validate_pass($password, $min_len = 8, $max_len = 70, $req_digit = 1, $req_lower = 1, $req_upper = 1, $req_symbol = 1): bool
    {
        // Build regex string depending on requirements for the password
        $regex = '/^';
        if ($req_digit == 1) {$regex .= '(?=.*\d)';} // Match at least 1 digit
        if ($req_lower == 1) {$regex .= '(?=.*[a-z])';} // Match at least 1 lowercase letter
        if ($req_upper == 1) {$regex .= '(?=.*[A-Z])';} // Match at least 1 uppercase letter
        if ($req_symbol == 1) {$regex .= '(?=.*[^a-zA-Z\d])';} // Match at least 1 character that is none of the above
        $regex .= '.{' . $min_len . ',' . $max_len . '}$/';

        if (preg_match($regex, $password)) {
            return true;
        } else {
            return false;
        }

    }

    public function passwordVerfy(string $key)
    {

    }
    public function isValide(): bool
    {
        return empty($this->errors);
    }

    /**
     * Recupère les erreurs
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    private function addError(string $key, string $rule)
    {
        $this->errors[$key] = new ValidatorError($key, $rule);
    }

    /**
     * Récupère la valeur du champs
     *
     * @param string $key
     * @return void
     */
    public function getValue(string $key)
    {
        if (array_key_exists($key, $this->params)) {
            return $this->params[$key];
        }
        return null;
    }
}