<div class="modal d-block" tabindex="-1" role="dialog" style="background: #1e1e2d61;">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ __('History') }}</h5>
          <button type="button" class="close close-modal" data-dismiss="modal" aria-label="Close">
            <i class="far fa-times-circle"></i>
          </button>
        </div>
        <div class="modal-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col">{{ __('Field') }}</th>
                <th scope="col">{{ __('Old Value') }}</th>
                <th scope="col">{{ __('New Value') }}</th>
              </tr>
            </thead>
            <tbody>
              @foreach(unserialize($activity->history) as $key => $history)
                <tr>
                  <td>{{ $key }}</td>
                  <td>{{ $history['old']??'' }}</td>
                  <td>{{ $history['new']??'' }}</td>
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

