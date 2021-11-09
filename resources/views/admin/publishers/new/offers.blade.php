@extends('admin.layouts.app')@section('title','Publishers')
@section('content')
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Navbar-->

            <div class="row offers-list">
                @if($offers)
                    @foreach($offers as $offer)
                        <div class="col-lg-3 mb-7">
                            <div class="card card-custom">
                                <div class="card-body">
                                    <div class="brand-logo">
                                        <span>{{ $offer->name }}</span>
                                    </div>
                                </div>
                                <div class="offer-info">
                                    <div class="d-flex justify-content-between">
                                        <strong>{{ $offer->name }}</strong>
                                        <span>Target Market: <strong>Saudi Arabia</strong></span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span>Brand Name:</span> <span> {{$offer->name}} </span>

                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span>Payout: </span><span>Platforms</span>
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-between">
                                    <a href="#" class="btn btn-primary font-weight-bold">Offline / Online</a>
                                    <a href="#" class="btn btn-outline-secondary font-weight-bold">Request Coupon</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>


        </div>
        <!--end::Entry-->
    </div>
    <style>
        .offers-list .card-body {
            min-height: 240px;
            position: relative;
            background-color: #d2d2d2;
        }
        .offers-list .brand-logo {
            position: absolute;
            width: 160px;
            height: 160px;
            background-color: #0a6aa1;
            border-radius: 80px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #fff;
            text-align: center;
            font-size: 20px;
            display: flex;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .offers-list .brand-logo span {
            display: block;
        }
        .offers-list .offer-info {
            padding: 1rem 1rem;
            font-size: 20px;
        }
        .offers-list .card-footer {
            padding: 1rem 1rem;
            background-color: #ffffff;
            border-top: 1px solid #ebedf3;
        }
    </style>
@endsection

