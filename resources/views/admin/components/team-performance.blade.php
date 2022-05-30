
<h3 class="card-title align-items-start flex-column">
    <span class="card-label font-weight-bolder text-dark">{{ __('Main Dashboard') }}</span>
    <span class="text-muted mt-3 font-weight-bold font-size-sm"> {{ __('More than ') . App\Models\Offer::count() . __(' offer ') .  __('ًWith More than ')  . $offers->count() . __(' offer') }} </span>
    </h3>
    
    <div class="table-responsive">
        <table class="table table-head-custom table-head-bg  table-vertical-center text-center" border="1">
            <thead>
            <tr class="text-center text-uppercase">
                <th style="min-width: 250px" class="pl-7">
                    <span class="text-dark-75">{{ __('Team') }}</span>
                </th>
                <th style="min-width: 100px">{{ __('Orders') }}</th>
                <th style="min-width: 100px">{{ __('Revenue') }}</th>
                <th style="min-width: 100px">{{ __('AM') }}</th>
                <th style="min-width: 100px">{{ __('Orders') }}</th>
                <th style="min-width: 100px">{{ __('Revenue') }}</th>
            </tr>
            </thead>
            <tbody>
                {{-- @if($teamPerformance) --}}
                {{-- @foreach($teamPerformance as $team)
                <tr>
                    <td rowspan="{{ publisherPerformanceBasedOnTeam($team->team)->groupBy('user')->count() + 1}}">
                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ Str::headline($team->team)}}</span>
                    </td>
                    <td rowspan="{{ publisherPerformanceBasedOnTeam($team->team)->groupBy('user')->count() + 1}}">
                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $team->orders }}</span>
                    </td>
                    <td rowspan="{{ publisherPerformanceBasedOnTeam($team->team)->groupBy('user')->count() + 1}}">
                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $team->revenue }}$</span>
                    </td>

                </tr>
                    @foreach(publisherPerformanceBasedOnTeam($team->team)->groupBy('user') as $publisher)
                    <tr>
                        <td>
                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $publisher->first()->user }}</span>
                        </td>
                        <td>
                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $publisher->first()->revenue }}$</span>
                        </td>
                        <td>
                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $publisher->first()->orders }}$</span>
                        </td>
                    </tr>
                    @endforeach
                @endforeach
                @else
                    <tr>
                        <td colspan="6">
                            <div class="alert alert-warning">No Data</div>
                        </td>
                    </tr>
                @endif --}}
            </tbody>
        </table>
    </div>
    