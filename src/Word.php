<?php

namespace WL;

class Word
{
    const ALPHABET = ['а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я'];

    public static function getMorphlings($word, &$usedWords, Dictionary $dictionary)
    {
        $morphlings = [];

        for ($i = 0; $i < mb_strlen($word); $i++) {
            foreach (self::ALPHABET as $letter) {
                $newWord = mb_substr($word, 0, $i) . $letter . mb_substr($word, $i + 1);
                
                if ($newWord != $word && !in_array($newWord, $usedWords) && $dictionary->containsWord($newWord)) {
                    array_push($morphlings, $newWord);
                    array_push($usedWords, $newWord);
                }
            }
        }

        return $morphlings;
    }
}
