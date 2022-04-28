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
          <form action="{{ route('admin.user.activities.update.approval') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th scope="col">{{ __('Field') }}</th>
                  <th scope="col">{{ __('Old Value') }}</th>
                  <th scope="col">{{ __('New Value') }}</th>
                </tr>
              </thead>
              <tbody>
                <input type="hidden" name="object" value="{{ $activity->object }}">
                <input type="hidden" name="object_id" value="{{ $activity->object_id }}">
                <input type="hidden" name="user_id" value="{{ $activity->user_id }}">
                <input type="hidden" name="activity_id" value="{{ $activity->id }}">
                @foreach(unserialize($activity->history) as $key => $history)
                  <tr>
                    <td>{{ $key }}</td>
                    <td>{{ $history['old']??'' }}</td>
                    <td>{{ $history['new']??'' }}</td>
                  </tr>
                  <input type="hidden" name="keys[]" value="{{ $key }}">
                  <input type="hidden" name="values[]" value="{{ $history['new']??'' }}">
                @endforeach
              </tbody>
            </table>
            @if(!$activity->approved)
              <button class="btn btn-primary btn-block" type="submit"> Approve </button>
            @endif
          </form>
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

