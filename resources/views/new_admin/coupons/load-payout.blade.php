<div class="table-responsive">
    <table class="table table-hover table-rounded table-striped border gy-7 gs-7">
        <thead>
            <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                <th>Payout Type</th>
                <th>Payout</th>
                <th>New Payout</th>
                <th>Old Payout</th>
                <th>From Slab</th>
                <th>To Slab</th>
                <th>From Date</th>
                <th>To Date</th>
                <th>Countries</th>
            </tr>
        </thead>
        <tbody>
            {{-- @dd($coupon->cps->where('type', 'payout')) --}}
            @foreach ($coupon->cps->where('type', 'payout') as $payout)
                <tr>
                    <td>{{ $payout->amount_type }}</td>
                    <td>{{ $payout->amount }}</td>
                    <td>{{ $payout->new_amount }}</td>
                    <td>{{ $payout->old_amount }}</td>
                    <td>{{ $payout->from }}</td>
                    <td>{{ $payout->to }}</td>
                    <td>{{ $payout->from_date }}</td>
                    <td>{{ $payout->to_date }}</td>
                    <td>
                        @php($countryIds = json_decode($payout->countries_ids, true))
                        @if ($countryIds)
                            @foreach (json_decode($payout->countries_ids, true) as $countryId)
                                <span
                                    class="badge badge-light m-1">{{ App\Models\Country::where('id', $countryId)->first() ? App\Models\Country::where('id', $countryId)->first()->name_en : '' }}</span>
                            @endforeach
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
