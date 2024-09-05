@extends('layouts.app')

@section('content')
    <div class="layout-px-spacing">

        <div class="row layout-top-spacing">

            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h2><b>User Follow Topics</b></h2>

                <div class="widget-content widget-content-area br-6">
                    <div class ="row">
                        <div class=col-lg-10>
                            <form class="form-inline" method="POST" id="search">
                                <div class="form-group">
                                    <input type="hidden" id="topicId" value="{{ $data->topic_id }}" readonly
                                        class="form-control">
                                    <input type="text" id="topicName" value="{{ $data->name }}" readonly
                                        class="form-control">
                                    &nbsp;&nbsp;
                                    <input type="text" id="topicCategory" value="{{ $data->categories }}" readonly
                                        class="form-control">

                                    &nbsp;&nbsp;
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive mb-4 mt-4">
                        <table id="tableUsers" class="table table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>User Id</th>
                                    <th>Username</th>
                                    <th>Country Code</th>
                                    <th>Followed at</th>
                                    <th>Anon Follower</th>
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
@push('js')
    <script>
        $(document).ready(function() {
            var id = $('#topicId').val();
            var datatble = $('#tableUsers').DataTable({
                "searching": false,
                "processing": true,
                "stateSave": true,
                "lengthMenu": [50, 100, 250],
                "pageLength": 50,
                "language": {
                    'loadingRecords': '</br></br></br></br>;',
                    'processing': 'Loading...',
                    "emptyTable": "No User Follow This Topic"
                },
                "serverSide": true,
                "ajax": {
                    url: '/user/topic',
                    type: 'get',
                    headers: {
                        "X-CSRF-Token": $("meta[name=csrf-token]").attr("content")
                    },
                    data: function(d) {

                        d.topic_id = id
                    },
                },
                columns: [{

                        "data": 'user_id',
                        "visible": false,
                    },
                    {
                        "data": 'username',
                        "className": 'menufilter textfilter',
                    },
                    {
                        "data": 'country_code',
                        "orderable": true,
                    },
                    {
                        "data": 'created_at',
                        "orderable": true,
                    },
                    {
                        "data": 'is_anonymous',
                        "orderable": true,
                    },

                ],

            });

        });
    </script>
@endpush
