<!--begin::Header-->
<div id="kt_header" class="header header-fixed">
    <!--begin::Container-->
    <div class="container-fluid d-flex align-items-stretch justify-content-between">
        <!--begin::Header Menu Wrapper-->
        <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
            <!--begin::Header Menu-->
            <div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
                <!--begin::Header Nav-->
                <ul class="menu-nav">
                    <li class="menu-item" aria-haspopup="true">
                        <!--begin::User-->
                        <div class="topbar-item">
                            <div class="btn btn-icon btn-icon-mobile w-auto btn-clean d-flex align-items-center btn-lg px-2" id="kt_quick_user_toggle">
                                <span class="text-muted font-weight-bold font-size-base d-none d-md-inline mr-1">{{ __('Hello') }} , </span>
                                <span class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3">{{Auth::guard('web')->user()->name}} </span>
                            </div>
                        </div>
                        <!--end::User-->
                    </li>
                    <li class="menu-item" aria-haspopup="true">
                        <!--begin::User-->
                        <div class="topbar-item">
                            <div class="topbar-item" data-toggle="dropdown">
                                <div class="">
                                    <img class="h-45px w-45px rounded-sm profile-image" src="{{ getImagesPath('Users', Auth::guard('web')->user()->image) }}" alt="" />
                                </div>
                            </div>
                        </div>
                        <!--end::User-->
                    </li>

                </ul>
                <!--end::Header Nav-->
            </div>
            <!--end::Header Menu-->
        </div>
        <!--end::Header Menu Wrapper-->
        <!--begin::Topbar-->
        <div class="topbar">

            <!--begin::Notifications-->
            <div class="dropdown">
                <!--begin::Toggle-->
                <!--begin::Toggle-->
                <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px">
                    <div class="btn btn-icon btn-clean btn-dropdown btn-lg mr-1 pulse pulse-danger" id="notification-bell">
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <span class="label label-sm label-light-danger label-rounded font-weight-bolder position-absolute top-0 right-0 mt-1 mr-1" id="notification-counter">{{auth()->user()->unreadNotifications->count()}}</span>
                        @endif
                        <span>
                            <i class="flaticon2-bell text-pink"></i>
                        </span>
                        <span class="pulse-ring"></span>
                    </div>
                </div>
                <!--end::Toggle-->
                <!--begin::Dropdown-->
                <div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-lg">
                    <form>
                        <!--begin::Header-->
                        <div class="d-flex flex-column pt-12 bgi-size-cover bgi-no-repeat rounded-top" style="height: 105px; background-image: url({{ asset('dashboard/media/misc/bg-1.jpg') }})">
                            <!--begin::Title-->
                            <h4 class="d-flex flex-center rounded-top">
                                <span class="text-white">{{ __('User Notifications') }}</span>
                                <span class="btn btn-text btn-success btn-sm font-weight-bold btn-font-md ml-2">{{ auth()->user()->unreadNotifications->count() }} {{ __('New Notofocations') }}</span>
                            </h4>
                            <!--end::Title-->
                            <!--begin::Tabs-->
                            {{-- <ul class="nav nav-bold nav-tabs nav-tabs-line nav-tabs-line-3x nav-tabs-line-transparent-white nav-tabs-line-active-border-success mt-3 px-8" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active show" data-toggle="tab" href="#topbar_notifications_notifications">Alerts</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#topbar_notifications_events">Events</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#topbar_notifications_logs">Logs</a>
                                </li>
                            </ul> --}}
                            <!--end::Tabs-->
                        </div>
                        <!--end::Header-->
                        <!--begin::Content-->
                        <div class="tab-content">
                            @if(auth()->user()->notifications->count() > 0)
                                <!--begin::Tabpane-->
                                <div class="tab-pane active show p-8" role="tabpanel">
                                    <!--begin::Scroll-->
                                    <div class="scroll pr-7 mr-n7" data-scroll="true" data-height="300" data-mobile-height="200">
                                        @foreach(auth()->user()->notifications as $notification)
                                            <!--begin::Item-->
                                            <div class="d-flex align-items-center mb-6">
                                                <!--begin::Symbol-->
                                                <div class="symbol symbol-40 symbol-light-primary mr-5">
                                                    <img src="{{ getImagesPath($notification->data['model'], $notification->data['image']) }}" alt="">
                                                </div>
                                                <!--end::Symbol-->
                                                <!--begin::Text-->
                                                <div class="d-flex flex-column font-weight-bold">
                                                    <a href="{{ route('admin.'.Str::plural(Str::lower($notification->data['model'])).'.show', $notification->data['id'] ) }}" data-notification="{{ $notification->id }}" class="text-dark text-hover-primary mb-1 font-size-lg notification">{{ $notification->data['subject'] }}  {{ $notification->data['title'] }}</a>
                                                    <span class="text-muted">{{$notification->created_at->diffForHumans()}}</span>
                                                </div>
                                                <!--end::Text-->
                                            </div>
                                            <!--end::Item-->
                                        @endforeach
                                    </div>
                                    <!--end::Scroll-->
                                </div>
                                <!--end::Tabpane-->
                            @else
                                <!--begin::Tabpane-->
                                <div class="tab-pane  active show p-8"  role="tabpanel">
                                    <!--begin::Nav-->
                                    <div class="d-flex flex-center text-center text-muted min-h-200px">{{ __('No new notifications.') }}</div>
                                    <!--end::Nav-->
                                </div>
                                <!--end::Tabpane-->
                            @endif
                            @if(auth()->user()->unreadNotifications->count() > 0)
                                <!--begin::Item-->
                                    <a href="javascript:"  id="load-more" title="{{__('Load more')}}" data-next="{{ auth()->user()->unreadNotifications->count() - 10 }}">
                                        <div class="navi-link rounded bg-hover-gray-100">
                                            <div class="navi-text d-flex justify-content-center " id="loadmore-icon">
                                                {{--                                    <div class="spinner spinner-primary spinner-sm mr-15"></div>--}}
                                                <span class="svg-icon svg-icon-danger svg-icon-2x">
                                                    <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo3\dist/../src/media/svg/icons\Navigation\Angle-double-down.svg-->
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <polygon points="0 0 24 0 24 24 0 24"/>
                                                            <path d="M8.2928955,3.20710089 C7.90237121,2.8165766 7.90237121,2.18341162 8.2928955,1.79288733 C8.6834198,1.40236304 9.31658478,1.40236304 9.70710907,1.79288733 L15.7071091,7.79288733 C16.085688,8.17146626 16.0989336,8.7810527 15.7371564,9.17571874 L10.2371564,15.1757187 C9.86396402,15.5828377 9.23139665,15.6103407 8.82427766,15.2371482 C8.41715867,14.8639558 8.38965574,14.2313885 8.76284815,13.8242695 L13.6158645,8.53006986 L8.2928955,3.20710089 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000003, 8.499997) scale(-1, -1) rotate(-90.000000) translate(-12.000003, -8.499997) "/>
                                                            <path d="M6.70710678,19.2071045 C6.31658249,19.5976288 5.68341751,19.5976288 5.29289322,19.2071045 C4.90236893,18.8165802 4.90236893,18.1834152 5.29289322,17.7928909 L11.2928932,11.7928909 C11.6714722,11.414312 12.2810586,11.4010664 12.6757246,11.7628436 L18.6757246,17.2628436 C19.0828436,17.636036 19.1103465,18.2686034 18.7371541,18.6757223 C18.3639617,19.0828413 17.7313944,19.1103443 17.3242754,18.7371519 L12.0300757,13.8841355 L6.70710678,19.2071045 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(12.000003, 15.499997) scale(-1, -1) rotate(-360.000000) translate(-12.000003, -15.499997) "/>
                                                        </g>
                                                    </svg>
                                                                    <!--end::Svg Icon-->
                                                </span>
                                            </div>
                                        </div>
                                    </a>
                                    <!--end::Item-->
                                @endif
                        </div>
                        <!--end::Content-->
                    </form>
                </div>
                <!--end::Dropdown-->
            </div>
            <!--end::Notifications-->
            <!--begin::Languages-->
            {{-- <div class="topbar-item">
                <a class="btn btn-icon btn-clean btn-dropdown btn-lg mr-1" href="{{ route('admin.change.lang', app()->getLocale() == 'ar' ? 'en' : 'ar') }}">
                    <span class="svg-icon svg-icon-xl svg-icon-primary">
                        {{ app()->getLocale() == 'ar' ? 'English' : 'العربية' }}
                    </span>
                </a>
            </div> --}}
        </div>
        <!--end::Topbar-->

    </div>
    <!--end::Container-->
</div>
<!--end::Header-->

