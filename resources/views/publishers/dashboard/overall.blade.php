 <!--begin::Col-->
     <div class="col-xl-12 mb-5 mb-xl-12">
        <!--begin::Table Widget 4-->
        <div class="card card-flush h-xl-100">
            <!--begin::Card header-->
            <div class="card-header pt-7">
                <!--begin::Title-->
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-800">Main Dashboard</span>
                </h3>
                <!--end::Title-->
    
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-2">
                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-3 table-hover  dataTable no-footer" >
                    <!--begin::Table head-->
                    <thead>
                        <!--begin::Table row-->
                        <tr class="text-center text-gray-800 fw-bold fs-7 text-uppercase gs-0">
                            <th class="min-w-100px">Offer</th>
                            <th class="text-start min-w-100px">Team</th>
                            <th class="text-start min-w-125px">Orders</th>
                            <th class="text-start min-w-100px">Sales</th>
                            <th class="text-start min-w-100px">Revenue</th>
                            <th class="text-start min-w-100px">Payout</th>
                            <th class="text-start min-w-100px">Gross Margin</th>
                        </tr>
                        <!--end::Table row-->
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody class="fw-bold text-gray-700">
                        @foreach($maps as $index => $map)
                        {{-- @if($index == 24) --}}
                            <tr class="separate-tr">
                                <td rowspan="5" class="text-center">
                                    <div class="symbol symbol-100px mb-3">
                                        <img src="{{ getImagesPath('Offers', '') }}" class="h-75 align-self-end" alt="" />
                                    </div>
                                    <br>
                                    <a href="{{ route('admin.offers.show', $map['offer']['id']) }}" class="text-gray-800 text-hover-primary">{{ $map['offer']['name'] }}</a>
                                    
                                </td>
                                
                            </tr>
                            <tr>
                                <td class="text-start">Influncers</td>
                                <td class="text-start">{{ isset($map['team']['influencer']) ? $map['team']['influencer']['orders'] : 0 }}</td>
                                <td class="text-start">{{ isset($map['team']['influencer']) ? round( $map['team']['influencer']['sales'], 2) : 0 }}$</td>
                                <td class="text-start">{{ isset($map['team']['influencer']) ? round( $map['team']['influencer']['revenue'], 2) : 0 }}$</td>
                                <td class="text-start">{{ isset($map['team']['influencer']) ? round( $map['team']['influencer']['payout'], 2) : 0 }}$</td>
                                <td class="text-start">{{ isset($map['team']['influencer']) ? round( $map['team']['influencer']['gross_margin'], 2) : 0 }}$</td>
                            </tr>
                            <tr>
                                <td class="text-start">Affiliates</td>
                                <td class="text-start">{{ isset($map['team']['affiliate']) ? $map['team']['affiliate']['orders'] : 0 }}</td>
                                <td class="text-start">{{ isset($map['team']['affiliate']) ? round( $map['team']['affiliate']['sales'], 2) : 0 }}$</td>
                                <td class="text-start">{{ isset($map['team']['affiliate']) ? round( $map['team']['affiliate']['revenue'], 2) : 0 }}$</td>
                                <td class="text-start">{{ isset($map['team']['affiliate']) ? round( $map['team']['affiliate']['payout'], 2) : 0 }}$</td>
                                <td class="text-start">{{ isset($map['team']['affiliate']) ? round( $map['team']['affiliate']['gross_margin'], 2) : 0 }}$</td>
                            </tr>
                            <tr>
                                <td class="text-start">Organic</td>
                                <td class="text-start">{{ isset($map['team']['media_buying']) ? $map['team']['media_buying']['orders'] : 0 }}</td>
                                <td class="text-start">{{ isset($map['team']['media_buying']) ? round( $map['team']['media_buying']['sales'], 2) : 0 }}$</td>
                                <td class="text-start">{{ isset($map['team']['media_buying']) ? round( $map['team']['media_buying']['revenue'], 2) : 0 }}$</td>
                                <td class="text-start">{{ isset($map['team']['media_buying']) ? round( $map['team']['media_buying']['payout'], 2) : 0 }}$</td>
                                <td class="text-start">{{ isset($map['team']['media_buying']) ? round( $map['team']['media_buying']['gross_margin'], 2) : 0 }}$</td>
                            </tr>
                            <tr class="separate-tr">
                                <td class="text-start">Total</td>
                                <td class="text-start">{{ $map['offer']['orders'] }}</td>
                                <td class="text-start">{{ round( $map['offer']['sales'], 2) }}$</td>
                                <td class="text-start">{{ round( $map['offer']['revenue'], 2) }}$</td>
                                <td class="text-start">{{ round( $map['offer']['payout'], 2) }}$</td>
                                <td class="text-start">{{ round( $map['offer']['gross_margin'], 2) }}$</td>
                            </tr>
                            {{-- @endif --}}
                            @endforeach
                            {{-- All numbers --}}
                            <tr>
                                <td></td>
                                <td class="text-start">
                                    <span class="text-start text-gray-800 fw-bold">{{ __('All Totals') }}</span>
                                </td>
                                <td>
                                    <span class="text-start text-gray-800 fw-bold">{{ $totalNumbers->orders ?? 0 }}</span>
                                </td>
                                <td>
                                    <span class="text-start text-gray-800 fw-bold">{{  round($totalNumbers->sales ?? 0, 2) }}$</span>
                                </td>
                                <td>
                                    <span class="text-start text-gray-800 fw-bold">{{  round($totalNumbers->revenue ?? 0, 2) }}$</span>
                                </td>
                                <td>
                                    <span class="text-start text-gray-800 fw-bold">{{  round($totalNumbers->payout ?? 0, 2) }}$</span>
                                </td>
                                <td>
                                    <span class="text-start text-gray-800 fw-bold">{{  (isset($totalNumbers->revenue) && isset($totalNumbers->payout)) ? round($totalNumbers->revenue - $totalNumbers->payout, 2) : 0 }}$</span>
                                </td>
                            </tr>
                            {{--  Seperate per team --}}
                            {{-- Influencers --}}
                            <tr>
                                <td rowspan="2">
                                    <span>{{ __('Influncers') }}</span>
                                </td>
                                <td>
                                    <span>{{ __('Total') }}</span>
                                </td>
                                <td>
                                    <span>{{ round($totalInfluencerNumbers->orders ?? 0 , 2)}}</span>
                                </td>
                                <td>
                                    <span>{{ round($totalInfluencerNumbers->sales ?? 0 , 2)}}$</span>
                                </td>
                                <td>
                                    <span>{{ round($totalInfluencerNumbers->revenue ?? 0 , 2)}}$</span>
                                </td>
                                <td>
                                    <span>{{ round($totalInfluencerNumbers->payout ?? 0 , 2)}}$</span>
                                </td>
                                <td>
                                    <span>{{ (isset($totalInfluencerNumbers->revenue) && isset($totalInfluencerNumbers->payout)) ? number_format((float)$totalInfluencerNumbers->revenue - $totalInfluencerNumbers->payout, 2, '.', '')  : 0 }}$</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span>{{ __('Percentage') }}</span>
                                </td>
                                <td>
                                    <span>{{ (isset($totalInfluencerNumbers->orders) && isset($totalNumbers->orders)) ? number_format(($totalInfluencerNumbers->orders / $totalNumbers->orders) * 100 ,2) : 0 }}%</span>
                                </td>
                                <td>
                                    <span>{{ (isset($totalInfluencerNumbers->sales) && isset($totalNumbers->sales)) ? number_format(($totalInfluencerNumbers->sales / $totalNumbers->sales)  * 100,2) : 0 }}%</span>
                                </td>
                                <td>
                                    <span>{{ (isset($totalInfluencerNumbers->revenue) && isset($totalNumbers->revenue)) ? number_format(($totalInfluencerNumbers->revenue / $totalNumbers->revenue) * 100,2) : 0 }}%</span>
                                </td>
                                <td>
                                    <span>{{ (isset($totalInfluencerNumbers->payout) && isset($totalNumbers->payout)) ? number_format(($totalInfluencerNumbers->payout  / $totalNumbers->payout)  * 100,2) : 0 }}%</span>
                                </td>
                                <td>
                                    <span>{{ (isset($totalInfluencerNumbers->revenue) && isset($totalInfluencerNumbers->payout) && isset($totalNumbers->revenue) && isset($totalNumbers->payout) && ($totalInfluencerNumbers->revenue - $totalInfluencerNumbers->payout != 0) ) ? number_format((($totalInfluencerNumbers->revenue - $totalInfluencerNumbers->payout) / ($totalNumbers->revenue - $totalNumbers->payout)) * 100,2) : 0 }}%</span>
                                </td>
                            </tr>
                            {{-- Affiliates --}}
                            <tr>
                                <td rowspan="2">
                                    <span>{{ __('Affiliate') }}</span>
                                </td>
                                <td>
                                    <span>{{ __('Total') }}</span>
                                </td>
                                <td>
                                    <span>{{ round($totalAffiliateNumbers->orders ?? 0 , 2) }}</span>
                                </td>
                                <td>
                                    <span>{{ round($totalAffiliateNumbers->sales ?? 0 , 2) }}$</span>
                                </td>
                                <td>
                                    <span>{{ round($totalAffiliateNumbers->revenue ?? 0 , 2) }}$</span>
                                </td>
                                <td>
                                    <span>{{ round($totalAffiliateNumbers->payout ?? 0 , 2) }}$</span>
                                </td>
                                <td>
                                    <span>{{ (isset($totalAffiliateNumbers->revenue) && isset($totalAffiliateNumbers->payout)) ? number_format((float)$totalAffiliateNumbers->revenue - $totalAffiliateNumbers->payout, 2, '.', '')  : 0 }}$</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span>{{ __('Percentage') }}</span>
                                </td>
                                <td>
                                    <span>{{ (isset($totalAffiliateNumbers->orders) &&  isset($totalNumbers->orders)) ? number_format(($totalAffiliateNumbers->orders / $totalNumbers->orders) * 100  ,2) : 0 }}%</span>
                                </td>
                                <td>
                                    <span>{{ (isset($totalAffiliateNumbers->sales) &&  isset($totalNumbers->sales)) ? number_format(($totalAffiliateNumbers->sales / $totalNumbers->sales)  * 100 ,2) : 0 }}%</span>
                                </td>
                                <td>
                                    <span>{{ (isset($totalAffiliateNumbers->revenue) &&  isset($totalNumbers->revenue)) ? number_format(($totalAffiliateNumbers->revenue / $totalNumbers->revenue) * 100 ,2) : 0 }}%</span>
                                </td>
                                <td>
                                    <span>{{ (isset($totalAffiliateNumbers->payout) &&  isset($totalNumbers->payout)) ? number_format(($totalAffiliateNumbers->payout  / $totalNumbers->payout)  * 100 ,2) : 0 }}%</span>
                                </td>
                                <td>
                                    <span>{{ (isset($totalAffiliateNumbers->revenue) && isset($totalAffiliateNumbers->payout) && isset($totalNumbers->revenue) && isset($totalNumbers->payout) && ($totalAffiliateNumbers->revenue - $totalAffiliateNumbers->payout != 0) )  ? number_format((($totalAffiliateNumbers->revenue - $totalAffiliateNumbers->payout) / ($totalNumbers->revenue - $totalNumbers->payout)) * 100,2) : 0 }}%</span>
                                </td>
                            </tr>
                            {{-- Organic Orders --}}
                            <tr>
                                <td rowspan="2">
                                    <span>{{ __('Organic Orders') }}</span>
                                </td>
                                <td>
                                    <span>{{ __('Total') }}</span>
                                </td>
                                <td>
                                    <span>{{ round($totalMediaBuyingNumbers->orders ?? 0, 2) }}</span>
                                </td>
                                <td>
                                    <span>{{ round($totalMediaBuyingNumbers->sales ?? 0, 2) }}$</span>
                                </td>
                                <td>
                                    <span>{{ round($totalMediaBuyingNumbers->revenue ?? 0, 2) }}$</span>
                                </td>
                                <td>
                                    <span>{{ round($totalMediaBuyingNumbers->payout ?? 0, 2) }}$</span>
                                </td>
                                <td>
                                    <span>{{ (isset($totalMediaBuyingNumbers->revenue) && isset($totalMediaBuyingNumbers->payout)) ?  round($totalMediaBuyingNumbers->revenue - $totalMediaBuyingNumbers->payout, 2) : 0 }}$</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span>{{ __('Percentage') }}</span>
                                </td>
                                <td>
                                    <span>{{ (isset($totalMediaBuyingNumbers->orders) && isset($totalNumbers->orders)) ? number_format(($totalMediaBuyingNumbers->orders / $totalNumbers->orders) * 100,2) : 0 }}%</span>
                                </td>
                                <td>
                                    <span>{{ (isset($totalMediaBuyingNumbers->sales) && isset($totalNumbers->sales)) ? number_format(($totalMediaBuyingNumbers->sales / $totalNumbers->sales)  * 100,2) : 0 }}%</span>
                                </td>
                                <td>
                                    <span>{{ (isset($totalMediaBuyingNumbers->revenue) && isset($totalNumbers->revenue)) ? number_format(($totalMediaBuyingNumbers->revenue / $totalNumbers->revenue) * 100,2) : 0 }}%</span>
                                </td>
                                <td>
                                    <span>{{ (isset($totalMediaBuyingNumbers->payout) && isset($totalNumbers->payout)) ? number_format(($totalMediaBuyingNumbers->payout  / $totalNumbers->payout)  * 100,2) : 0 }}%</span>
                                </td>
                                <td>
                                    <span>{{ (isset($totalMediaBuyingNumbers->revenue) && isset($totalMediaBuyingNumbers->payout) && isset($totalNumbers->revenue) && isset($totalNumbers->payout) && ($totalMediaBuyingNumbers->revenue - $totalMediaBuyingNumbers->payout != 0)) ? number_format((($totalMediaBuyingNumbers->revenue - $totalMediaBuyingNumbers->payout) / ($totalNumbers->revenue - $totalNumbers->payout)) * 100,2) : 0 }}%</span>
                                </td>
                            </tr>
                    </tbody>
                    <!--end::Table body-->
                </table>
                <!--end::Table-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Table Widget 4-->
    </div>
    <!--end::Col-->
