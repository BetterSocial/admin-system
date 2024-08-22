@extends('layouts.app')

@section('content')
    <div class="layout-px-spacing">

        <div class="row layout-top-spacing">

            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h2><b>List Images</b></h2>
                <div class="widget-content widget-content-area br-6">
                    <div class="div mb-3">
                        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#uploadImage">
                            Upload Images</button>
                    </div>
                </div>
                <div class="widget-content widget-content-area br-6">

                    <div class="table-responsive mb-4 mt-4">
                        <table id="tableImage" class="table table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>URL</th>
                                    <th>Preview</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="uploadImage" tabindex="1" aria-labelledby="uploadImageLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form action="{{ route('images.upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="uploadImageLabel">Upload File Image</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="file">Image File</label>
                            <input type="file" class="form-control-file" name="images[]" multiple required>
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
    <!-- Modal untuk Preview Gambar -->
    <div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-labelledby="imagePreviewModalLabel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imagePreviewModalLabel">Image Preview</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img id="previewImage" src="" alt="Preview Image" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        let table;
        $(document).ready(function() {
            table = $("#tableImage").DataTable({
                searching: false,
                stateSave: true,
                language: {
                    processing: "Loading...",
                    emptyTable: "No Data Topics",
                },
                serverSide: true,
                lengthMenu: [
                    [10, 100, 1000],
                    [10, 100, 1000]
                ],
                ajax: {
                    url: "/image/data",
                    type: "POST",
                    headers: {
                        "X-CSRF-Token": $("meta[name=csrf-token]").attr("content")
                    },
                    data: function(d) {
                        d.name = $("#name").val();
                        d.category = $("#category").val();
                    },
                },
                error: function(xhr, error, thrown) {
                    console.log("xhr", xhr);
                    console.log("error", error);
                    console.log("thrown", thrown);
                },
                columns: [{
                        data: "id",
                        name: "id",
                        orderable: true,
                        className: "menufilter textfilter",
                        render: function(data, type, row) {
                            console.log(data);
                            return data;
                        },
                    },
                    {
                        data: "name",
                        orderable: true,
                        className: "menufilter textfilter",
                    },
                    {
                        data: "url",
                        orderable: false,
                        render: function(data, type, row) {
                            let html = `
                                <a href="#" class="url-preview" data-image-url="${data}">
                                    ${data}
                                </a>`;
                            return html;
                        },
                    },
                    {
                        data: "url",
                        orderable: false,
                        render: function(data, type, row) {
                            let html = `
                                <a href="#" class="image-preview" data-image-url="${data}">
                                    <img src="${data}" alt="Preview Image" width="100" height="100">
                                </a>`;
                            return html;
                        },
                    },
                ],
            });

            $('#tableImage').on('click', '.image-preview', function(e) {
                e.preventDefault();
                const imageUrl = $(this).data('image-url');
                $('#previewImage').attr('src', imageUrl);
                $('#imagePreviewModal').modal('show');
            });

            $('#tableImage').on('click', '.url-preview', function(e) {
                e.preventDefault();
                const imageUrl = $(this).data('image-url');
                $('#previewImage').attr('src', imageUrl);
                $('#imagePreviewModal').modal('show');
            });
        });
    </script>
@endpush
