<?php
namespace AMgradeTZ\GeoCoding;

interface IValidator
{
    public function setLanguagesProvider(ILanguagesProvider $lp);
    public static function validateKey($key);
    public static function validateDirection($direction);
    public function validateLanguage($lang);
}