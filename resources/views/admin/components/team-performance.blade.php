
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
                <tr>
                    <td rowspan="4">
                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ __('Influencer') }}</span>
                    </td>
                    <td rowspan="4">
                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">1</span>
                    </td>
                    <td rowspan="4">
                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">1$</span>
                    </td>
                    <td>
                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">Account Manager 1</span>
                    </td>
                    <td>
                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">1$</span>
                    </td>
                    <td>
                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">1$</span>
                    </td>
                </tr>
                <tr>

                    <td>
                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">Account Manager 2</span>
                    </td>
                    <td>
                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">1$</span>
                    </td>
                    <td>
                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">1$</span>
                    </td>
                </tr>
                <tr>

                    <td>
                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">Account Manager 3</span>
                    </td>
                    <td>
                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">1$</span>
                    </td>
                    <td>
                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">1$</span>
                    </td>
                </tr>
                <tr>

                    <td>
                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">Account Manager 4</span>
                    </td>
                    <td>
                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">1$</span>
                    </td>
                    <td>
                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">1$</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    