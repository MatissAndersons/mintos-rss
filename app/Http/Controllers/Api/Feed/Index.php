<?php

namespace App\Http\Controllers\Api\Feed;

use App\Services\Feed;
use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Routing\Controller;

class Index extends Controller
{
    /**
     * @var Feed
     */
    protected $feedService;

    /**
     * Index constructor.
     *
     * @param Feed $feedService
     */
    public function __construct(Feed $feedService)
    {
        $this->middleware('auth');
        $this->feedService = $feedService;
    }

    /**
     * Returns feed with items containing title, description, time and link.
     * Also returns the count of the words.
     *
     * @return JsonResponse
     */
    public function getFeed()
    {
        $entries = $this->feedService->getFeed();
        $counts = $this->feedService->getWordStatistics();

        return response()->json(compact('entries', 'counts'));
    }
}
