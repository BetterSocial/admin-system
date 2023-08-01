@extends('layouts.app')

@section('content')
    <div class="layout-px-spacing">

        <div class="row layout-top-spacing">

            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h2><b>Show Post List</b></h2>

                <div class="widget-content widget-content-area br-6">
                    <div class="row">
                        <div class=col-lg-10>
                            <form class="form-inline" method="POST" id="search">
                                <div class="form-group">
                                    <input type="hidden" id="userId" value="{{ $data->user_id }}" readonly
                                        class="form-control">
                                    &nbsp;&nbsp;&nbsp;
                                </div>
                            </form>
                        </div>
                    </div>


                    <div class="table-responsive mb-4 mt-4">
                        <table id="tableShowPostList" class="table table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Post Id</th>
                                    <th>Content</th>
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
