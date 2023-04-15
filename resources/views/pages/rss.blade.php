@extends('layouts.app')

@section('content')
    <div class="layout-px-spacing">

        <div class="row layout-top-spacing">

            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h2><b>Rss Links</b></h2>

                <div class="widget-content widget-content-area br-6">
                    <div class="table-responsive mb-4 mt-4">
                        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addRssLink">Add New
                                Rss</button>
                        </div>
                        <table id="tableRss" class="table table-hover" style="width:100%" aria-describedby="listLogs">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Domain Name</th>
                                    <th style="width: 30%">Link</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rss as $item)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $item->domain_name }}</td>
                                        <td>{{ $item->link }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-primary btn-edit"
                                                data-rss="{{ $item }}">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                            <form action="{{ route('rss.remove', $item->id) }}" method="POST">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure?')">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="addRssLink" tabindex="1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('rss.add') }}" method="post" id="modal-category">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabel">Add New Rss Link</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="">
                            <div id="cardCategory" class="">
                                <input type="text" id="topicId" name="topic_id" hidden>
                                <div class="form-group">
                                    <label for="topicName">Domain Name</label>
                                    <input type="text" class="form-control" placeholder="bettersocial.org"
                                        name="domain_name" required>
                                </div>
                                <div class="form-group">
                                    <label for="categorySelect">Link</label>
                                    <input type="text" class="form-control" placeholder="" name="link" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-submit-category">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editRssLink" tabindex="1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('rss.add') }}" method="post" id="modal-category">
                    @csrf
                    @method('put')
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabel">Add New Rss Link</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="">
                            <div id="cardCategory" class="">
                                <input type="text" id="topicId" name="topic_id" hidden>
                                <div class="form-group">
                                    <label for="topicName">Domain Name</label>
                                    <input type="text" id="editDomain" class="form-control" name="domain_name" required>
                                </div>
                                <div class="form-group">
                                    <label for="categorySelect">Link</label>
                                    <input type="text" id="editLink" class="form-control" placeholder=""
                                        name="link" required>
                                </div>
                            </div>
                        </div>
                        <input type="text" id="editId" name="id" hidden>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-submit-category">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        let dataTable;
        $(document).ready(function() {
            $('#tableRss').DataTable();


            $('#tableRss').on('click', '.btn-edit', function() {

                let rss = $(this).data('rss');
                console.log(rss);
                console.log(rss.domain_name);
                $('#editDomain').val(rss.domain_name);
                $('#editId').val(rss.id);
                $('#editLink').val(rss.link);
                $('#editRssLink').modal('show');
            });
        })
    </script>
@endpush
