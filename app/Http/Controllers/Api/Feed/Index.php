<?php

namespace App\Http\Controllers\Api\Feed;

use App\Models\WordAnalysis;
use FeedIo\Factory;
use FeedIo\FeedInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Lumen\Routing\Controller;

class Index extends Controller
{
    /**
     * Index constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Returns feed with items containing title, description, time and link.
     * Also returns the count of the words.
     *
     * @return JsonResponse
     */
    public function getFeed()
    {
        $text = '';
        $entries = $this->processEntries();
        foreach ($entries as $entry) {
            $description = strip_tags($entry['description']);
            $text .= sprintf('%s %s ', $entry['title'], $description);
        }

        $counts = WordAnalysis::getWordCountExcludeCommon($text);

        return response()->json(compact('entries', 'counts'));
    }

    /**
     * Get entries from RSS_FEED_URL.
     *
     * @return FeedInterface
     */
    protected function getEntries()
    {
        $url = env('RSS_FEED_URL');
        $feedIo = Factory::create()->getFeedIo();

        return $feedIo->read($url)->getFeed();
    }

    /**
     * Process entries, keep only the necessary information: title,
     * description, time and link.
     *
     * @return array
     */
    protected function processEntries()
    {
        $entries = [];

        foreach ($this->getEntries() as $index => $entry) {
            $entries[] = [
                'index' => $index,
                'title' => $entry->getTitle(),
                'description' => $entry->getDescription(),
                'time' => $entry->getLastModified()->format('c'),
                'link' => $entry->getLink(),
            ];
        }

        return $entries;
    }
}
