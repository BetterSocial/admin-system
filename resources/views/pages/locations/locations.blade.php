@extends('layouts.app')

@section('content')
    <div class="layout-px-spacing">

        <div class="row layout-top-spacing">

            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="widget-header">
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                <h4>Locations</h4>
                            </div>
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
                                <th>Slug</th>
                                <th>Action</th>

                            </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Zip</th>
                                <th>Neighborhood</th>
                                <th>City</th>
                                <th>State</th>
                                <th>Country</th>
                                <th>Location Level</th>
                                <th>Slug</th>
                                <th>Action</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
