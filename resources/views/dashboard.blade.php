@extends('layouts.app')

@section('content')

            <div class="layout-px-spacing">
                <div class="row sales">

                    @if (session()->has('flash_notification.message'))
                        <div class="container">
                            <div class="alert alert-{{ session()->get('flash_notification.level') }}">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                {!! session()->get('flash_notification.message') !!}
                            </div>
                        </div>
                    @endif

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif

                    @if ($message = Session::get('error'))
                        <div class="alert alert-danger alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif

                    @if ($message = Session::get('warning'))
                        <div class="alert alert-warning alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif

                    @if ($message = Session::get('info'))
                        <div class="alert alert-info alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            Please check the form below for errors
                        </div>
                    @endif

                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                        <div class="widget-three">
                            <div class="widget-heading">
                                <h5 class="">Summary</h5>
                            </div>
                            <div class="widget-content">

                                <div class="order-summary">

                                    <div class="summary-list">
                                        <div class="icon">
                                            <img src="{{asset('storage/img/user.png')}}" width="24" height="24" fill="none" stroke="currentColor"  class="feather feather-shopping-bag">
                                        </div>
                                        <div class="w-summary-details">
                                            
                                            <div class="w-summary-info">
                                                <h6>Total Users</h6>
                                                <p class="summary-count">{{$total_user}}</p>
                                            </div>

                                           

                                        </div>

                                    </div>

                                    <div class="summary-list">
                                        <div class="icon">
                                        <img src="{{asset('storage/img/flag_location.png')}}" width="24" height="24" fill="none" stroke="currentColor"  class="feather feather-shopping-bag">                                        </div>
                                        <div class="w-summary-details">
                                            
                                            <div class="w-summary-info">
                                                <h6>Total Location</h6>
                                                <p class="summary-count">{{$total_location}}</p>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="summary-list">
                                        <div class="icon">
                                        <img src="{{asset('storage/img/hastag.png')}}" width="24" height="24" fill="none" stroke="currentColor"  class="feather feather-shopping-bag">                                        </div>
                                        <div class="w-summary-details">
                                            
                                            <div class="w-summary-info">
                                                <h6>Total Topic</h6>
                                                <p class="summary-count">{{$total_topic}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

{{--                <br><br>--}}
{{--                <a href="/sample-getstream"> <button class="btn btn-primary"><b style="color:white">Sample Panggil Function</b></button> </a>--}}
            </div>

@endsection
