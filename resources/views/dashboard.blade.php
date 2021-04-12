@extends('layouts.app')

@section('content')

            <div class="layout-px-spacing">

               <br>

                    


                <div class="row sales">
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
            </div>

            <br><br>@endsection
