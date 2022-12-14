@extends('layouts.app')

@section('content')
    <div class="layout-px-spacing">

        <div class="row layout-top-spacing">

            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h2><b>Post by Blocks</b></h2>

                <div class="widget-content widget-content-area br-6">
                    {{-- <div class="row" hidden>
                        <form class="form-inline" method="POST" id="search" action="/post/hide/1">
                            @csrf
                            <div class="widget-content widget-content-area">
                                <div class="row">
                                    <div class="form-group">
                                        <div class="mr-3 ml-3">
                                            <select name="main_feed" id="mainFeed" class="form-control">
                                                <option value="">Select Feed group</option>
                                                <option value="main_feed">Main Feed</option>
                                                <option value="user">User</option>
                                                <option value="topic">Topic</option>
                                                <option value="timeline">Timeline</option>
                                            </select>
                                        </div>
                                        <div class="input-group">
                                            <select class="form-control select-2" name="user_id" id="userId">
                                                <option value="">Select User</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->user_id }}">{{ $user->username }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-search">Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="col-lg-2">

                        </div>
                    </div> --}}


                    <div class="table-responsive mb-4 mt-4">
                        <table id="tablePostBlock" class="table table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>username</th>
                                    <th>message</th>
                                    <th>privacy</th>
                                    <th>Anonymous</th>
                                    <th>Status</th>
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