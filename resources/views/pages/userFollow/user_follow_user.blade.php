@extends('layouts.app')

@section('content')
            <div class="layout-px-spacing">
                
                <div class="row layout-top-spacing">
                
                    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    <h2><b>{{$title}}</b></h2>
                        
                        <div class="widget-content widget-content-area br-6">
                            <div class ="row">
                                <div class=col-lg-10>
                                    <form class="form-inline" method="POST" id="search">
                                        <div class="form-group">
                                            <input type="hidden" id="userId" value="{{$data->user_id}}" readonly class="form-control">
                                            <input type="hidden" id="type" value="{{$type}}" readonly class="form-control">
                                            <input type="text" id="username" value="{{$data->username}}" readonly class="form-control">
                                            &nbsp;&nbsp;
                                            <input type="text" id="countryCode" value="{{$data->country_code}}" readonly class="form-control">
                                            &nbsp;&nbsp;
                                        </div>
                                    </form>
                                </div>
                            </div>
                             
                            <div class="table-responsive mb-4 mt-4">
                                <table id="tableUsersFollow" class="table table-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>User Id</th>
                                            <th>Username</th>
                                            <th>Real name</th>
                                            <th>Country Code</th>
                                          
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                        <tr>
                                            <th>User Id</th>
                                            <th>Username</th>
                                            <th>Real name</th>
                                            <th>Country Code</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
@endsection