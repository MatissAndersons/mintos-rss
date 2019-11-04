<?php

namespace App\Services;

use FeedIo\Factory;
use FeedIo\FeedInterface;

class Feed
{
    /**
     * @var FeedInterface
     */
    protected $entries;

    /**
     * @var array
     */
    protected $processedEntries;

    /**
     * Returns feed with items containing title, description, time and link.
     * Also returns the count of the words.
     *
     * @return array
     */
    public function getFeed()
    {
        return $this->getProcessedEntries();
    }

    /**
     * Get statistics about words in the feed.
     *
     * @return array
     */
    public function getWordStatistics()
    {
        $text = '';
        $entries = $this->getProcessedEntries();
        foreach ($entries as $entry) {
            $description = strip_tags($entry['description']);
            $text .= sprintf('%s %s ', $entry['title'], $description);
        }

        return WordAnalysis::getWordCountExcludeCommon($text);
    }

    /**
     * Get entries from RSS_FEED_URL.
     */
    protected function downloadFeed()
    {
        if ($this->entries === null) {
            $url = env('RSS_FEED_URL');
            $feedIo = Factory::create()->getFeedIo();
            $this->entries = $feedIo->read($url)->getFeed();
        }

        return $this->entries;
    }

    /**
     * Process entries, keep only the necessary information: title,
     * description, time and link.
     *
     * @return array
     */
    protected function getProcessedEntries()
    {
        if ($this->processedEntries === null) {
            $entries = [];

            foreach ($this->downloadFeed() as $index => $entry) {
                $entries[] = [
                    'index' => $index,
                    'title' => $entry->getTitle(),
                    'description' => $entry->getDescription(),
                    'time' => $entry->getLastModified()->format('c'),
                    'link' => $entry->getLink(),
                ];
            }

            $this->processedEntries = $entries;
        }

        return $this->processedEntries;
    }
}
