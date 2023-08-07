<?php

namespace Combindma\Fpay\Exceptions;

use Exception;

class InvalidConfiguration extends Exception
{
    public static function merchantKeyNotSpecified(): static
    {
        return new static('FPAY_MERCHANT_KEY n\'a été renseigné. Vous devez fournir une clé de magasin valide (configurée dans votre espace back office de la plate-forme FPAY).');
    }

    public static function merchantKeyInvalid(): static
    {
        return new static('FPAY_MERCHANT_KEY renseignée n\'est pas valide. Veuillez renseigner une clé de magasin qui ne contient aucun espace ou une chaîne de caractère vide.');
    }

    public static function merchantIdNotSpecified(): static
    {
        return new static('FPAY_MERCHANT_ID n\'a été renseigné. Vous devez fournir identifiant du marchand valide (attribué par le FPAY)).');
    }

    public static function merchantIdInvalid(): static
    {
        return new static('FPAY_MERCHANT_ID renseigné n\'est pas valide. Veuillez renseigner un identifiant du marchand qui ne contient aucun espace ou une chaîne de caractère vide.');
    }

    public static function attributeNotSpecified(string $attribute): static
    {
        return new static('Aucun(e) '.$attribute.' n\'a été renseigné(e). Veuillez le renseigner.');
    }

    public static function attributeInvalidString(string $attribute): static
    {
        return new static('La valeur de '.$attribute.' renseignée n\'est pas valide. Veuillez renseigner un(e) '.$attribute.' qui ne contient aucun espace ou une chaîne de caractère vide.');
    }

    public static function attributeInvalidUrl(string $attribute): static
    {
        return new static('L\'url '.$attribute.' renseigné n\'est pas valide. Veuillez renseigner un lien valide.');
    }

    public static function langValueInvalid(): static
    {
        return new static('La valeur de la langue par défaut n\'est pas valide. Valeurs possibles : ar, fr, en');
    }
}
