<?php

namespace src\Utils;

class Regle_validation
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
    public $errors = [];

    public function __construct(array $params)
    {
        $this->params = $params;
    }

    public function required(string...$champs)
    {
        foreach ($champs as $champ) {

            if ($this->getValue($champ) == null) {
                $this->errors[$champ] = "Les champs marqués par le symbole {$champ} sont obligatoires.";
            }
        }
        return $this->errors;
    }

    public function htmlspec(string...$champs)
    {
        foreach ($champs as $champ) {
            return htmlspecialchars(trim($this->getValue($champ)));
        }
    }
    /**
     * Récupère la valeur du champs
     *
     * @param string $key
     * @return string
     */
    public function getValue(string $key)
    {
        if (array_key_exists($key, $this->params)) {
            return $this->params[$key];
        }
        return null;
    }
}