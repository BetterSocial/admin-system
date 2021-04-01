@extends('layouts.app')

@section('content')
            <div class="layout-px-spacing">
                
                <div class="row layout-top-spacing">
                
                    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    <h2><b>Topics</b></h2>
                        
                        <div class="widget-content widget-content-area br-6">
                            <div class ="row">
                                <div class=col-lg-10>
                                    <form class="form-inline" method="POST" id="search">
                                        <div class="form-group">
                                            <input type="text" id="name" class="form-control" placeholder="Name">
                                            &nbsp;&nbsp;
                                            <input type="text" id="category" class="form-control" placeholder="Category">
                                            &nbsp;&nbsp;
                                            <button type="submit" class="btn btn-primary">Search</button>                              
                                        </div>
                                    </form>
                                </div>
                                <div class="col-lg-2">
                                  @hasanyrole('viewer')
                                    <a href="/create-topics"> <button class="btn btn-primary"><b style="color:white">Create Topics</b></button> </a>
                                  @endhasanyrole
                                </div>
                            </div>
                            
                             
                            <div class="table-responsive mb-4 mt-4">
                                <table id="tableTopics" class="table table-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>id</th>
                                            <th>Name</th>
                                            <th>Icon</th>
                                            <th>Categories</th>
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
