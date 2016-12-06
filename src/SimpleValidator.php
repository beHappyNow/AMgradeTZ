<?php
namespace AMgradeTZ\GeoCoding;

class SimpleValidator implements IValidator
{

    /** @var object ILanguagesProvider  */
    private $languagesProvider;

    public function setLanguagesProvider(ILanguagesProvider $lp)
    {
        $this->languagesProvider = $lp;
    }

    public static function validateKey($key)
    {
        if (!is_string($key)) {
            throw new \InvalidArgumentException('Переданный токен не является строкой.');
        }
        if (strlen($key) < 4) {
            throw new \InvalidArgumentException('Ключ "' . $key . '" слишком короткий, и не является валидным.');
        }
        return true;
    }

    public static function validateDirection($direction)
    {
        if ($direction !== GeoCodingClient::STRAIGHT && $direction !== GeoCodingClient::REVERSE ) {
            throw new \InvalidArgumentException('Assigned value of direction is not valid');
        }
        return true;
    }

    public function validateLanguage($lang)
    {
        if (in_array($lang, $this->languagesProvider->getLanguages())) {
            return true;
        }
        throw new \InvalidArgumentException('Assigned value of language is not valid');
    }
}
