<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PublisherResource;
use App\Models\Advertiser;
use App\Models\User;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    public function index()
    {
        return new PublisherResource(User::wherePosition('publisher')->paginate());
    }

    public function affiliates(Request $request)
    {
        $publishers = User::wherePosition('publisher')->whereTeam('affiliate');
        if ($request->advertiser_id) {
            $publisherIds = $this->advertiserPublishersIds($request->advertiser_id);
            $publishers = $publishers->whereIn('id', $publisherIds);
        }
        $publishers = $publishers->paginate();
        return new PublisherResource($publishers);
    }

    public function influencers(Request $request)
    {

        $publishers = User::wherePosition('publisher')->whereTeam('influencer');
        if ($request->advertiser_id) {
            $publisherIds = $this->advertiserPublishersIds($request->advertiser_id);
            $publishers = $publishers->whereIn('id', $publisherIds);
        }
        $publishers = $publishers->paginate();
        return new PublisherResource($publishers);
    }

    public function advertiserPublishersIds($advertiserId)
    {
        $advertiser = Advertiser::findOrFail($advertiserId);
        $publisherIds = array();
        foreach ($advertiser->offers as $offer) {
            array_push($publisherIds,);
            $newPublisherIds = $offer->coupons->where('user_id', '!=', null)->pluck('user_id')->toArray();
            $publisherIds =  array_merge($publisherIds, array_unique($newPublisherIds));
        }
        return $publisherIds;
    }
}
