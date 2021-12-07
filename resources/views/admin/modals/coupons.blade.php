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
                  {{-- Check if have coupons --}}
                  @if(count($coupons) > 0)
                    @foreach($coupons as $coupon)
                      <tr>
                        <td>{{ $coupon->coupon }}</td>
                      </tr>
                    @endforeach
                  @endif

                  {{-- Check if have link --}}
                  @if($link)
                    <tr>
                      <td>
                        <input type="text" id="myLink" value="{{ $link }}" class="form-control">
                      </td>
                      
                    </tr>
                    <tr>
                      <td>
                        <button class="btn btn-primary btn-block" type="button" onclick="copyLink()">{{ __('Copy Link') }}</button>
                      </td>
                    </tr>
                  @endif

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

<script>
  function copyLink() {
    /* Get the text field */
    var copyText = document.getElementById("myLink");
    /* Select the text field */
    copyText.select();
    copyText.setSelectionRange(0, 99999); /* For mobile devices */
    /* Copy the text inside the text field */
    navigator.clipboard.writeText(copyText.value);
    /* Alert the copied text */
    console.log("Copied the text: " + copyText.value);
  }
  </script>

