@extends('layouts.app')

@section('content')
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h2><b>News</b></h2>
                <div class="widget-content widget-content-area br-6">
                    <div class ="row">
                        <div class=col-lg-10>
                            <form class="form-inline" method="POST" id="search">
                                <div class="form-group">
                                    <input type="text" id="siteName" class="form-control" placeholder="Site Name">
                                    &nbsp;&nbsp;
                                    <input type="text" id="title" class="form-control" placeholder="Title">
                                    &nbsp;&nbsp;
                                    <input type="text" id="keyword" class="form-control" placeholder="Keyword">
                                    &nbsp;&nbsp;
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive mb-4 mt-4">
                        <table id="tableNews" class="table table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>news_link_id</th>
                                    <th>Action</th>
                                    <th>Domain Page</th>
                                    <th>Site Name</th>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Keyword</th>
                                    <th>Created At</th>
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
