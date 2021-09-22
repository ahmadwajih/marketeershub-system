<!--begin::Aside-->
<div class="aside aside-left aside-fixed d-flex flex-column flex-row-auto" id="kt_aside">
    <!--begin::Brand-->
    <div class="brand flex-column-auto" id="kt_brand">
        <!--begin::Logo-->
        <a href="{{route('dashboard.index')}}" class="brand-logo">
            <img src="{{ asset('dashboard') }}/images/logo.png?d=<?php echo time()?>" alt="Logo" />
        </a>
        <!--end::Logo-->
    </div>
    <!--end::Brand-->
    <!--begin::Aside Menu-->
    <div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
        <!--begin::Menu Container-->
        <div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1" data-menu-dropdown-timeout="500">
            <!--begin::Menu Nav-->
            <ul class="menu-nav">
                <li class="menu-item menu-item-active" aria-haspopup="true">
                    <a href="{{route('dashboard.index')}}" class="menu-link">
                        <span class="svg-icon menu-icon">
                            <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Layers.svg-->
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <polygon points="0 0 24 0 24 24 0 24" />
                                    <path d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z" fill="#000000" fill-rule="nonzero" />
                                    <path d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z" fill="#000000" opacity="0.3" />
                                </g>
                            </svg>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-text">{{ __('Dashboard') }}</span>
                    </a>
                </li>

                <li class="menu-section">
                    <h4 class="menu-text">{{ __('Persons') }}</h4>
                    <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                </li>

                @can('view_users') 
                {{-- Start Users  --}}
                <li class="menu-item menu-item-submenu {{ Request::segment(2)=='users'?'menu-item-open':'' }}" aria-haspopup="true" data-menu-toggle="hover">
                    <a href="javascript:;" class="menu-link menu-toggle">
                        <span class="svg-icon menu-icon">
                          <i class="fas fa-user-cog"></i>
                        </span>
                        <span class="menu-text">{{ __('Users') }}</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="menu-submenu">
                        <i class="menu-arrow"></i>
                        <ul class="menu-subnav">
                            <li class="menu-item menu-item-parent" aria-haspopup="true">
                                <span class="menu-link">
                                    <span class="menu-text">{{ __('Users') }}</span>
                                </span>
                            </li>
                            @can('view_users')
                            <li class="menu-item {{ Request::segment(2)=='users'&&Request::segment(3)!='create'?'menu-item-active':'' }}" aria-haspopup="true">
                                <a href="{{route('dashboard.users.index')}}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">{{ __('All Users') }}</span>
                                </a>
                            </li>
                            @endcan
                            @can('create_users')
                            <li class="menu-item {{ Request::segment(2)=='users'&&Request::segment(3)=='create'?'menu-item-active':'' }}" aria-haspopup="true">
                                <a href="{{route('dashboard.users.create')}}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">{{ __('Add New User') }}</span>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                {{--  End Users --}}
                @endcan
         
         
                <li class="menu-section">
                    <h4 class="menu-text">{{ __('Work environment') }}</h4>
                    <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                </li>
                @can('view_countries')
                {{-- Start Roles --}}
                <li class="menu-item menu-item-submenu {{ Request::segment(2)=='roles'?'menu-item-open':'' }}" aria-haspopup="true" data-menu-toggle="hover">
                    <a href="javascript:;" class="menu-link menu-toggle">
                        <span class="svg-icon menu-icon">
                          	<i class="fas fa-lock"></i>
                        </span>
                        <span class="menu-text">{{ __('Roles') }}</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="menu-submenu">
                        <i class="menu-arrow"></i>
                        <ul class="menu-subnav">
                            <li class="menu-item menu-item-parent" aria-haspopup="true">
                                <span class="menu-link">
                                    <span class="menu-text">{{ __('Roles') }}</span>
                                </span>
                            </li>
                            @can('view_roles')
                            <li class="menu-item {{ Request::segment(2)=='roles'&&Request::segment(3)!='create'?'menu-item-active':'' }}" aria-haspopup="true">
                                <a href="{{route('dashboard.roles.index')}}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">{{ __('All Roles') }}</span>
                                    {{--
                                    <span class="menu-label">
                                        <span class="label label-danger label-inline">new</span>
                                    </span>
                                        --}}
                                </a>
                            </li>
                            @endcan
                            @can('create_roles')
                            <li class="menu-item {{ Request::segment(2)=='roles'&&Request::segment(3)=='create'?'menu-item-active':'' }}" aria-haspopup="true">
                                <a href="{{route('dashboard.roles.create')}}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">{{ __('Add New Role') }}</span>
                                    {{--
                                    <span class="menu-label">
                                        <span class="label label-danger label-inline">new</span>
                                    </span>
                                        --}}
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                {{-- End Roles --}}
                @endcan
   
                {{-- Start Currencies --}}
                {{-- <li class="menu-item menu-item-submenu  {{ Request::segment(2)=='currencies'?'menu-item-open':'' }}" aria-haspopup="true" data-menu-toggle="hover">
                    <a href="javascript:;" class="menu-link menu-toggle">
                        <span class="svg-icon menu-icon">
                          <i class="fas fa-dollar-sign"></i>
                        </span>
                        <span class="menu-text">العملات</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="menu-submenu">
                        <i class="menu-arrow"></i>
                        <ul class="menu-subnav">
                            <li class="menu-item menu-item-parent" aria-haspopup="true">
                                <span class="menu-link">
                                    <span class="menu-text">العملات</span>
                                </span>
                            </li>
                            @can('view_currencies')
                            <li class="menu-item {{ Request::segment(2)=='currencies'&&Request::segment(3)!='create'?'menu-item-active':'' }}" aria-haspopup="true">
                                <a href="{{route('dashboard.currencies.index')}}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">عرض جميع العملات</span>
       
                                </a>
                            </li>
                            @endcan
                            @can('create_currencies')
                            <li class="menu-item {{ Request::segment(2)=='currencies'&&Request::segment(3)=='create'?'menu-item-active':'' }}" aria-haspopup="true">
                                <a href="{{route('dashboard.currencies.create')}}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">إضافة عملة جديد</span>
                                    
                    
                                        
                                </a>
                            </li>
                            @endcan

                        </ul>
                    </div>
                </li> --}}
                {{--  End Currencies --}}

             
                {{-- <li class="menu-item  {{ Request::segment(2)=='settings'?'menu-item-active':'' }}" aria-haspopup="true">
                    <a href="{{route('dashboard.settings.edit',1)}}" class="menu-link">
                        <span class="svg-icon menu-icon">
                          <span class="svg-icon menu-icon">
								<i class="flaticon-settings-1"></i>
                        </span>
                        <span class="menu-text">الاعدادات</span>
                        </span>
                    </a>
                </li> --}}
         
                <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                    <a onclick="document.getElementById('logout-form').submit();" href="javascript:" class="menu-link menu-toggle">
                	<span class="svg-icon menu-icon">
                        <span class="svg-icon menu-icon">
                            <i class="fas fa-sign-out-alt"></i>
                        </span>
                    </span>
                        <span class="menu-text">{{ __('Logout') }}</span>
                        <i class="menu-arrow"></i>
                    </a>
                </li>

                <form id="logout-form" action="{{ route('dashboard.logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </ul>
            <!--end::Menu Nav-->
        </div>
        <!--end::Menu Container-->
    </div>
    <!--end::Aside Menu-->
</div>
<!--end::Aside-->
