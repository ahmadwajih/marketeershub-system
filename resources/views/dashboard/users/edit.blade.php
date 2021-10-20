@extends('dashboard.layouts.app')
@section('title','Users')
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
                            <h2 class="card-title"> {{ __('User Name') }} {{ $user->name }}</h2>
                        </div>
                        <!--begin::Form-->
                        <form class="form" id="kt_form" action="{{route('dashboard.users.update',$user->id)}}" method = "POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="card-body">
                                @if ($errors->any())
                                    <div class="alert alert-custom alert-light-danger" role="alert" id="kt_form_2_msg" >
                                        <div class="alert-icon">
                                            <i class="flaticon2-bell-5"></i>
                                        </div>
                                        <div class="alert-text font-weight-bold">{{ __('Validation error') }}</div>
                                        <ul>
                                            @foreach($errors->all() as $error )
                                                <li>{{$error}}</li>
                                            @endforeach
                                        </ul>
                                        <div class="alert-close">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span>
                                                <i class="ki ki-close"></i>
                                            </span>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                                <div class="mb-3">
                                    <div class="mb-2">
                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>* {{ __('Name') }} :</label>
                                                <input type="text" name="name" class="form-control"  value="{{old('name') ?? $user->name}}" />
                                                @if ($errors->has('name'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('name') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <label>* {{ __('Phone') }} :</label>
                                                <input type="text" name="phone" class="form-control" value="{{old('phone') ?? $user->phone}}" />
                                                @if ($errors->has('phone'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('phone') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>* {{ __('Email') }} :</label>
                                                <input type="email" name="email" class="form-control"  value="{{old('email') ?? $user->email}}" />
                                                @if ($errors->has('email'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('email') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <label>{{ __('Password') }} :</label>
                                                <input type="password" name="password" class="form-control"  value="{{old('password')}}" />
                                                <b>{{ __('If you don`t need to change password don`t write any thing here.') }}</b>
                                                @if ($errors->has('password'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('password') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-4">
                                                <label>* {{ __('Team') }} :</label>
                                                <select class="form-control select2" id="kt_select_team" name="team" >
                                                    <option {{ $user->team=='management'?'selected':'' }} value="management">{{ __('Management') }}</option>
                                                    <option {{ $user->team=='digital_operation'?'selected':'' }} value="digital_operation">{{ __('Digital Operation') }}</option>
                                                    <option {{ $user->team=='finance'?'selected':'' }} value="finance">{{ __('Finance') }}</option>
                                                    <option {{ $user->team=='media_buying'?'selected':'' }} value="media_buying">{{ __('Media Buying') }}</option>
                                                    <option {{ $user->team=='influencer'?'selected':'' }} value="influencer">{{ __('Influencer') }}</option>
                                                    <option {{ $user->team=='affiliate'?'selected':'' }} value="affiliate">{{ __('Affiliate') }}</option>
                                                </select>
                                                @if ($errors->has('team'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('team') }}</p>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="col-lg-4">
                                                <label>* {{ __('Position') }} :</label>
                                                <select class="form-control select2" id="kt_select_position" name="position" >
                                                    <option {{ $user->position=='employee'?'selected':'' }} value="employee">{{ __('Employee') }}</option>
                                                    <option {{ $user->position=='account_manager'?'selected':'' }} value="account_manager">{{ __('Account Manager') }}</option>
                                                    <option {{ $user->position=='team_leader'?'selected':'' }} value="team_leader">{{ __('Team Leader') }}</option>
                                                    <option {{ $user->position=='head'?'selected':'' }} value="head">{{ __('Head') }}</option>
                                                    <option {{ $user->position=='super_admin'?'selected':'' }} value="super_admin">{{ __('Super Admin') }}</option>
                                                </select>
                                                @if ($errors->has('position'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('position') }}</p>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="col-lg-4">
                                                <label>* {{ _('Role') }} :</label>
                                                <select class="form-control select2" id="kt_select_role_id" name="roles[]" required multiple>
                                                    @foreach($roles as $role)
                                                        <option value="{{$role->id}}"  @if($user->roles->contains($role)) selected @endif>{{$role->name}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('roles'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('roles') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-12">
                                                <label>* {{ __('Belongs To') }} :</label>
                                                <select class="form-control select2" id="kt_select_parent_id" name="parent_id" >
                                                    <option {{  $user->parent_id==null?'selected':''  }} value="null">{{ __('No one') }}</option>
                                                    @foreach ($parents as $parent)
                                                        <option {{ $user->parent_id==$parent->id?'selected':'' }} value="{{ $parent->id }}">{{  $parent->name }} from team {{  $parent->team }} position {{  $parent->position }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('parent_id'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('parent_id') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>* {{ __('Gender') }} :</label>
                                                <select class="form-control select2" id="kt_select_gender" name="gender" >
                                                    <option {{ $user->gender=='male'?'selected':'' }} value="male">{{ __('Male') }}</option>
                                                    <option {{ $user->gender=='female'?'selected':'' }} value="female">{{ __('female') }}</option>
                                                </select>
                                                @if ($errors->has('gender'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('gender') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <label>* {{ __('Status') }} :</label>
                                                <select class="form-control select2" id="kt_select_status" name="status" >
                                                    <option {{ $user->status=='active'?'selected':'' }} value="active">{{ __('Active') }}</option>
                                                    <option {{ $user->status=='pending'?'selected':'' }} value="pending">{{ __('Pending') }}</option>
                                                    <option {{ $user->status=='closed'?'selected':'' }} value="closed">{{ __('Closed') }}</option>
                                                </select>
                                                @if ($errors->has('status'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('status') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>* {{ _('Country') }} :</label>
                                                <select class="form-control select2" id="kt_select_country_id" name="country_id" >
                                                    @foreach($countries as $country)
                                                        <option {{$user->country_id==$country->id?'selected':''}} value="{{$country->id}}">{{$country->name_en}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('country_id'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('country_id') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <label>* {{ _('City') }} :</label>
                                                <select class="form-control select2" id="kt_select_city_id" name="city_id" >
                                                    @foreach($cities as $city)
                                                        <option {{$user->city_id==$city->id?'selected':''}} value="{{$city->id}}">{{$city->name_en}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('city_id'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('city_id') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>*{{ __('Years Of Experience') }} :</label>
                                                <input type="text" name="years_of_experience" class="form-control" value="{{old('years_of_experience') ?? $user->years_of_experience}}" />
                                                @if ($errors->has('years_of_experience'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('years_of_experience') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <label>* {{ __('Address') }} :</label>
                                                <input type="text" name="address" class="form-control" value="{{old('address') ?? $user->address}}" />
                                                @if ($errors->has('address'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('address') }}</p>
                                                    </div>
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-12 text-center">
                                        <button type="reset" class="btn btn-light-primary font-weight-bold">{{ _('Cancel') }}</button>
                                        <button type="submit" class="btn btn-primary font-weight-bold mr-2">{{ _('Submit') }}</button>
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
@push('scripts')
    <script>
        $('#kt_select_team').select2({
            placeholder: "Select Option",
        });
        $('#kt_select_position').select2({
            placeholder: "Select Option",
        });
        $('#kt_select_parent_id').select2({
            placeholder: "Select Option",
        });
        $('#kt_select_gender').select2({
            placeholder: "Select Option",
        });
        $('#kt_select_status').select2({
            placeholder: "Select Option",
        });
        $('#kt_select_package_id').select2({
            placeholder: "Select Option",
        });
        $('#kt_select_country_id').select2({
            placeholder: "Select Option",
        });
        $('#kt_select_city_id').select2({
            placeholder: "You sholud select country",
        });
        $('#kt_select_subscription_type').select2({
            placeholder: "Select Option",
        });
        $('#kt_select_role_id').select2({
            placeholder: "Select Option",
        });
    </script>
    <script>
        $(document).ready(function(){
            $("#kt_select_country_id").on("change",function(){
                var countryId = $("#kt_select_country_id").val();
                console.log(countryId);
                $.ajax({
                    method: "POST",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{route('dashboard.ajax.cities')}}",
                    data: { countryId: countryId}, 
                })
                .done(function(res) {
                    console.log(res);
                    $("#kt_select_city_id").html(res)
                });
            });
        });


    </script>
    <script src="{{asset('dashboard/js/pages/crud/file-upload/image-input.js')}}"></script>
@endpush
