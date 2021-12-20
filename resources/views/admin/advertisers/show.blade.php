@extends('admin.layouts.app')
@section('title','Advertisers')
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
                            <h2 class="card-title">{{ __('Comppany Name :') . $advertiser->company_name }} </h2>
                        </div>
                        <!--begin::Form-->
                        <form class="form">
                            @csrf
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="mb-2">
                                        <div class="form-group row">
                                            <div class="col-lg-5">
                                                <label>* اسم الشركة باللغة العربية :</label>
                                                <input type="text" name="company_name_ar" class="form-control"  value="{{$advertiser->company_name_ar}}" dissabled readonly />
                                            </div>


                                            <div class="col-lg-5">
                                                <label>* Company Name In English:</label>
                                                <input type="text" name="company_name_en" class="form-control"  value="{{$advertiser->company_name_en}}" dissabled readonly />
                                            </div>

                                            <div class="col-lg-2">
                                                <label>{{ __('Exclusive') }}</label>
                                                <span class="switch switch-icon">
                                                    <label>
                                                        <input type="checkbox" @if(old('exclusive')) @if(old('exclusive') == 'on') checked='checked' @endif @elseif($advertiser->exclusive) checked='checked' @endif name="exclusive"/>
                                                        <span></span>
                                                    </label>
                                                </span>
                                            </div>

                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>* {{ __('Contact Person Name') }} :</label>
                                                <input type="text" name="name" class="form-control"  value="{{$advertiser->name}}" dissabled readonly />
                                            </div>

                                            <div class="col-lg-6">
                                                <label>* {{ __('Phone') }} :</label>
                                                <input type="text" name="phone" class="form-control" value="{{$advertiser->phone}}" dissabled readonly />
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>* {{ __('Email') }} :</label>
                                                <input type="email" name="email" class="form-control"  value="{{$advertiser->email}}" dissabled readonly />
                                            </div>
                                            <div class="col-lg-6">
                                                <label>* {{ __('Website Link') }} :</label>
                                                <input type="url" name="website" class="form-control" value="{{$advertiser->website}}" dissabled readonly />
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>* {{ __('Validation Source') }} :</label>
                                                <input type="text" name="website" class="form-control" value="{{$advertiser->validation_source}}" dissabled readonly />
                                            </div>

                                            <div class="col-lg-6">
                                                <label>* {{ __('Validation Duration') }} :</label>
                                                <input type="text" name="validation_duration" class="form-control" value="{{$advertiser->validation_duration}}" dissabled readonly />
                                            </div>
                                           
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>* {{ __('Validation Type') }} :</label>
                                                <input type="text" name="validation_duration" class="form-control" value="{{$advertiser->validation_type}}" dissabled readonly />
                                            </div>
                                            <div class="col-lg-6">
                                                <label>* {{ __('Status') }} :</label>
                                                <input type="text" name="validation_duration" class="form-control" value="{{$advertiser->status}}" dissabled readonly />
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>* {{ _('Country') }} :</label>
                                                <input type="text" name="validation_duration" class="form-control" value="{{$advertiser->country?$advertiser->country->name:''}}" dissabled readonly />

                                            </div>
                                            <div class="col-lg-6">
                                                <label>* {{ _('City') }} :</label>
                                                <input type="text" name="validation_duration" class="form-control" value="{{$advertiser->city?$advertiser->city->name:''}}" dissabled readonly />
                                            </div>

                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>* {{ __('Address') }} :</label>
                                                <input type="text" name="address" class="form-control" value="{{$advertiser->address}}" dissabled readonly />
                                            </div>
                                            <div class="col-lg-6">
                                                <label>* {{ __('Categories') }} :</label>
                                                <input type="text" name="address" class="form-control" value="@foreach($advertiser->categories as $category) {{ $category->title }} , @endforeach" dissabled readonly />
                                                
                                            </div>

                                           
                                           
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>* {{ __('Access Username Or Email') }} :</label>
                                                <input type="text" name="access_username" class="form-control" value="{{$advertiser->access_username}}" dissabled readonly />
                                            </div>
                                            <div class="col-lg-6">
                                                <label>* {{ __('Access Password') }} :</label>
                                                <input type="text" name="access_password" class="form-control"  value="{{$advertiser->access_password}}" dissabled readonly />
                                            </div>
                                        </div>

                                        <div class="form-group row">

                                            <div class="col-lg-6">
                                                <label>* {{ __('Currency') }} :</label>
                                                <input type="text" name="access_password" class="form-control"  value="{{$advertiser->currency?$advertiser->currency->name:''}}" dissabled readonly />
                                            </div>


                                            <div class="col-lg-6">
                                                <label>* {{ __('Language') }} :</label>
                                                <input type="text" name="access_password" class="form-control"  value="{{$advertiser->language}}" dissabled readonly />

                                            </div>

                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-12">
                                                <label>* {{ __('Note') }} :</label>
                                                <textarea name="note"  class="form-control" id="" cols="30" rows="10" disabled readonly>{{$advertiser->note}}</textarea>
                                            </div>
                                        </div>



                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-12 text-center">
                                        <a href="{{route('admin.advertisers.index')}}">
                                            <button type="button" class="btn btn-primary font-weight-bold mr-2">
                                                {{ __('Back') }}
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Card-->
                    @can('view_user_activities')
                        <div class="card card-custom example example-compact">
                            <div class="card-header">
                                <h2 class="card-title">{{ __('User Activities') }} </h2>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered text-center">
                                    <thead>
                                        <tr>
                                        <th scope="col">{{ __('Mission') }}</th>
                                        <th scope="col">{{ __('Updated By') }}</th>
                                        <th scope="col">{{ __('Created At') }}</th>
                                        <th scope="col">{{ __('Show History') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(getActivity('Advertiser',$advertiser->id ) as $activity)
                                            <tr>
                                                <td>{{ $activity->mission }}</td>
                                                <td> <a href="{{ route('admin.users.show',  $activity->user_id) }}" target="_blank" >{{ $activity->user->name }}</a> </td>
                                                <td>{{ $activity->created_at }}</td>
                                                <td>
                                                    @if(unserialize($activity->history))
                                                    <button class="btn btn-success show-history" data-id="{{ $activity->id }}">{{ __('Show') }}</button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    </table>
                            </div>
                        </div>
                        @endcan
                </div>
            </div>
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
@endsection
