@extends('layouts.app')

@section('content')
    <div class="layout-px-spacing">

        <div class="row layout-top-spacing">

            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h2><b>Locations</b></h2>

                <div class="widget-content widget-content-area br-6">
                    <div class ="row">
                        <div class=col-lg-9>
                            <form class="form-inline" method="POST" id="search">
                                <div class="form-group col-lg-12">
                                    <div class="col-lg-6">
                                        <input type="text" id="neighborhood" class="form-control" placeholder="Neighborhood">
                                        &nbsp;&nbsp;
                                    </div>

                                    <div class="col-lg-6">
                                        <input type="text" id="city" class="form-control" placeholder="City">
                                    </div>

                                    </br></br></br>
                                    <div class="col-lg-6">
                                        <input type="text" id="state" class="form-control" placeholder="State">
                                        &nbsp;&nbsp;

                                    </div>

                                    <div class="col-lg-6">
                                        <input type="text" id="country" class="form-control" placeholder="Country">
                                    </div>


                                    </br></br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-primary">Search</button>



                                </div>
                            </form>
                        </div>
                        <div class="col-lg-3" align="right">
                            @unlessrole('viewer')
                            <a href="/create-locations"> <button class="btn btn-primary"><b style="color:white">Create Locations</b></button> </a>
                            @endunlessrole
                        </div>
                    </div>

                    <div class="table-responsive mb-4 mt-4">
                        <table id="tableLocations" class="table table-hover" style="width:100%">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Zip</th>
                                <th>Neighborhood</th>
                                <th>City</th>
                                <th>State</th>
                                <th>Country</th>
                                <th>Location Level</th>
                                <th>Icon</th>
                                <th>Action</th>

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
