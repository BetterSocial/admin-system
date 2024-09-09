@extends('layouts.app')

@section('content')
    <div class="layout-px-spacing">

        <div class="row layout-top-spacing">

            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h2><b>Users</b></h2>

                <div class="widget-content widget-content-area br-6">
                    <div class="row">
                        <div class="col-lg-10 col-sm-8">
                            <form class="form-inline" method="POST" id="search">
                                <div class="form-group">
                                    <input type="text" id="userId" class="form-control mx-3" placeholder="User Id">
                                </div>
                                <div class="form-group">
                                    <input type="text" id="username" class="form-control mx-3" placeholder="Username">
                                </div>
                                <div class="form-group">
                                    <input type="text" id="countryCode" class="form-control mx-3"
                                        placeholder="Country Code">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="topic" id="topic" class="form-control mr-3"
                                        placeholder="Topic">
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="is_anon1" name="is_anon" class="custom-control-input"
                                            value="on" checked>
                                        <label class="custom-control-label" for="is_anon1">On</label>
                                    </div>
                                    <div class="custom-control custom-radio mx-2">
                                        <input type="radio" id="is_anon2" name="is_anon" class="custom-control-input"
                                            value="off">
                                        <label class="custom-control-label" for="is_anon2">Off</label>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Search</button>
                            </form>
                        </div>
                        <div class="col-lg-2 col-sm-4">
                            @unlessrole('viewer')
                                <button class="btn btn-primary" onClick='downloadCsv()' id='downloadCsv'><b
                                        style="color:white">Download CSV</b></button>
                            @endunlessrole
                        </div>
                    </div>


                    <div class="table-responsive mb-4 mt-4">
                        <table id="tableUsers" class="table table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="no-content">Action</th>
                                    <th>User Id</th>
                                    <th>Username</th>
                                    <th>Country Code</th>
                                    <th>Registered At</th>
                                    <th>Status</th>
                                    <th>Followers</th>
                                    <th>Following</th>
                                    <th>Posts</th>
                                    <th>Comment</th>
                                    <th>Sessions</th>
                                    <th>karma_score</th>
                                    <th>Blocked (signed:2/anon:1)</th>
                                    <th>Topics</th>
                                    <th>Blocked by admin</th>
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
            const formattedDate = (data) => {
                const date = new Date(data);

                const daysOfWeek = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];

                const monthsOfYear = [
                    "Jan",
                    "Feb",
                    "Mar",
                    "Apr",
                    "May",
                    "Jun",
                    "Jul",
                    "Aug",
                    "Sep",
                    "Oct",
                    "Nov",
                    "Dec",
                ];

                const dayName = daysOfWeek[date.getDay()];

                const dayOfMonth = date.getDate();

                const monthName = monthsOfYear[date.getMonth()];

                const year = date.getFullYear();

                const formattedDate = `${dayName}, ${dayOfMonth}-${monthName}-${year}`;
                return formattedDate;
            };

            function createButton(type, text, onclick) {
                return `<button type="button" class="btn btn-${type} btn-sm my-2" onclick="${onclick}">${text}</button>`;
            }

            function createLinkButton(url, text) {
                return `<a href="${url}"><button type="button" class="btn btn-primary btn-sm">${text}</button></a>`;
            }

            var datatble = $("#tableUsers").DataTable({
                searching: false,
                stateSave: true,
                lengthMenu: [10, 100, 1000],
                pageLength: 100,
                language: {
                    loadingRecords: "</br></br></br></br>;",
                    processing: "Loading...",
                    emptyTable: "No User Follow",
                },
                serverSide: true,
                lengthMenu: [
                    [10, 100, 1000],
                    [10, 100, 1000]
                ],
                ajax: {
                    url: "{{ route('user.data') }}",
                    type: "get",
                    headers: {
                        "X-CSRF-Token": $("meta[name=csrf-token]").attr("content")
                    },
                    data: function(d) {
                        d.username = $("#username").val();
                        d.countryCode = $("#countryCode").val();
                        d.topic = $("#topic").val();
                        d.user_id = $("#userId").val();
                        d.is_anon = $('input[name="is_anon"]:checked').val();
                    },
                },
                columns: [{
                        data: "Action",
                        orderable: false,
                        render: function(data, type, row) {
                            let {
                                blocked_by_admin
                            } = row;
                            let html = "";
                            const userDetailViewLink = createLinkButton(
                                `/user-detail-view?user_id=${row.user_id}`,
                                "Show Detail"
                            );
                            html += userDetailViewLink;

                            if (!row.is_banned) {
                                let onclick = "bannedUser(this,'" + row.user_id + "')";
                                const bannedUserBtn = createButton("danger", "Ban User", onclick);
                                html += bannedUserBtn;
                            }

                            let clickBlockUser = "blockUser('" + row.user_id + "')";
                            let clickUnBlockUser = "unBlockUser('" + row.user_id + "')";

                            const btnUnBlockUser = createButton(
                                "primary",
                                "Remove downrank",
                                clickUnBlockUser
                            );
                            const btnBlockUser = createButton(
                                "danger",
                                "Downrank user",
                                clickBlockUser
                            );
                            if (blocked_by_admin) {
                                html += btnUnBlockUser;
                            } else {
                                html += btnBlockUser;
                            }

                            return html;
                        },
                    },
                    {
                        data: "user_id",
                        visible: false,
                    },
                    {
                        data: "username",
                        className: "username-table",
                        render: function(data, type, row) {
                            return `<a href="https://www.instagram.com/${data}" target="_blank">${data}</a>`;
                        },
                    },
                    {
                        data: "country_code",
                        orderable: true,
                    },
                    {
                        data: "created_at",
                        orderable: true,
                        render: function(data, type, row) {
                            return formattedDate(data);
                        },
                    },
                    {
                        data: "status",
                        orderable: false,
                        render: function(data, type, row) {
                            if (row.is_banned) {
                                return "<span class='badge badge-danger'>Banned</span>";
                            } else {
                                return "<span class='badge badge-success'>Active</span>";
                            }
                        },
                    },

                    {
                        data: "followers",
                        orderable: false,
                        render: function(data, type, row) {
                            let followers = [];
                            followers = row.followeds;
                            let total = followers.length;
                            return `<a href="/user-follow-detail?type=FOLLOWERS&user_id=${row.user_id}"> <button type='button' class='btn btn-primary  btn-sm'>#Followers ${total}</button> </a>`;
                        },
                    },
                    {
                        data: "following",
                        orderable: false,
                        render: function(data, type, row) {
                            let followeds = [];
                            followeds = row.followers;
                            let total = followeds.length;
                            return (
                                "<a href='/user-follow-detail?type=FOLLOWING&user_id=" +
                                row.user_id +
                                "'> <button type='button' class='btn btn-primary btn-sm'>#Following " +
                                total +
                                "</button> </a>"
                            );
                        },
                    },
                    {
                        data: "posts",
                        orderable: false,
                        render: function(data, type, row) {
                            return (
                                " <a href='/user-show-post-list?user_id=" +
                                row.user_id +
                                "'> <button type='button' class='btn btn-primary btn-sm'>#posts</button> </a>"
                            );
                        },
                    },
                    {
                        data: "posts",
                        orderable: false,
                        render: function(data, type, row) {
                            return (
                                " <a href='/users/comments?user_id=" +
                                row.user_id +
                                "'> <button type='button' class='btn btn-primary btn-sm'>#coments</button> </a>"
                            );
                        },
                    },
                    {
                        data: "session",
                        orderable: false,
                        render: function(data, type, row) {
                            return " <a href='http://www.facebook.com'> <button type='button' class='btn btn-primary btn-sm'>#session</button> </a>";
                        },
                    },
                    {
                        data: "karma_score",
                        orderable: true,
                        render: function(data, type, row) {

                            return data;
                        },
                    },
                    {
                        data: "user_score",
                        orderable: false,
                        render: function(data, type, row) {
                            let total = 0;
                            if (row.blocked.length >= 1) {
                                total = row.blocked.length;
                            }
                            return `<p> ${total} </p>`;
                        },
                    },
                    {
                        data: "user_topics",
                        orderable: false,
                        render: function(data, type, row) {
                            let text = "";
                            if (row.user_topics.length >= 1) {
                                for (let index = 0; index < row.user_topics.length; index++) {
                                    let userTopic = row.user_topics[index];
                                    let topic = userTopic.topic;
                                    if (topic) {
                                        if (topic.name != null) {
                                            text += topic.name + ", ";
                                        }
                                    }
                                }
                            }
                            return `<p> ${text} </p>`;
                        },
                    },
                    {
                        data: "blocked_by_admin",
                        orderable: false,
                        render: function(data, type, row) {
                            return data;
                        },
                    },
                ],
            });

            $("#search").on("submit", function(e) {
                datatble.draw();
                e.preventDefault();
            });
        });

        function downloadCsv(e) {
            // e.preventDefault();
            var username = $("#username").val();
            var countryCode = $("#countryCode").val();

            var popUpCsv = window.open("{{ route('user.download') }}", "_blank");
            popUpCsv.location =
                "{{ route('user.download') }}" + "?username=" + username + "&countryCode=" + countryCode;
        }

        function confirmAction(
            title,
            userId,
            url,
            successMessage,
            errorMessage,
            successCallback
        ) {
            var formData = new FormData();
            formData.append("user_id", userId);

            Swal.fire({
                title: title,
                text: "",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes",
            }).then(async (result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Please Wait !",
                        showCancelButton: false,
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        willOpen: () => {
                            Swal.showLoading();
                        },
                    });

                    $.ajaxSetup({
                        headers: {
                            "X-CSRF-Token": $("meta[name=csrf-token]").attr("content")
                        },
                    });

                    $.ajax({
                        type: "POST",
                        data: formData,
                        dataType: "JSON",
                        contentType: false,
                        processData: false,
                        url: url,
                        success: function(data) {
                            Swal.close();
                            console.log(data);
                            successCallback(data);
                        },
                        error: function(data) {
                            Swal.close();
                            console.log(data);
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                text: data.responseJSON.message || errorMessage,
                            });
                        },
                    });
                }
            });
        }

        function bannedUser(status, userId) {
            confirmAction(
                "Are you sure?",
                userId,
                `/users/banned/${userId}`,
                "Success",
                "Oops...",
                function(data) {
                    $("#tableUsers")
                        .DataTable()
                        .ajax.reload();
                }
            );
        }

        function blockUser(userId) {
            confirmAction(
                "Are you sure?",
                userId,
                `/users/admin-block-user`,
                "Success",
                "Error",
                function(data) {
                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        text: data.message,
                    });
                    $("#tableUsers")
                        .DataTable()
                        .ajax.reload();
                }
            );
        }

        function unBlockUser(userId) {
            confirmAction(
                "Are you sure?",
                userId,
                `/users/admin-unblock-user`,
                "Success",
                "Error",
                function(data) {
                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        text: data.message,
                    });
                    $("#tableUsers")
                        .DataTable()
                        .ajax.reload();
                }
            );
        }
    </script>
@endpush
