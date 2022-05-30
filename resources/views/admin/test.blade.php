
    <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col">Coupon</th>
                <th scope="col">Orders</th>
                <th scope="col">Publisher</th>
                <th scope="col">AM</th>
                <th scope="col">Team</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($reports as $report)
                    <tr>
                        <th scope="row">{{ $report->coupon->coupon }}</th>
                        <td>{{ $report->orders }}</td>
                        <th>{{ $report->coupon->user ? $report->coupon->user->name : null }}</th>
                        <th>{{ $report->coupon->user && $report->coupon->user->parent? $report->coupon->user->parent->name : null }}</th>
                        <th>{{ $report->coupon->user ? $report->coupon->user->team : null }}</th>
                    </tr>
                @endforeach
             
            </tbody>
          </table>
