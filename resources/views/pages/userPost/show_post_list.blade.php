@extends('layouts.app')

@section('content')
    <div class="layout-px-spacing">

        <div class="row layout-top-spacing">

            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h2><b>Show Post List</b></h2>

                <div class="widget-content widget-content-area br-6">
                    <div class ="row">
                        <div class=col-lg-10>
                            <form class="form-inline" method="POST" id="search">
                                <div class="form-group">
                                    <input type="hidden" id="userId" value="{{$data->user_id}}" readonly class="form-control">
                                    <input type="text" id="message"  class="form-control">
                                    &nbsp;&nbsp;
{{--                                    <input type="text" id="topicCategory" value="{{$data->categories}}" readonly class="form-control">--}}

                                    &nbsp;&nbsp;
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
{{--                                <th>Timestamp</th>--}}
{{--                                <th>Photos</th>--}}
{{--                                <th>Username</th>--}}
{{--                                <th>Up Votes</th>--}}
{{--                                <th>DownVote</th>--}}
{{--                                <th>Blocks</th>--}}
                            </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                            <tr>
                                <th>Post Id</th>
                                <th>Content</th>
{{--                                <th>Timestamp</th>--}}
{{--                                <th>Photos</th>--}}
{{--                                <th>Username</th>--}}
{{--                                <th>Votes</th>--}}
{{--                                <th>DownVote</th>--}}
{{--                                <th>Blocks</th>--}}
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
