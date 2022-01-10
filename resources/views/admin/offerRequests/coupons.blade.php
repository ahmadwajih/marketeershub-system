@if($offer->type == 'coupon_tracking')
    <div class="form-group row">
        <div class="col-lg-12" style="max-height: 400px !important;overflow: scroll;">
            <table class="table table-bordered">
                <tbody>
                    @if($coupons->count() > 0)
                        @foreach($coupons as $coupon)
                            <tr>
                                <td width="2%"><input id="coupon{{ $coupon->id }}" type="checkbox" {{ $request->user_id != null &&$coupon->user_id==$request->user_id ? 'checked':'' }}  name='coupons[]' value="{{ $coupon->id }}"></td>
                                <td><label width="100%" for="coupon{{ $coupon->id }}">{{ $coupon->coupon }}</label></td>
                            </tr>
                        @endforeach
                    @else
                            <tr>
                                <div class="alert alert-danger m-auto">{{ __('This offer dosn`t have coupons') }}</div>
                            </tr>
                    @endif
                </tbody>
                </table>
                {{-- {!! $coupons->links() !!} --}}
        </div>
    </div>
    @else
    its link traking
@endif