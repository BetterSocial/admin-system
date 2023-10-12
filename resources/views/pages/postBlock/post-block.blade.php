@extends('layouts.app')

@section('content')
    <div class="layout-px-spacing">

        <div class="row layout-top-spacing">

            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h2><b>Post by Blocks</b></h2>


                <div class="widget-content widget-content-area br-6">
                    <div class="row">
                        <div class=col-lg-10>
                            <form class="form-inline" method="POST" id="search">
                                <div class="form-group">
                                    <input type="text" id="total" class="form-control mr-3" placeholder="total"
                                        name="total" value="50">
                                    <button type="submit" class="btn btn-primary">Filter Total Post</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-10 mt-4">
                            <form class="form-inline" method="POST" id="searchMessage">
                                <div class="form-group">
                                    <input type="text" id="message" class="form-control" placeholder="Search">
                                    &nbsp;&nbsp;
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive mb-4 mt-4">
                        <table id="tablePostBlock" class="table table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>username</th>
                                    <th class="w-25 mw-25">message</th>
                                    <th class="w-15 mw-15">Comments</th>
                                    <th>Image</th>
                                    <th>Poll</th>
                                    <th>Upvote</th>
                                    <th>Downvote</th>
                                    <th>Total Block</th>
                                    <th>Status</th>
                                    <th>Post Date</th>
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

    <div class="modal fade" id="detailModal" tabindex="1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="test-class"> testing</p>
                    <table id="tableReaction">

                    </table>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="detailCommentModal" tabindex="1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="">
                        <div id="cardBodyComment" class="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
