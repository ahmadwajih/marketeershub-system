<!--begin::Header-->
<div id="kt_header" class="header header-fixed noprint">
    <!--begin::Container-->
    <div class="container-fluid d-flex align-items-stretch justify-content-between">
        <!--begin::Header Menu Wrapper-->
        <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">

        </div>
        <!--end::Header Menu Wrapper-->
        <!--begin::Topbar-->
        <div class="topbar">
            
        
                <div class="dropdown">
                    <!--begin::Toggle-->
                    <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px">
                        <div class="btn btn-icon btn-clean btn-dropdown btn-lg mr-1 pulse pulse-primary">

                            <span style="background:red;color:white;font-weight:bold;font-size:0.8rem;margin-top:-15px" class="rounded-circle pl-2 pr-2 "> <span id="notification-count-1"></span> </span>

                            <span>
                            <i class="flaticon2-bell text-primary"></i>
                        </span>
                            <span class="pulse-ring"></span>
                        </div>
                    </div>
                    <!--end::Toggle-->
                    <!--begin::Dropdown-->
                    <div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-lg">
                        <form>
                            <!--begin::Header-->
                            <div class="d-flex flex-column pt-12 bgi-size-cover bgi-no-repeat rounded-top" style="background-image: url({{asset('dashboard/media/misc/bg-1.jpg')}})">
                                <!--begin::Title-->
                                <h4 class="d-flex flex-center rounded-top">
                                    <span class="btn btn-text btn-primary btn-sm font-weight-bolder btn-font-md ml-2 mb-10"><span id="notification-count-2"></span> {{ __('New') }} </span>
                                </h4>
                                <!--end::Title-->
                            </div>
                            <!--end::Header-->
                            <!--begin::Content-->
                            <div class="tab-content">
                                <!--begin::Tabpane-->
                                <div class="tab-pane active show p-8" role="tabpanel" >
                                    <!--begin::Scroll-->


                                    <!--end::Scroll-->
                                </div>
                                <!--end::Tabpane-->
                            </div>
                            <!--end::Content-->
                        </form>
                    </div>
                    <!--end::Dropdown-->
                </div>

            <!--begin::Languages-->
            {{-- <div class="dropdown">
                <!--begin::Toggle-->
                <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px">
                    <div class="btn btn-icon btn-clean btn-dropdown btn-lg mr-1">
                        <img class="h-20px w-20px rounded-sm" src="{{asset('dashboard/media/svg/flags/133-saudi-arabia.svg')}}"  alt="" />
                    </div>
                </div>
                <!--end::Toggle-->
            </div> --}}
            <!--end::Languages-->
            <!--begin::User-->
            <div class="topbar-item">
                <div class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-lg px-2" id="kt_quick_user_toggle">
                    <span class="text-muted font-weight-bold font-size-base d-none d-md-inline mr-1">{{ __('Hi') }}</span>
                    <span class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3"></span>
                    <span class="symbol symbol-35 symbol-light-success">
						<span class="symbol-label font-size-h5 font-weight-bold">A</span>
					</span>
                </div>
            </div>
            <!--end::User-->
        </div>
        <!--end::Topbar-->
    </div>
    <!--end::Container-->
</div>
<!--end::Header-->


@push('scripts')


{{--    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>--}}
{{--    <script>--}}

{{--        // Enable pusher logging - don't include this in production--}}
{{--        Pusher.logToConsole = true;--}}

{{--        var pusher = new Pusher(--}}
{{--            '1e2bb7b0bd64c940e9b8', {--}}
{{--            cluster: 'ap2',--}}
{{--            encrypted: true--}}
{{--        });--}}

{{--        var channel = pusher.subscribe('newOrderChannel');--}}

{{--        channel.bind('OrderEvent', function(data) {--}}


{{--            document.getElementById('notification-count-1').innerText = parseInt(document.getElementById('notification-count-1').innerText) + 1;--}}
{{--            document.getElementById('notification-count-2').innerText = document.getElementById('notification-count-1').innerText;--}}


{{--            var notificationRow =--}}
{{--                ' <div class="d-flex align-items-center mb-6"> ' +--}}

{{--                '<div class="symbol symbol-40 symbol-primary mr-5">' +--}}
{{--                '<span class="symbol-label">' +--}}
{{--                '<i class="flaticon2-bell text-light"></i>' +--}}
{{--                '</span>' +--}}
{{--                '</div>' +--}}
{{--                '<div class="d-flex flex-column font-weight-bold">' +--}}
{{--                '<a href="' + data['order'].link + '" onclick="markRead(' + data['order'].id + ')" class="text-dark text-hover-primary mb-1 font-size-lg font-weight-bolder"> طلب جديد  </a>' +--}}
{{--                '<span class="text-muted">' + "تم استلام طلب جديد برقم"  + data['order'].number + '</span>' +--}}
{{--                '</div>' +--}}
{{--                '</div>';--}}

{{--            var notification_body = document.getElementById('notificationsBody');--}}
{{--            notification_body.insertAdjacentHTML("afterbegin", notificationRow);--}}

{{--            if( document.getElementById('no_notifications'))--}}
{{--            {--}}
{{--                document.getElementById('no_notifications').style.display = "none";--}}
{{--            }--}}


{{--            --}}{{--var audio = new Audio('{{base_path('notification.mp3')}}');--}}
{{--            --}}{{--audio.play();--}}


{{--        });--}}

{{--    </script>--}}
{{--    <script>--}}

{{--        function markRead(id)--}}
{{--        {--}}

{{--            --}}{{--var audio = new Audio('{{base_path('notification.mp3')}}');--}}
{{--            --}}{{--audio.play();--}}

{{--            $.ajax({--}}
{{--                type:"PUT",--}}
{{--                url: "admin/notifications/mark-read/" + id,--}}
{{--                data:{--}}
{{--                    "_token": "{{ csrf_token() }}",--}}
{{--                },--}}
{{--            });--}}
{{--        }--}}

{{--    </script>--}}
@endpush
