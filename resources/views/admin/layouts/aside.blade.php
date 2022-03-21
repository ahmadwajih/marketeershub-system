<!--begin::Aside-->
<div class="aside aside-left aside-fixed d-flex flex-column flex-row-auto" id="kt_aside">
    <!--begin::Brand-->
    <div class="brand flex-column-auto" id="kt_brand">
        <!--begin::Logo-->
        <a href="{{route('admin.index')}}" class="brand-logo">
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
                @can('view_dashboard')
                <li class="menu-item menu-item-active" aria-haspopup="true">
                    <a href="{{route('admin.index')}}" class="menu-link">
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
                @endcan
                @if( in_array(auth()->user()->team, ['media_buying', 'influencer', 'affiliate', 'prepaid']))
                    <li class="menu-item {{ Request::segment(2)=='publisher'&&Request::segment(3)=='profile'?'menu-item-open':'' }}" aria-haspopup="true">
                        <a href="{{route('admin.publisher.profile')}}" class="menu-link">
                            <span class="svg-icon menu-icon">
                                <i class="fas fa-id-badge"></i>
                            </span>
                            <span class="menu-text">{{ __('Profile') }}</span>
                        </a>
                    </li>
                @else
                    <li class="menu-item {{ Request::segment(2)=='user'&&Request::segment(3)=='profile'?'menu-item-open':'' }}" aria-haspopup="true">
                        <a href="{{route('admin.user.profile')}}" class="menu-link">
                            <span class="svg-icon menu-icon">
                                <i class="fas fa-id-badge"></i>
                            </span>
                            <span class="menu-text">{{ __('Profile') }}</span>
                        </a>
                    </li>
                @endif
                <li class="menu-section">
                    <h4 class="menu-text">{{ __('Persons') }}</h4>
                    <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                </li>

                @can('view_users') 
                {{-- Start Employees  --}}
                <li class="menu-item menu-item-submenu {{ Request::segment(2)=='users'?'menu-item-open':'' }}" aria-haspopup="true" data-menu-toggle="hover">
                    <a href="javascript:;" class="menu-link menu-toggle">
                        <span class="svg-icon menu-icon">
                          <i class="fas fa-user-cog"></i>
                        </span>
                        <span class="menu-text">{{ __('Employees') }}</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="menu-submenu">
                        <i class="menu-arrow"></i>
                        <ul class="menu-subnav">
                            <li class="menu-item menu-item-parent" aria-haspopup="true">
                                <span class="menu-link">
                                    <span class="menu-text">{{ __('Employees') }}</span>
                                </span>
                            </li>
                            @can('view_users')
                            <li class="menu-item {{ Request::segment(2)=='users'&&Request::segment(3)!='create'?'menu-item-active':'' }}" aria-haspopup="true">
                                <a href="{{route('admin.users.index')}}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">{{ __('All Employees') }}</span>
                                </a>
                            </li>
                            @endcan
                            @can('create_users')
                            <li class="menu-item {{ Request::segment(2)=='users'&&Request::segment(3)=='create'?'menu-item-active':'' }}" aria-haspopup="true">
                                <a href="{{route('admin.users.create')}}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">{{ __('Add New Employee') }}</span>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                {{--  End Employees --}}
                @endcan
                @can('view_publishers')

                 {{-- Start Publishers  --}}
                 <li class="menu-item menu-item-submenu {{ Request::segment(2)=='publishers'|| Request::segment(2)=='publishers-search' ?'menu-item-open':'' }}" aria-haspopup="true" data-menu-toggle="hover">
                    <a href="javascript:;" class="menu-link menu-toggle">
                        <span class="svg-icon menu-icon">
                            <i class="fas fa-user-tag"></i>
                        </span>
                        <span class="menu-text">{{ __('Publishers') }}</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="menu-submenu">
                        <i class="menu-arrow"></i>
                        <ul class="menu-subnav">
                            <li class="menu-item menu-item-parent" aria-haspopup="true">
                                <span class="menu-link">
                                    <span class="menu-text">{{ __('Publishers') }}</span>
                                </span>
                            </li>

                            @can('view_publishers')
                            <li class="menu-item {{ Request::segment(2)=='publishers'&&Request::segment(3)==''?'menu-item-active':'' }}" aria-haspopup="true">
                                <a href="{{route('admin.publishers.index')}}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">{{ __('All Publishers') }}</span>
                                </a>
                            </li>
                            @endcan

                            @can('create_publishers')
                            <li class="menu-item {{ Request::segment(2)=='publishers'&&Request::segment(3)=='create'?'menu-item-active':'' }}" aria-haspopup="true">
                                <a href="{{route('admin.publishers.create')}}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">{{ __('Add New Publisher') }}</span>
                                </a>
                            </li>
                            @endcan
                            @can('create_publishers')
                            <li class="menu-item {{ Request::segment(2)=='publishers'&&Request::segment(3)=='upload'?'menu-item-active':'' }}" aria-haspopup="true">
                                <a href="{{route('admin.publishers.upload.form')}}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">{{ __('Upload Publishers') }}</span>
                                </a>
                            </li>
                            @endcan
                            @can('update_publishers')
                            <li class="menu-item {{ Request::segment(2)=='publishers'&&Request::segment(3)=='upload'&&Request::segment(4)=='update-hasoffer-id-by-email'?'menu-item-active':'' }}" aria-haspopup="true">
                                <a href="{{route('admin.publishers.upload.update.hasoffer.id.by.email.form')}}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">{{ __('Update Publishers Has Offer ID using Email') }}</span>
                                </a>
                            </li>
                            @endcan

                        </ul>
                    </div>
                </li>
                {{--  End Publishers --}}
                @endcan
         
                @can('view_advertisers') 
                {{-- Start Advertisers  --}}
                <li class="menu-item menu-item-submenu {{ Request::segment(2)=='advertisers'?'menu-item-open':'' }}" aria-haspopup="true" data-menu-toggle="hover">
                    <a href="javascript:;" class="menu-link menu-toggle">
                        <span class="svg-icon menu-icon">
                        <i class="fas fa-building"></i>
                        </span>
                        <span class="menu-text">{{ __('Advertisers') }}</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="menu-submenu">
                        <i class="menu-arrow"></i>
                        <ul class="menu-subnav">
                            <li class="menu-item menu-item-parent" aria-haspopup="true">
                                <span class="menu-link">
                                    <span class="menu-text">{{ __('Advertisers') }}</span>
                                </span>
                            </li>
                            @can('view_advertisers')
                            <li class="menu-item {{ Request::segment(2)=='advertisers'&&Request::segment(3)!='create'?'menu-item-active':'' }}" aria-haspopup="true">
                                <a href="{{route('admin.advertisers.index')}}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">{{ __('All Advertisers') }}</span>
                                </a>
                            </li>
                            @endcan

                            @can('create_advertisers')
                            <li class="menu-item {{ Request::segment(2)=='advertisers'&&Request::segment(3)=='create'?'menu-item-active':'' }}" aria-haspopup="true">
                                <a href="{{route('admin.advertisers.create')}}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">{{ __('Add New Advertiser') }}</span>
                                </a>
                            </li>
                            @endcan
                       
                        </ul>
                    </div>
                </li>
                {{--  End Advertisers --}}
                @endcan

                @can('view_targets') 
                {{-- Start Targets  --}}
                <li class="menu-item menu-item-submenu {{ Request::segment(2)=='targets'?'menu-item-open':'' }}" aria-haspopup="true" data-menu-toggle="hover">
                    <a href="javascript:;" class="menu-link menu-toggle">
                        <span class="svg-icon menu-icon">
                            <i class="fas fa-bullseye"></i>
                        </span>
                        <span class="menu-text">{{ __('Targets') }}</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="menu-submenu">
                        <i class="menu-arrow"></i>
                        <ul class="menu-subnav">
                            <li class="menu-item menu-item-parent" aria-haspopup="true">
                                <span class="menu-link">
                                    <span class="menu-text">{{ __('Targets') }}</span>
                                </span>
                            </li>
                            @can('view_targets')
                            <li class="menu-item {{ Request::segment(2)=='targets'&&Request::segment(3)!='create'?'menu-item-active':'' }}" aria-haspopup="true">
                                <a href="{{route('admin.targets.index')}}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">{{ __('All Targets') }}</span>
                                </a>
                            </li>
                            @endcan

                            @can('create_targets')
                            <li class="menu-item {{ Request::segment(2)=='targets'&&Request::segment(3)=='create'?'menu-item-active':'' }}" aria-haspopup="true">
                                <a href="{{route('admin.targets.create')}}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">{{ __('Add New Target') }}</span>
                                </a>
                            </li>
                            @endcan
                       
                        </ul>
                    </div>
                </li>
                {{--  End Targets --}}
                @endcan

                <li class="menu-section">
                    <h4 class="menu-text">{{ __('Work environment') }}</h4>
                    <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                </li>

                @can('view_categories') 
                {{-- Start Categories  --}}
                <li class="menu-item menu-item-submenu {{ Request::segment(2)=='categories'?'menu-item-open':'' }}" aria-haspopup="true" data-menu-toggle="hover">
                    <a href="javascript:;" class="menu-link menu-toggle">
                        <span class="svg-icon menu-icon">
                            <i class="fas fa-align-center"></i>
                        </span>
                        <span class="menu-text">{{ __('Categories') }}</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="menu-submenu">
                        <i class="menu-arrow"></i>
                        <ul class="menu-subnav">
                            <li class="menu-item menu-item-parent" aria-haspopup="true">
                                <span class="menu-link">
                                    <span class="menu-text">{{ __('Categories') }}</span>
                                </span>
                            </li>
                            @can('view_categories')
                            <li class="menu-item {{ Request::segment(2)=='categories'&&Request::segment(3)!='create'?'menu-item-active':'' }}" aria-haspopup="true">
                                <a href="{{route('admin.categories.index')}}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">{{ __('All Categories') }}</span>
                                </a>
                            </li>
                            @endcan

                            @can('create_categories')
                            <li class="menu-item {{ Request::segment(2)=='categories'&&Request::segment(3)=='create'?'menu-item-active':'' }}" aria-haspopup="true">
                                <a href="{{route('admin.categories.create')}}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">{{ __('Add New Category') }}</span>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                {{--  End Categories --}}
                @endcan
                
                @can('view_reports') 
                {{-- Start Reports  --}}
                <li class="menu-item menu-item-submenu {{ Request::segment(2)=='reports'?'menu-item-open':'' }}" aria-haspopup="true" data-menu-toggle="hover">
                    <a href="javascript:;" class="menu-link menu-toggle">
                        <span class="svg-icon menu-icon">
                            <i class="fas fa-tags"></i>
                        </span>
                        <span class="menu-text">{{ __('Reports') }}</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="menu-submenu">
                        <i class="menu-arrow"></i>
                        <ul class="menu-subnav">
                            <li class="menu-item menu-item-parent" aria-haspopup="true">
                                <span class="menu-link">
                                    <span class="menu-text">{{ __('Reports') }}</span>
                                </span>
                            </li>
                            @can('view_reports')
                            <li class="menu-item {{ Request::segment(2)=='reports'&&Request::segment(3)!='create'?'menu-item-active':'' }}" aria-haspopup="true">
                                <a href="{{route('admin.reports.index')}}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">{{ __('All Reports') }}</span>
                                </a>
                            </li>
                            @endcan



                        </ul>
                    </div>
                </li>
                {{--  End Reports --}}
                @endcan

                @can('view_offers') 
                {{-- Start Offers  --}}
                <li class="menu-item menu-item-submenu {{ Request::segment(2)=='offers'||Request::segment(2)=='my-offers'?'menu-item-open':'' }}" aria-haspopup="true" data-menu-toggle="hover">
                    <a href="javascript:;" class="menu-link menu-toggle">
                        <span class="svg-icon menu-icon">
                            <i class="fas fa-tags"></i>
                        </span>
                        <span class="menu-text">{{ __('Offers') }}</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="menu-submenu">
                        <i class="menu-arrow"></i>
                        <ul class="menu-subnav">
                            <li class="menu-item menu-item-parent" aria-haspopup="true">
                                <span class="menu-link">
                                    <span class="menu-text">{{ __('Offers') }}</span>
                                </span>
                            </li>
                            @can('view_offers')
                            <li class="menu-item {{ Request::segment(2)=='offers'&&Request::segment(3)!='create'?'menu-item-active':'' }}" aria-haspopup="true">
                                <a href="{{route('admin.offers.index')}}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">{{ __('All Offers') }}</span>
                                </a>
                            </li>
                            @endcan

                            @can('create_offers')
                            <li class="menu-item {{ Request::segment(2)=='offers'&&Request::segment(3)=='create'?'menu-item-active':'' }}" aria-haspopup="true">
                                <a href="{{route('admin.offers.create')}}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">{{ __('Add New Offer') }}</span>
                                </a>
                            </li>
                            @endcan 
                            @if(auth()->user()->position != 'super_admin')
                            <li class="menu-item {{ Request::segment(2)=='my-offers'?'menu-item-active':'' }}" aria-haspopup="true">
                                <a href="{{route('admin.my-offers')}}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">{{ __('My Offers') }}</span>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </li>
                {{--  End Offers --}}
                @endcan

                @can('view_offer_requests') 
                {{-- Start Offer Requests  --}}
                <li class="menu-item menu-item-submenu {{ Request::segment(2)=='offerRequests'?'menu-item-open':'' }}" aria-haspopup="true" data-menu-toggle="hover">
                    <a href="javascript:;" class="menu-link menu-toggle">
                        <span class="svg-icon menu-icon">
                            <i class="fas fa-tasks"></i>
                        </span>
                        <span class="menu-text">{{ __('Offer Requests') }}</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="menu-submenu">
                        <i class="menu-arrow"></i>
                        <ul class="menu-subnav">
                            <li class="menu-item menu-item-parent" aria-haspopup="true">
                                <span class="menu-link">
                                    <span class="menu-text">{{ __('Offer Requests') }}</span>
                                </span>
                            </li>
                            @can('view_offer_requests')
                            <li class="menu-item {{ Request::segment(2)=='offerRequests'&&Request::segment(3)!='create'?'menu-item-active':'' }}" aria-haspopup="true">
                                <a href="{{route('admin.offerRequests.index')}}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">{{ __('All Offer Requests') }}</span>
                                </a>
                            </li>
                            @endcan

                            @can('create_offer_requests')
                            <li class="menu-item {{ Request::segment(2)=='offerRequests'&&Request::segment(3)=='create'?'menu-item-active':'' }}" aria-haspopup="true">
                                <a href="{{route('admin.offerRequests.create')}}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">{{ __('Add New Request') }}</span>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                {{--  End Offer Requests --}}
                @endcan

                @can('view_coupons') 
                {{-- Start Coupons  --}}
                <li class="menu-item menu-item-submenu {{ Request::segment(2)=='coupons'?'menu-item-open':'' }}" aria-haspopup="true" data-menu-toggle="hover">
                    <a href="javascript:;" class="menu-link menu-toggle">
                        <span class="svg-icon menu-icon">
                            <i class="fas fa-tag"></i>
                        </span>
                        <span class="menu-text">{{ __('Coupons') }}</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="menu-submenu">
                        <i class="menu-arrow"></i>
                        <ul class="menu-subnav">
                            <li class="menu-item menu-item-parent" aria-haspopup="true">
                                <span class="menu-link">
                                    <span class="menu-text">{{ __('Coupons') }}</span>
                                </span>
                            </li>
                            @can('view_coupons')
                            <li class="menu-item {{ Request::segment(2)=='coupons'&&Request::segment(3)!='create'?'menu-item-active':'' }}" aria-haspopup="true">
                                <a href="{{route('admin.coupons.index')}}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">{{ __('All Coupons') }}</span>
                                </a>
                            </li>
                            @endcan

                            @can('create_coupons')
                            <li class="menu-item {{ Request::segment(2)=='coupons'&&Request::segment(3)=='create'?'menu-item-active':'' }}" aria-haspopup="true">
                                <a href="{{route('admin.coupons.create')}}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">{{ __('Add New Coupon') }}</span>
                                </a>
                            </li>
                            @endcan

                            @can('create_coupons')
                            <li class="menu-item {{ Request::segment(2)=='coupons'&&Request::segment(3)=='upload'?'menu-item-active':'' }}" aria-haspopup="true">
                                <a href="{{route('admin.coupons.upload.form')}}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">{{ __('Upload Coupons') }}</span>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                {{--  End Coupons --}}
                @endcan

                @can('view_pivot_report') 
                {{-- Start Pivot Report  --}}
                <li class="menu-item menu-item-submenu {{ Request::segment(2)=='pivot-report'?'menu-item-open':'' }}" aria-haspopup="true" data-menu-toggle="hover">
                    <a href="javascript:;" class="menu-link menu-toggle">
                        <span class="svg-icon menu-icon">
                            <i class="far fa-chart-bar"></i>
                        </span>
                        <span class="menu-text">{{ __('Pivot Report') }}</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="menu-submenu">
                        <i class="menu-arrow"></i>
                        <ul class="menu-subnav">
                            <li class="menu-item menu-item-parent" aria-haspopup="true">
                                <span class="menu-link">
                                    <span class="menu-text">{{ __('Pivot Report') }}</span>
                                </span>
                            </li>


                            @can('create_pivot_report')
                            <li class="menu-item {{ Request::segment(2)=='pivot-report'&&Request::segment(3)=='create'?'menu-item-active':'' }}" aria-haspopup="true">
                                <a href="{{route('admin.pivot-report.create')}}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">{{ __('Upload New') }}</span>
                                </a>
                            </li>
                            @endcan

                        </ul>
                    </div>
                </li>
                {{--  End Pivot Report --}}
                @endcan

                @can('view_payments') 
                {{-- Start Payments  --}}
                <li class="menu-item menu-item-submenu {{ Request::segment(2)=='payments'?'menu-item-open':'' }}" aria-haspopup="true" data-menu-toggle="hover">
                    <a href="javascript:;" class="menu-link menu-toggle">
                        <span class="svg-icon menu-icon">
                            <i class="fas fa-dollar-sign"></i>                        
                        </span>
                        <span class="menu-text">{{ __('Payments') }}</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="menu-submenu">
                        <i class="menu-arrow"></i>
                        <ul class="menu-subnav">
                            <li class="menu-item menu-item-parent" aria-haspopup="true">
                                <span class="menu-link">
                                    <span class="menu-text">{{ __('Payments') }}</span>
                                </span>
                            </li>
                            @can('view_payments')
                            <li class="menu-item {{ Request::segment(2)=='payments'&&Request::segment(3)!='create'?'menu-item-active':'' }}" aria-haspopup="true">
                                <a href="{{route('admin.payments.index')}}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">{{ __('All Payments') }}</span>
                                </a>
                            </li>
                            @endcan

                            @can('create_payments')
                            <li class="menu-item {{ Request::segment(2)=='payments'&&Request::segment(3)=='create'?'menu-item-active':'' }}" aria-haspopup="true">
                                <a href="{{route('admin.payments.create')}}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">{{ __('Add New Payment') }}</span>
                                </a>
                            </li>
                            @endcan

                            @can('create_payments')
                            <li class="menu-item {{ Request::segment(2)=='payments'&&Request::segment(3)=='upload'?'menu-item-active':'' }}" aria-haspopup="true">
                                <a href="{{route('admin.payments.upload.form')}}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">{{ __('Upload Payments Sheet') }}</span>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                {{--  End Payments --}}
                @endcan

                @can('view_roles')
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
                                <a href="{{route('admin.roles.index')}}" class="menu-link">
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
                                <a href="{{route('admin.roles.create')}}" class="menu-link">
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

                @can('view_countries') 
                {{-- Start Countries  --}}
                <li class="menu-item menu-item-submenu {{ Request::segment(2)=='countries'?'menu-item-open':'' }}" aria-haspopup="true" data-menu-toggle="hover">
                    <a href="javascript:;" class="menu-link menu-toggle">
                        <span class="svg-icon menu-icon">
                            <i class="fas fa-globe-americas"></i>
                        </span>
                        <span class="menu-text">{{ __('Countries') }}</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="menu-submenu">
                        <i class="menu-arrow"></i>
                        <ul class="menu-subnav">
                            <li class="menu-item menu-item-parent" aria-haspopup="true">
                                <span class="menu-link">
                                    <span class="menu-text">{{ __('Countries') }}</span>
                                </span>
                            </li>
                            @can('view_countries')
                            <li class="menu-item {{ Request::segment(2)=='countries'&&Request::segment(3)!='create'?'menu-item-active':'' }}" aria-haspopup="true">
                                <a href="{{route('admin.countries.index')}}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">{{ __('All Countries') }}</span>
                                </a>
                            </li>
                            @endcan

                            @can('create_countries')
                            <li class="menu-item {{ Request::segment(2)=='countries'&&Request::segment(3)=='create'?'menu-item-active':'' }}" aria-haspopup="true">
                                <a href="{{route('admin.countries.create')}}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">{{ __('Add New Country') }}</span>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                {{--  End Countries --}}
                @endcan

                @can('view_cites') 
                {{-- Start Cities  --}}
                <li class="menu-item menu-item-submenu {{ Request::segment(2)=='cities'?'menu-item-open':'' }}" aria-haspopup="true" data-menu-toggle="hover">
                    <a href="javascript:;" class="menu-link menu-toggle">
                        <span class="svg-icon menu-icon">
                            <i class="far fa-building"></i>                        
                        </span>
                        <span class="menu-text">{{ __('Cities') }}</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="menu-submenu">
                        <i class="menu-arrow"></i>
                        <ul class="menu-subnav">
                            <li class="menu-item menu-item-parent" aria-haspopup="true">
                                <span class="menu-link">
                                    <span class="menu-text">{{ __('Cities') }}</span>
                                </span>
                            </li>
                            @can('view_cites')
                            <li class="menu-item {{ Request::segment(2)=='cities'&&Request::segment(3)!='create'?'menu-item-active':'' }}" aria-haspopup="true">
                                <a href="{{route('admin.cities.index')}}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">{{ __('All Cities') }}</span>
                                </a>
                            </li>
                            @endcan

                            @can('create_cites')
                            <li class="menu-item {{ Request::segment(2)=='cities'&&Request::segment(3)=='create'?'menu-item-active':'' }}" aria-haspopup="true">
                                <a href="{{route('admin.cities.create')}}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">{{ __('Add New City') }}</span>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                {{--  End Cities --}}
                @endcan


                @endcan
                @can('view_user_activities')
                <li class="menu-item {{ Request::segment(2)=='user-activities'?'menu-item-active':'' }}" aria-haspopup="true">
                    <a href="{{route('admin.user.activities.index')}}" class="menu-link">
                        <span class="svg-icon menu-icon">
                            <i class="fas fa-shoe-prints"></i>
                      </span>
                        <span class="menu-text">{{ __('User Activities') }}</span>
                    </a>
                </li>
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
                                <a href="{{route('admin.currencies.index')}}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">عرض جميع العملات</span>
       
                                </a>
                            </li>
                            @endcan
                            @can('create_currencies')
                            <li class="menu-item {{ Request::segment(2)=='currencies'&&Request::segment(3)=='create'?'menu-item-active':'' }}" aria-haspopup="true">
                                <a href="{{route('admin.currencies.create')}}" class="menu-link">
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
                    <a href="{{route('admin.settings.edit',1)}}" class="menu-link">
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
                        {{-- <i class="menu-arrow"></i> --}}
                    </a>
                </li>

                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
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
