@foreach ($users as $user)
    @if($user->id != auth()->user()->id)
        <!--begin:User-->
        <div id="online{{ $user->id }}" class="d-flex align-items-center justify-content-between mb-5">
            
            <div class="d-flex align-items-center">
                <div class="symbol symbol-circle symbol-50 mr-3">
                    <img alt="Pic" src="{{ getImagesPath('Users', $user->image) }}" />
                </div>
                <div class="d-flex flex-column">
                    <a href="javascript:void(0)" onclick="singleUser({{ $user->id }})" class="text-dark-75 text-hover-primary font-weight-bold font-size-lg">{{ $user->name }}   </a>
                    <span class="text-muted font-weight-bold font-size-sm">{{ ucwords(str_replace('_', ' ', $user->position)) }} - {{ ucwords(str_replace('_', ' ', $user->team)) }} </span>
                </div>
            </div>
            <div id="userMessagesNumber{{ $user->id }}">  @if($user->unSeenChats->count() > 0)<span class="label label-sm label-danger mt-1 " id="unSeenUserMessageCount{{ $user->id }}"> {{ $user->unSeenChats->count() }}</span> @endif </div>
            {{-- <div class="d-flex flex-column align-items-end">
                <span class="text-muted font-weight-bold font-size-sm">3 hrs</span>
                <span class="label label-sm label-danger">5</span>
            </div> --}}
        </div>
        <!--end:User-->
    @endif
@endforeach