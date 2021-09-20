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
                                <span class="text-muted font-weight-bold font-size-base d-none d-md-inline mr-1">مرحبــا , </span>
                                <span class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3">{{Auth::guard('admin')->user()->name}} </span>
                                @if( 3 < 2)
                                    <span class="symbol symbol-lg-40 symbol-25 symbol-light-success">
                                        <span class="symbol-label font-size-h5 font-weight-bold">a</span>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <!--end::User-->
                    </li>
                    <li class="menu-item" aria-haspopup="true">
                        <!--begin::User-->
                        <div class="topbar-item">
                            <div class="topbar-item" data-toggle="dropdown">
                                <div class="btn btn-icon btn-clean btn-dropdown btn-lg">
                                    <img class="h-45px w-45px rounded-sm"   src="{{getImagesPath("Admins").Auth::guard('admin')->user()->image}}" alt="" />
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
            <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px">
                <div class="btn btn-icon btn-clean btn-dropdown btn-lg mr-1">
                    <img class="h-20px w-20px rounded-sm" src="{{asset('dashboard/assets/media/svg/flags/158-egypt.svg')}}" alt="" />
                </div>
            </div>

        </div>
        <!--end::Topbar-->

    </div>
    <!--end::Container-->
</div>
<!--end::Header-->

