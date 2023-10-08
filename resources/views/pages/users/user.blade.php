@extends('layouts.app')

@section('content')
    <div class="layout-px-spacing">

        <div class="row layout-top-spacing">

            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h2><b>Users</b></h2>

                <div class="widget-content widget-content-area br-6">
                    <div class="row">
                        <div class=col-lg-10>
                            <form class="form-inline" method="POST" id="search">
                                <div class="form-group">
                                    <input type="text" id="username" class="form-control" placeholder="Username">
                                    <input type="text" id="countryCode" class="form-control mx-3"
                                        placeholder="Country Code">
                                    <input type="text" name="topic" id="topic" class="form-control mr-3"
                                        placeholder="Topic">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-2">
                            @unlessrole('viewer')
                                <button class="btn btn-primary" onClick='downloadCsv()' id='downloadCsv'><b
                                        style="color:white">Download CSV</b></button>
                            @endunlessrole
                        </div>
                    </div>


                    <div class="table-responsive mb-4 mt-4">
                        <table id="tableUsers" class="table table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="no-content">Action</th>
                                    <th>User Id</th>
                                    <th>Username</th>
                                    <th>Country Code</th>
                                    <th>Registered At</th>
                                    <th>Status</th>
                                    <th>Followers</th>
                                    <th>Following</th>
                                    <th>Posts</th>
                                    <th>Sessions</th>
                                    <th>User Score</th>
                                    <th>Blocked (signed:2/anon:1)</th>
                                    <th>Topics</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
