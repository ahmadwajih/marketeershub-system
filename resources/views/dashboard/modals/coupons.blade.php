<div class="modal d-block" tabindex="-1" role="dialog" id='user{{ auth()->user()->id }}'>
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ __('My Coupons') }}</h5>
          <button type="button" class="close close-modal" data-dismiss="modal" aria-label="Close">
            <i class="far fa-times-circle"></i>
          </button>
        </div>
        <div class="modal-body">
            <table class="table table-bordered">
                <tbody>
                    @foreach($coupons as $coupon)
                        <tr>
                            <td>{{ $coupon->coupon }}</td>
                        </tr>
                    @endforeach
                </tbody>
              </table>
        </div>

      </div>
    </div>
  </div>  

<script>
      // Close Modal
  $(".close-modal").click(function(){
      $('.modal').removeClass('d-block');
  });

</script>

