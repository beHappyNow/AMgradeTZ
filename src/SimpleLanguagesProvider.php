<?php
namespace AMgradeTZ\GeoCoding;

class SimpleLanguagesProvider implements ILanguagesProvider
{
    public static function getLanguages()
    {
        return ['ar','bg','bn','ca','cs','da','de','el','en','en-AU','en-GB','es','eu','fa','fi','fil','fr','gl','gu',
            'hi','hr', 'hu','id','it','iw','ja','kn','ko','lt','lv','ml','mr','nl','no','pl','pt','pt-BR','pt-PT','ro',
            'ru','sk','sl','sr','sv','ta','te','th','tl','tr','uk','vi','zh-CN','zh-TW'];
    }
}