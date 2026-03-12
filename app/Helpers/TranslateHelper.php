<?php

namespace App\Helpers;

use Stichoza\GoogleTranslate\GoogleTranslate;

class TranslateHelper
{
    public static function toEnglish(?string $text): ?string
    {
        if (blank($text)) return null;

        try {
            $tr = new GoogleTranslate();
            $tr->setOptions(['timeout' => 5]);
            return $tr->setSource('id')->setTarget('en')->translate($text);
        } catch (\Exception $e) {
            return null;
        }
    }
}
