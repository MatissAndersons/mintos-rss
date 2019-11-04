<?php

use App\Models\WordAnalysis;

class WordAnalysisTest extends TestCase
{
    public function testSentenceSplit()
    {
        $sentence = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.';
        $words = [
            'lorem',
            'ipsum',
            'dolor',
            'sit',
            'amet',
            'consectetur',
            'adipiscing',
            'elit',
        ];
        $this->assertEquals($words, WordAnalysis::getWordsFromText($sentence), 'Words are not split correctly.');
    }

    public function testWordCount()
    {
        $sentence = 'Lorem ipsum dolor. Lorem ipsum. Lorem.';
        $wordCount = [
            'lorem' => 3,
            'ipsum' => 2,
            'dolor' => 1,
        ];
        $this->assertEquals($wordCount, WordAnalysis::getWordCount($sentence), 'Words are not counted correctly.');
    }
}
