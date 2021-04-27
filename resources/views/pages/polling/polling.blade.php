@extends('layouts.app')

@section('content')
    <div class="layout-px-spacing">

        <div class="row layout-top-spacing">

            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h2><b>Polling List</b></h2>

                <div class="widget-content widget-content-area br-6">
                    <div class ="row">
                        <div class=col-lg-10>
                            <form class="form-inline" method="POST" id="search">
                                <div class="form-group">
                                    <input type="text" id="question"  class="form-control" placeholder="Question">
                                    &nbsp;&nbsp;&nbsp;
                                    <input type="text" id="username"  class="form-control" placeholder="Username">
                                    &nbsp;&nbsp;&nbsp;
                                    <button type="submit" class="btn btn-primary">Search</button>
                                    &nbsp;&nbsp;&nbsp;
                                </div>
                            </form>
                        </div>
                    </div>


                    <div class="table-responsive mb-4 mt-4">
                        <table id="tablePollingList" class="table table-hover" style="width:100%">
                            <thead>
                            <tr>
                                <th>Action</th>
                                <th>Polling Id </th>
                                <th>Question </th>
                                <th>Username </th>
                                <th>Created At </th>
                                <th>Updated At </th>
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
