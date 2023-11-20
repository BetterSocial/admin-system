@extends('layouts.app')

@section('content')
    <div class="layout-px-spacing">

        <div class="row layout-top-spacing">

            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h2>List Comment by <b>{{ $user->username }} </b></h2>
                <input type="text" name="user_id" id="user_id" value="{{ request()->input('user_id') }}" hidden>

                <div class="widget-content widget-content-area br-6">

                    <div class="table-responsive mb-4 mt-4">
                        <table id="tableCommentUser" class="table table-hover" style="width:100%"
                            aria-describedby="table-description">
                            <thead>
                                <tr>
                                    <th>Post Id</th>
                                    <th>Comment Id</th>
                                    <th>Comment</th>
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
