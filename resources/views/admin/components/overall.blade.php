 <h3 class="card-title align-items-start flex-column">
<span class="card-label font-weight-bolder text-dark">{{ __('Main Dashboard') }}</span>
<span class="text-muted mt-3 font-weight-bold font-size-sm"> {{ __('More than ') . App\Models\Offer::count() . __(' offer ') .  __('ًWith More than ')  . $offers->count() . __(' offer') }} </span>
</h3>

<div class="table-responsive">
    <table class="table table-head-custom table-head-bg  table-vertical-center text-center" border="1">
        <thead>
        <tr class="text-left text-uppercase">
            <th style="min-width: 250px" class="pl-7">
                <span class="text-dark-75">{{ __('Offer') }}</span>
            </th>
            <th style="min-width: 100px">{{ __('Team') }}</th>
            <th style="min-width: 100px">{{ __('Orders') }}</th>
            <th style="min-width: 100px">{{ __('Sales') }}</th>
            <th style="min-width: 100px">{{ __('Revenue') }}</th>
            <th style="min-width: 100px">{{ __('Payout') }}</th>
            <th style="min-width: 130px">{{ __('Gross Margin') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($offers as $offer)
            <tr>
                <td class="pl-0 py-8" rowspan="4">
                    <div class="d-flex align-items-center justify-content-center">
                        <div class="symbol symbol-50 symbol-light">
                        <span class="symbol-label">
                            <img src="{{  getImagesPath('Offers', $offer->thumbnail)}}" class="h-75 align-self-end" alt=""/>
                        </span>
                        </div>
                        <div>
                            <a href="#" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">{{ $offer->name }}</a>
                        </div>
                    </div>
                </td>
            </tr>

            <tr>
                <td>
                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ __('Influencer') }}</span>
                </td>
                <td>
                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $offer->reportPerTeam('influencer')->first()->orders ?? 0 }}</span>
                </td>
                <td>
                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $offer->reportPerTeam('influencer')->first()->sales ?? 0 }}$</span>
                </td>
                <td>
                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $offer->reportPerTeam('influencer')->first()->revenue ?? 0 }}$</span>
                </td>
                <td>
                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $offer->reportPerTeam('influencer')->first()->payout ?? 0 }}$</span>
                </td>
                <td>
                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ (isset($offer->reportPerTeam('influencer')->first()->revenue) && isset($offer->reportPerTeam('influencer')->first()->payout)) ? $offer->reportPerTeam('influencer')->first()->revenue - $offer->reportPerTeam('influencer')->first()->payout : 0 }}$</span>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ __('Affiliate') }}</span>
                </td>
                <td>
                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $offer->reportPerTeam('affiliate')->first()->orders ?? 0}}</span>
                </td>
                <td>
                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $offer->reportPerTeam('affiliate')->first()->sales ?? 0}}$</span>
                </td>
                <td>
                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $offer->reportPerTeam('affiliate')->first()->revenue ?? 0}}$</span>
                </td>
                <td>
                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $offer->reportPerTeam('affiliate')->first()->payout ?? 0}}$</span>
                </td>
                <td>
                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ (isset($offer->reportPerTeam('affiliate')->first()->revenue) && isset($offer->reportPerTeam('affiliate')->first()->payout)) ? $offer->reportPerTeam('affiliate')->first()->revenue - $offer->reportPerTeam('affiliate')->first()->payout : 0 }}$</span>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ __('Media Buying') }}</span>
                </td>
                <td>
                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $offer->reportPerTeam('media_buying')->first()->orders ?? 0}}</span>
                </td>
                <td>
                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $offer->reportPerTeam('media_buying')->first()->sales ?? 0}}$</span>
                </td>
                <td>
                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $offer->reportPerTeam('media_buying')->first()->revenue ?? 0}}$</span>
                </td>
                <td>
                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $offer->reportPerTeam('media_buying')->first()->payout ?? 0}}$</span>
                </td>
                <td>
                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ (isset($offer->reportPerTeam('media_buying')->first()->revenue) && isset($offer->reportPerTeam('media_buying')->first()->payout)) ? $offer->reportPerTeam('media_buying')->first()->revenue - $offer->reportPerTeam('media_buying')->first()->payout : 0 }}$</span>
                </td>
            </tr>

        @endforeach
        {{-- All numbers --}}
        <tr>
            <td></td>
            <td class="text-center">
                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ __('Total') }}</span>
            </td>
            <td>
                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $totalNumbers->orders ?? 0 }}</span>
            </td>
            <td>
                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $totalNumbers->sales ?? 0 }}$</span>
            </td>
            <td>
                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $totalNumbers->revenue ?? 0 }}$</span>
            </td>
            <td>
                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $totalNumbers->payout ?? 0 }}$</span>
            </td>
            <td>
                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{  (isset($totalNumbers->revenue) && isset($totalNumbers->payout)) ? $totalNumbers->revenue - $totalNumbers->payout : 0 }}$</span>
            </td>
        </tr>
        {{--  Seperate per team --}}
        {{-- Influencers --}}
        <tr>
            <td rowspan="2">
                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ __('Influncers') }}</span>
            </td>
            <td>
                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ __('Total') }}</span>
            </td>
            <td>
                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $totalInfluencerNumbers->orders ?? 0}}</span>
            </td>
            <td>
                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $totalInfluencerNumbers->sales ?? 0}}$</span>
            </td>
            <td>
                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $totalInfluencerNumbers->revenue ?? 0}}$</span>
            </td>
            <td>
                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $totalInfluencerNumbers->payout ?? 0}}$</span>
            </td>
            <td>
                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ (isset($totalInfluencerNumbers->revenue) && isset($totalInfluencerNumbers->payout)) ? $totalInfluencerNumbers->revenue - $totalInfluencerNumbers->payout : 0 }}$</span>
            </td>
        </tr>
        <tr>
            <td>
                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ __('Persentage') }}</span>
            </td>
            <td>
                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ (isset($totalInfluencerNumbers->orders) && isset($totalNumbers->orders)) ? number_format(($totalInfluencerNumbers->orders / $totalNumbers->orders) * 100 ,2) : 0 }}%</span>
            </td>
            <td>
                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ (isset($totalInfluencerNumbers->sales) && isset($totalNumbers->sales)) ? number_format(($totalInfluencerNumbers->sales / $totalNumbers->sales)  * 100,2) : 0 }}%</span>
            </td>
            <td>
                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ (isset($totalInfluencerNumbers->revenue) && isset($totalNumbers->revenue)) ? number_format(($totalInfluencerNumbers->revenue / $totalNumbers->revenue) * 100,2) : 0 }}%</span>
            </td>
            <td>
                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ (isset($totalInfluencerNumbers->payout) && isset($totalNumbers->payout)) ? number_format(($totalInfluencerNumbers->payout  / $totalNumbers->payout)  * 100,2) : 0 }}%</span>
            </td>
            <td>
                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ (isset($totalInfluencerNumbers->revenue) && isset($totalInfluencerNumbers->payout) && isset($totalNumbers->revenue) && isset($totalNumbers->payout) && ($totalInfluencerNumbers->revenue - $totalInfluencerNumbers->payout != 0) ) ? number_format((($totalInfluencerNumbers->revenue - $totalInfluencerNumbers->payout) / ($totalNumbers->revenue - $totalNumbers->payout)) * 100,2) : 0 }}%</span>
            </td>
        </tr>
        {{-- Affiliates --}}
        <tr>
            <td rowspan="2">
                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ __('Affiliate') }}</span>
            </td>
            <td>
                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ __('Total') }}</span>
            </td>
            <td>
                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $totalAffiliateNumbers->orders ?? 0 }}</span>
            </td>
            <td>
                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $totalAffiliateNumbers->sales ?? 0 }}$</span>
            </td>
            <td>
                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $totalAffiliateNumbers->revenue ?? 0 }}$</span>
            </td>
            <td>
                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $totalAffiliateNumbers->payout ?? 0 }}$</span>
            </td>
            <td>
                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ (isset($totalAffiliateNumbers->revenue) && isset($totalAffiliateNumbers->payout)) ? $totalAffiliateNumbers->revenue - $totalAffiliateNumbers->payout : 0 }}$</span>
            </td>
        </tr>
        <tr>
            <td>
                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ __('Persentage') }}</span>
            </td>
            <td>
                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ (isset($totalAffiliateNumbers->orders) &&  isset($totalNumbers->orders)) ? number_format(($totalAffiliateNumbers->orders / $totalNumbers->orders) * 100  ,2) : 0 }}%</span>
            </td>
            <td>
                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ (isset($totalAffiliateNumbers->sales) &&  isset($totalNumbers->sales)) ? number_format(($totalAffiliateNumbers->sales / $totalNumbers->sales)  * 100 ,2) : 0 }}%</span>
            </td>
            <td>
                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ (isset($totalAffiliateNumbers->revenue) &&  isset($totalNumbers->revenue)) ? number_format(($totalAffiliateNumbers->revenue / $totalNumbers->revenue) * 100 ,2) : 0 }}%</span>
            </td>
            <td>
                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ (isset($totalAffiliateNumbers->payout) &&  isset($totalNumbers->payout)) ? number_format(($totalAffiliateNumbers->payout  / $totalNumbers->payout)  * 100 ,2) : 0 }}%</span>
            </td>
            <td>
                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ (isset($totalAffiliateNumbers->revenue) && isset($totalAffiliateNumbers->payout) && isset($totalNumbers->revenue) && isset($totalNumbers->payout) && ($totalAffiliateNumbers->revenue - $totalAffiliateNumbers->payout != 0) )  ? number_format((($totalAffiliateNumbers->revenue - $totalAffiliateNumbers->payout) / ($totalNumbers->revenue - $totalNumbers->payout)) * 100,2) : 0 }}%</span>
            </td>
        </tr>
        {{-- Media Buying --}}
        <tr>
            <td rowspan="2">
                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ __('Media Buying') }}</span>
            </td>
            <td>
                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ __('Total') }}</span>
            </td>
            <td>
                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $totalMediaBuyingNumbers->orders ?? 0 }}</span>
            </td>
            <td>
                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $totalMediaBuyingNumbers->sales ?? 0 }}$</span>
            </td>
            <td>
                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $totalMediaBuyingNumbers->revenue ?? 0 }}$</span>
            </td>
            <td>
                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $totalMediaBuyingNumbers->payout ?? 0 }}$</span>
            </td>
            <td>
                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ (isset($totalMediaBuyingNumbers->revenue) && isset($totalMediaBuyingNumbers->payout)) ?  $totalMediaBuyingNumbers->revenue - $totalMediaBuyingNumbers->payout : 0 }}$</span>
            </td>
        </tr>
        <tr>
            <td>
                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ __('Persentage') }}</span>
            </td>
            <td>
                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ (isset($totalMediaBuyingNumbers->orders) && isset($totalNumbers->orders)) ? number_format(($totalMediaBuyingNumbers->orders / $totalNumbers->orders) * 100,2) : 0 }}%</span>
            </td>
            <td>
                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ (isset($totalMediaBuyingNumbers->sales) && isset($totalNumbers->sales)) ? number_format(($totalMediaBuyingNumbers->sales / $totalNumbers->sales)  * 100,2) : 0 }}%</span>
            </td>
            <td>
                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ (isset($totalMediaBuyingNumbers->revenue) && isset($totalNumbers->revenue)) ? number_format(($totalMediaBuyingNumbers->revenue / $totalNumbers->revenue) * 100,2) : 0 }}%</span>
            </td>
            <td>
                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ (isset($totalMediaBuyingNumbers->payout) && isset($totalNumbers->payout)) ? number_format(($totalMediaBuyingNumbers->payout  / $totalNumbers->payout)  * 100,2) : 0 }}%</span>
            </td>
            <td>
                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ (isset($totalMediaBuyingNumbers->revenue) && isset($totalMediaBuyingNumbers->payout) && isset($totalNumbers->revenue) && isset($totalNumbers->payout) && ($totalMediaBuyingNumbers->revenue - $totalMediaBuyingNumbers->payout != 0)) ? number_format((($totalMediaBuyingNumbers->revenue - $totalMediaBuyingNumbers->payout) / ($totalNumbers->revenue - $totalNumbers->payout)) * 100,2) : 0 }}%</span>
            </td>
        </tr>
        </tbody>
    </table>
</div>
