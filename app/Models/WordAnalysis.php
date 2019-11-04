<?php

namespace App\Models;

class WordAnalysis
{
    /**
     * Splits text into words. Works also with apostrophes in the words, etc.
     * Discriminates numbers.
     *
     * @param string $text
     *
     * @return array
     */
    public static function getWordsFromText($text)
    {
        $text = strtolower($text);

        $split = preg_split('/[^a-zA-Z]*([\\s]+[^a-zA-Z]*|$)/', $text, -1, PREG_SPLIT_NO_EMPTY);

        if (!is_array($split)) {
            return [];
        }

        return $split;
    }

    /**
     * Get words from a text with their respective count.
     *
     * @param $text
     *
     * @return array
     */
    public static function getWordCount($text)
    {
        $words = static::getWordsFromText($text);
        $wordCount = array_count_values($words);
        return $wordCount;
    }

    /**
     * Get words from text with their respective count and exclude the most
     * common words according to Wikipedia.
     * https://en.wikipedia.org/wiki/Most_common_words_in_English
     *
     * @param $text
     * @param int $oecRank
     *
     * @return array
     */
    public static function getWordCountExcludeCommon($text, $oecRank = 50)
    {
        $wordCount = self::getWordCount($text);
        $commonWords = CommonWords::where('rank', '<=', $oecRank)
            ->pluck('id', 'word')
            ->toArray();

        $wordCount = array_diff_key($wordCount, $commonWords);
        arsort($wordCount);
        $wordCount = array_splice($wordCount, 0, 10);

        $counts = [];
        foreach ($wordCount as $word => $count) {
            $counts[] = [
                'word' => $word,
                'count' => $count
            ];
        }

        return $counts;
    }
}
