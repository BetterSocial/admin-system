@extends('layouts.app')

@section('content')
            <div class="layout-px-spacing">
                
                <div class="row layout-top-spacing">
                
                    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    <h2><b>Domain</b></h2>
                        
                        <div class="widget-content widget-content-area br-6">
                            <div class ="row">
                                <div class=col-lg-10>
                                    <form class="form-inline" method="POST" id="search">
                                        <div class="form-group">
                                            <input type="text" id="domainName" class="form-control" placeholder="Domain Name">
                                            &nbsp;&nbsp;
                                            <button type="submit" class="btn btn-primary">Search</button>                              
                                        </div>
                                    </form>
                                </div>
                            </div>
                            
                             
                            <div class="table-responsive mb-4 mt-4">
                                <table id="tableDomain" class="table table-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="no-content">Action</th>
                                            <th>id</th>
                                            <th>Domain Name</th>
                                            <th>Logo</th>
                                            <th>Short Description</th>
                                            <th>Created At</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="no-content">Action</th>
                                            <th>id</th>
                                            <th>Domain Name</th>
                                            <th>Logo</th>
                                            <th>Short Description</th>
                                            <th>Created At</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection
