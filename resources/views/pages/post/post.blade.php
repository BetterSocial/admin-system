@extends('layouts.app')

@section('content')
    <div class="layout-px-spacing">

        <div class="row layout-top-spacing">

            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h2><b>Post</b></h2>


                <div class="widget-content widget-content-area br-6">

                    <div class="form-group">
                        <form action="{{ route('post.download-template') }}" method="post">
                            @csrf
                            <button class="btn btn-info" type="submit">Download
                                Template</button>
                        </form>
                    </div>
                    <div class="div">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#uploadCsv">Upload
                            CSV</button>
                    </div>



                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="uploadCsv" tabindex="1" aria-labelledby="uploadCsvLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form method="POST" action="{{ route('post.upload') }}" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="uploadCsvLabel">Upload File CSV</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="file">CSV File</label>
                            <input type="file" class="form-control-file" id="file" name="csv_file" accept=".csv"
                                required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>
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
                            <!-- Single answer -->
                            {{-- <div class="d-flex mb-3"> --}}
                            <!-- item image -->
                            {{-- <a href="">
                                    <img src="https://mdbcdn.b-cdn.net/img/new/avatars/10.webp"
                                        class="border rounded-circle me-2" alt="Avatar" style="height: 40px" />
                                </a> --}}
                            <!-- item image -->

                            <!-- container content -->
                            {{-- <div>
                                    <div class="bg-light rounded-3 px-3 py-1">
                                        <a href="" class="text-dark mb-0">
                                            <strong>Hollie James</strong>
                                        </a>
                                        <a href="" class="text-muted d-block">
                                            <small>Voluptatibus quaerat suscipit in nostrum
                                                necessitatibus</small>
                                        </a>
                                    </div>
                                </div> --}}

                            <!-- container content -->
                            {{-- </div> --}}


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
