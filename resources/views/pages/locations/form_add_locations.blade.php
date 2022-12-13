@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="container">
            <div class="row layout-top-spacing">
                <div id="basic" class="col-lg-12 layout-spacing">
                    <h4><b>Create Locations</b></h4>
                    <div class="statbox widget box box-shadow">
                        <div class="widget-header">
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">

                                </div>
                            </div>
                        </div>

                        <div class="widget-content widget-content-area">
                            <form id="createLocation" class="simple-example" enctype="multipart/form-data"
                                action="javascript:void(0);" method="POST">
                                <div class="input-group mb-5">
                                    <div class="col-md-2">
                                        <label>Country</label>
                                    </div>
                                    <input id="country" type="text" class="form-control" placeholder="Country"
                                        aria-label="Country" required>
                                </div>

                                <div class="input-group mb-5">
                                    <div class="col-md-2">
                                        <label>State</label>
                                    </div>
                                    <input type="text" id="state" class="form-control" placeholder="State"
                                        aria-label="State">
                                </div>

                                <div class="input-group mb-5">
                                    <div class="col-md-2">
                                        <label>City</label>
                                    </div>
                                    <input id="city" type="text" class="form-control" placeholder="City"
                                        aria-label="City">
                                </div>

                                <div class="input-group mb-5">
                                    <div class="col-md-2">
                                        <label>Neighbor hood</label>
                                    </div>
                                    <input id="neighborhood" type="text" class="form-control" placeholder="Neighborhood"
                                        aria-label="Neighborhood">
                                </div>

                                <div class="input-group mb-5">
                                    <div class="col-md-2">
                                        <label>Zip Code</label>
                                    </div>
                                    <input id="zip" type="text" class="form-control" placeholder="Zip Code"
                                        aria-label="Zip Code">
                                </div>

                                <div class="input-group mb-5">
                                    <div class="col-md-2">
                                        <label>Location Level</label>
                                    </div>
                                    <select class="form-control" name="location_level" id="location_level">
                                        <option value="">--Select Location Level--</option>
                                        <option value="Country">Country</option>
                                        <option value="State">State</option>
                                        <option value="City">City</option>
                                        <option value="Neighborhood">Neighborhood</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Create</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
