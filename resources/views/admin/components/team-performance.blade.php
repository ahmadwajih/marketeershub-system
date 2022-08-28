
<h3 class="card-title align-items-start flex-column">
    <span class="card-label font-weight-bolder text-dark">{{ __('Main Dashboard') }}</span>
    <span class="text-muted mt-3 font-weight-bold font-size-sm"> {{ __('More than ') . App\Models\Offer::count() . __(' offer ') .  __('ًWith More than ')  . $offers->count() . __(' offer') }} </span>
    </h3>
    
    <div class="table-responsive">
        <table id="table_id" class="table table-head-custom table-head-bg  table-vertical-center text-center" border="1">

            <thead>
            <tr class="text-center text-uppercase">
                <th style="min-width: 250px" class="pl-7">{{ __('AM Name') }}</th>
                <th style="min-width: 100px">{{ __('Team') }}</th>
                <th style="min-width: 100px">{{ __('Orders') }}</th>
                <th style="min-width: 100px">{{ __('Sales') }}</th>
                <th style="min-width: 100px">{{ __('payout') }}</th>
                <th style="min-width: 100px">{{ __('Revenue') }}</th>
                <th style="min-width: 100px">{{ __('Publishers No') }}</th>
            </tr>
            </thead>
            <tbody>
                {{--  userPerformance($accountManager) --}}
                @foreach($accountManagers as $accountManager)
                    @php
                        $userPerformance = userPerformance($accountManager);
                    @endphp
                    @if($userPerformance)
                        <tr>
                            <td>
                                {{ $accountManager->name }}
                            </td>
                            <td>
                                {{ $accountManager->updated_team }}
                            </td>
                            <td>
                                {{ $userPerformance->orders ?? 0 }}
                            </td>
                            <td>
                                {{ $userPerformance->sales ?? 0 }}$
                            </td>
                            <td>
                                {{ $userPerformance->revenue ?? 0 }}$
                            </td>
                            <td>
                                {{ $userPerformance->payout ?? 0 }}$
                            </td>
                            <td>
                                {{ $accountManager->users->count() ?? 0 }}
                            </td>
                        </tr>
                    @endif
                @endforeach
     
            </tbody>
        </table>
    </div>

@push('scripts')
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/bootstrap-select.min.js"></script>    <script>
        $(document).ready( function () {
            $('#table_id').DataTable({

                order: [[2, 'desc']],
            });
        } );
    </script>
@endpush