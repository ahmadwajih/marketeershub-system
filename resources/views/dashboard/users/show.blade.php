@extends('dashboard.layouts.app')
@section('title','المستخدمين')
@section('content')
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">

            <!--begin::Card-->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-custom example example-compact">
                        <div class="card-header">
                            <h2 class="card-title">اسم المتجر : 
                                <a class="btn btn-primary" target="_blank" href="{{"https://www.".$user->subdomain_name.'.'.str_replace('/', '',substr(Request::root(), 7)) }}">{{$user->store_name}}</a>
                            </h2>
                        </div>
                        <!--begin::Form-->
                        <form class="form">
                            @csrf
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="mb-2">
                                        <div class="form-group row">
                                            <div class="col-12 text-center">
                                                <div class="image-input image-input-outline image-input-circle" id="kt_image">
                                                    <div class="image-input-wrapper"  style="background-image: url( {{getImagesPath("Users").$user->image}}" ></div>
                                                </div>
                                            </div>
                                        </div>
                                         
                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label> Subdomain  :</label>
                                                <input class="form-control" disabled  value="{{$user->subdomain_name }}" />
                                            </div>
                                            <div class="col-lg-6">
                                                <label>اسم مدير المتجر :</label>
                                                <input class="form-control" disabled  value="{{$user->store_manager}}" />
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label> اخر تجديد للباقة  :</label>
                                                <input class="form-control" disabled  value="{{$user->renewal_date }}" />
                                            </div>
                                            <div class="col-lg-6">
                                                <label>تاريخ انتهاء الاشتراك :</label>
                                                <input class="form-control" disabled  value="{{$user->expire_date}}" />
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label> اسم المتجر  :</label>
                                                <input class="form-control" disabled  value="{{$user->store_name }}" />
                                            </div>
                                            <div class="col-lg-6">
                                                <label>الموقع الالكتروني :</label>
                                                <input class="form-control" disabled  value="{{$user->website}}" />
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label> البريد الالكتروني:</label>
                                                <input class="form-control" disabled  value="{{$user->email }}" />
                                            </div>
                                            <div class="col-lg-6">
                                                <label> رقم الموبيل :</label>
                                                <input class="form-control" disabled  value="{{$user->phone}}" />
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>هنا لكي : </label>
                                                <input class="form-control" disabled  value="{{$user->are_you_selling }}" />
                                            </div>
    
                                            <div class="col-lg-6">
                                                <label>المستوي:</label>
                                                <input class="form-control" disabled  value="{{$user->level_id != null ? $user->level->name:""}}" />
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>  لينك المتجر الإلكتروني (اذا كان لديك متجر الكتروني)  </label>
                                                <input class="form-control" disabled  value="{{$user->your_online_store }}" />
                                            </div>
                                            <div class="col-lg-6">
                                                <label> الباقة  </label>
                                                <input class="form-control" disabled  value="{{$user->package->name}}" />
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>الدولة  </label>
                                                <input class="form-control" disabled  value="{{$user->country_id != null ? $user->country->name:"" }}" />
                                            </div>
                                       
                                            <div class="col-lg-6">
                                                <label>المحافظة</label>
                                                <input class="form-control" disabled  value="{{$user->governorate_id !=null ? $user->governorate->name:""}}" />
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label> االعنوان: </label>
                                                <input class="form-control" disabled  value="{{$user->address }}" />
                                            </div>
                                            <div class="col-lg-6">
                                                <label>  الرقم البريدي :</label>
                                                <input class="form-control" disabled  value="{{$user->post_code}}" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                
                                                <label> اللينك الخاص به: </label>
                                                <a target="_blank" href="{{"https://www.".$user->subdomain_name.'.'.str_replace('/', '',substr(Request::root(), 7)) }}">{{"https://www.".$user->subdomain_name.'.'.str_replace('/', '',substr(Request::root(), 7)) }}</a>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-12 text-center">
                                        <a href="{{route('admin.users.index')}}">
                                            <button type="button" class="btn btn-primary font-weight-bold mr-2">
                                                العـوده
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Card-->
                </div>
            </div>
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
@endsection
