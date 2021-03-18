@extends('layouts.app')

@section('content')
            <div class="layout-px-spacing">
                
                <div class="row layout-top-spacing">
                
                    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    <h2>Topics</h2>
                        <form class="form-inline" method="POST" id="search">
                                <div class="form-group">
                                    <input type="text" id="name" class="form-control" placeholder="Name">
                                    <input type="text" id="category" class="form-control" placeholder="Category">
                                    </div>
                                    <div class="form-group">
                                    <input type="text" id="zip" class="form-control" placeholder="Zip">
                                    <input type="text" id="location" class="form-control" placeholder="Location">
                                    </div>
                                    <div class="form-group">
                                    <input type="text" id="city" class="form-control" placeholder="City">
                                    <input type="text" id="state" class="form-control" placeholder="State">
                                    <input type="text" id="country" class="form-control" placeholder="Country">
                                    <button type="submit" class="btn btn-primary">Search</button>                              </div>
                            </form>
                        <div class="widget-content widget-content-area br-6">
                           
                            <div class="table-responsive mb-4 mt-4">
                                <table id="tableTopics" class="table table-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>id</th>
                                            <th>Name</th>
                                            <th>Icon</th>
                                            <th>Categories</th>
                                            <th>Location</th>
                                            <th>Created at</th>
                                            <th class="no-content">Followers</th>
                                            <th class="no-content">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                        <tr>
                                            <th>id</th>
                                            <th>Name</th>
                                            <th>Icon</th>
                                            <th>Categories</th>
                                            <th>Location</th>
                                            <th>Created at</th>
                                            <th class="no-content">Followers</th>
                                            <th class="no-content">Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
@endsection