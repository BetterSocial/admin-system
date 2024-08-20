@extends('layouts.app')

@section('content')
    <div class="layout-px-spacing">

        <div class="row layout-top-spacing">

            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h2><b>Topics</b></h2>

                <div class="widget-content widget-content-area br-6">
                    <div class="row">
                        <div class="col-md-12 col-lg-8">
                            <form class="form-inline" method="POST" id="search">
                                <div class="form-group">
                                    <input type="text" id="name" class="form-control" placeholder="Name">
                                    &nbsp;&nbsp;
                                    <input type="text" id="category" class="form-control" placeholder="Category">
                                    &nbsp;&nbsp;
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-12 col-lg-4 my-3 ml-auto">
                            @unlessrole('viewer')
                                <a href="{{ route('topic.create') }}"> <button class="btn btn-primary"><b
                                            style="color:white">Create
                                            Topics</b></button> </a>
                            @endunlessrole
                            <div class="my-2"></div>
                            @unlessrole('viewer')
                                <button class="btn btn-primary btn-limit-topic"><b style="color:white">Change Limit
                                        Topic</b></button>
                            @endunlessrole
                            <div class="my-2"></div>
                            @unlessrole('viewer')
                                <a href="{{ route('topic.export') }}"> <button class="btn btn-primary"><b
                                            style="color:white">Export
                                            Topics</b></button> </a>
                                <br>
                            @endunlessrole
                            <button class="btn btn-primary my-2" data-toggle="modal"
                                data-target="#modalChangeCategory">Change
                                Category</button>
                        </div>
                    </div>


                    <div class="table-responsive mb-4 mt-4">
                        <table id="tableTopics" class="table table-hover" style="width:100%"
                            aria-describedby="topics-table-description">
                            <caption id="topics-table-description">List of topics</caption>
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Icon</th>
                                    <th>Cover</th>
                                    <th>Categories</th>
                                    <th>Created at</th>
                                    <th>Sort</th>
                                    <th class="no-content">Followers</th>
                                    <th>Total Followers</th>
                                    <th>Total Post</th>
                                    <th>Sign</th>
                                    <th class="no-content">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <div class="modal fade" id="detailCategory" tabindex="1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('topic.update') }}" method="post" id="modal-category">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabel">Change Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="">
                            <div id="cardCategory" class="">
                                <input type="text" id="topicId" name="topic_id" hidden>
                                <div class="form-group">
                                    <label for="topicName">Topic</label>
                                    <input type="text" class="form-control" id="topicName" placeholder="topic"
                                        name="name" required>
                                </div>
                                <div class="form-group">
                                    <label for="categorySelect">Category</label>
                                    <select class="form-control" id="categorySelect" name="categories">
                                        <option value="">Select Category</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Or</label><br>
                                    <label for="topicCategory">New Category</label>
                                    <input type="text" class="form-control" id="categoryInput" placeholder="Category"
                                        name="category">
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

    <div class="modal fade" id="modalTopicSort" tabindex="1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('topic.update') }}" method="post" id="formTopicSort">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabel">Change Sort Topic</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="">
                            <div id="cardCategory" class="">
                                <input type="text" id="topicId" name="topic_id" hidden>
                                <div class="form-group">
                                    <label for="topicSort">Sort</label>
                                    <input type="text" class="form-control" id="topicSort" placeholder="topic"
                                        name="sort" required>
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

    <div class="modal fade" id="modalTopicLimit" tabindex="1" aria-labelledby="detailModalLabelLimit"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('topic.limit.create') }}" method="post" id="formTopicLimit">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabelLimit">Change Limit Topic</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Current limit</label>
                            <input type="text" class="form-control current-limit-topic" value="2" disabled>
                        </div>
                        <div class="">
                            <div id="cardCategory" class="">
                                <div class="form-group">
                                    <label for="topicSort">Limit Topic</label>
                                    <input type="number" class="form-control" id="limitTopic" placeholder="0"
                                        name="sort" required>
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
    <div class="modal fade" id="modalTopicSign" tabindex="1" aria-labelledby="detailModalLabelTopicSign"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="post" id="formTopicSign">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabelTopicSign">Add Topic to OB</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <p><b>Show Topic in Onboarding</b></p>
                        </div>
                        <div class="form-group">
                            <label for="">Topic ID</label>
                            <input type="text" class="form-control topic-id-sign" name="topic_id" readonly>
                        </div>
                        <div class="form-group">
                            <label for="topicSort">Topic Name</label>
                            <input type="text" class="form-control name-topic-sign" placeholder="" name="sort"
                                disabled>
                        </div>
                        <div class="form-group">
                            <label for="topicSort">Category</label>
                            <input type="text" class="form-control category-topic-sign" placeholder=""
                                name="category" disabled>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary ">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalTopicUnSign" tabindex="1" aria-labelledby="detailModalLabelTopicUnSign"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="post" id="formUnSignTopic">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabelTopicUnSign">Remove from OB</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <p><b> Topic is disappear in onboarding</b></p>
                        </div>
                        <div class="form-group">
                            <label for="">Topic ID</label>
                            <input type="text" class="form-control topic-id-sign" name="topic_id" readonly>
                        </div>
                        <div class="form-group">
                            <label for="topicSort">Topic Name</label>
                            <input type="text" class="form-control name-topic-sign" placeholder="" name="sort"
                                disabled>
                        </div>
                        <div class="form-group">
                            <label for="topicSort">Category</label>
                            <input type="text" class="form-control category-topic-sign" placeholder=""
                                name="category" disabled>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalSameTopic" tabindex="1" aria-labelledby="detailModalLabelLimit"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('topic.remove-duplicate') }}" method="post" id="formSameTopic">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabelLimit">Remove the same topic</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="">
                            <div id="cardCategory" class="">
                                <div class="form-group">
                                    <label for="topicSort">Which one will be deleted?</label>
                                    <select class="form-control" name="option" id="" required>
                                        <option value="">Select Option</option>
                                        <option value="latest">The latest one</option>
                                        <option value="oldest">The oldest one</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div>
                            <p>"If you choose the latest one,
                                all the latest topics will be deleted,
                                leaving only the oldest
                                topic. On the other hand, if you choose the oldest one,
                                all the oldest topics will be
                                deleted, leaving only the newest topic."
                            </p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-submit-category"
                            onclick="confirm('Are You sure?')">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalChangeIcon" tabindex="1" aria-labelledby="detailModalLabelLimit"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('topic.update-image') }}" method="POST" id="formChangeIcon"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <h5 class="title-modal-icon"></h5>
                        <div class="custom-file-container" data-upload-id="myFirstImage">
                            <label>Icon <a href="javascript:void(0)" class="custom-file-container__image-clear"
                                    title="Clear Image">x</a></label>
                            <label class="custom-file-container__custom-file">
                                <input id=file type="file"
                                    class="custom-file-container__custom-file__custom-file-input" accept="image/x-png"
                                    name="file">
                                <input type="hidden" name="MAX_FILE_SIZE" value="1024" />
                                <span class="custom-file-container__custom-file__custom-file-control"></span>
                            </label>
                            <div class="custom-file-container__image-preview"></div>
                        </div>
                        <input type="text" class="type-upload" name="type" hidden>
                        <input type="text" class="topic-id" name="id" hidden>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-submit-category"
                            onclick="confirm('Are You sure?')">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalChangeCategory" tabindex="1" aria-labelledby="detailModalLabelLimit"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Change or Delete Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="oldCategory">Old Category</label>
                        <input type="email" class="form-control" id="oldCategory" name="category"
                            placeholder="Enter Category" aria-describedby="emailHelp" required>
                    </div>
                    <div class="form-group">
                        <label for="newCategory">New Category</label>
                        <input type="email" class="form-control" id="newCategory" name="category"
                            placeholder="Enter Category" aria-describedby="emailHelp" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-change-category">Change</button>
                    <button type="button" class="btn btn-danger btn-delete-category">Delete</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        let dataTable;

        let categories = [];

        let currentLimitTopic = 0;

        function cleanCode() {
            $(this)
                .find("input")
                .val("");
            $(this)
                .find("select")
                .prop("selectedIndex", 0);
            $(this)
                .find("textarea")
                .val("");
        }

        function deleteTopic(topicId) {
            console.log('topicid', topicId);
            Swal.fire({
                title: 'Are you sure?',
                text: "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/topics/destroy/${topicId}`,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            console.log(response);
                            if (response.status === 'success') {
                                dataTable.ajax.reload(null, false);
                            } else {
                                Swal.fire(
                                    'Error!',
                                    response.message,
                                    'error'
                                );
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr);
                            console.log(status);
                            console.log(error);
                            Swal.fire(
                                'Error!',
                                'An error occurred while trying to delete the topic.',
                                'error'
                            );
                        }
                    });
                }
            });

        }




        $('#detailCategory').on('show.bs.modal', function(e) {
            $('#categoryInput').val(''); // Clear the New Category field
        });

        async function getCurrentLimitTopic() {
            try {
                const response = await fetch("/topic/limit", {
                    method: "GET",
                    headers: {
                        "X-CSRF-Token": $("meta[name=csrf-token]").attr("content"),
                    },
                });
                let res = await response.json();
                if (res.status === "success") {
                    currentLimitTopic = res.data.limit;
                }
            } catch (error) {}
        }

        async function getCategory() {
            try {
                const response = await fetch("{{ route('topic.category') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-Token": $("meta[name=csrf-token]").attr("content"),
                    },
                });
                let res = await response.json();
                if (res.status === "success") {
                    return res.data;
                }
            } catch (err) {}
        }

        async function updateCategoryList() {
            try {
                const response = await fetch("{{ route('topic.category') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-Token": $("meta[name=csrf-token]").attr("content"),
                    },
                });
                let res = await response.json();
                if (res.status === "success") {
                    categories = res.data;
                    const categorySelect = $("#categorySelect");
                    categorySelect.empty();
                    categorySelect.append('<option value="">Select Category</option>');
                    categorySelect.append('<option value="delete">** Delete Category **</option>');
                    categories.forEach((item) => {
                        categorySelect.append(
                            `<option value="${item.categories}">${item.categories}</option>`
                        );
                    });
                }
            } catch (err) {
                console.error("Error updating category list", err);
            }
        }

        $("#modal-category").submit(async function(e) {
            e.preventDefault();
            let form = $(this);
            let url = form.attr("action");
            let topicId = $("#topicId").val();
            let topicName = $("#topicName").val();
            let categorySelect = $("#categorySelect").val();
            let categoryInput = $("#categoryInput").val();

            let category = categoryInput ? categoryInput : categorySelect;

            let data = {
                topic_id: topicId,
                name: topicName,
                categories: category,
            };

            $.ajaxSetup({
                headers: {
                    "X-CSRF-Token": $("meta[name=csrf-token]").attr("content")
                },
            });

            $.ajax({
                type: "PUT",
                url: url,
                data: data,
                success: async function(data) {
                    if (data.status === "success") {
                        $("#detailCategory").modal("hide");
                        $("#detailCategory").on("hidden.bs.modal", function() {
                            cleanCode();
                        });

                        await updateCategoryList(); // Update the category list after success
                        dataTable.ajax.reload(null, false);
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: data.message,
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr, status, error);
                },
            });
        });

        $("#detailCategory").on("show.bs.modal", function(e) {
            $('#categoryInput').val(''); // Clear the New Category field
            updateCategoryList(); // Always update category list when modal is shown
        });

        function createItemSelectCategory(categories, category) {
            let categorySelect = document.getElementById("categorySelect");
            categories.map((item) => {
                categorySelect.insertAdjacentHTML("beforeend",
                    `<option value="${item.categories}">${item.categories}</option>`);
            });
            $("#categorySelect").val(category);
        }

        async function getDetailTopic(id) {
            let topic = null;
            const response = await fetch(`/topics/detail?id=${id}`, {
                method: "GET",
                headers: {
                    "X-CSRF-Token": $("meta[name=csrf-token]").attr("content"),
                },
            });
            let res = await response.json();
            if (res.status === "success") {
                topic = res.data;
            }
            return topic;
        }

        async function showDetailCategory(id) {
            let topic = await getDetailTopic(id);
            if (topic) {
                await $("#topicName").val(topic.name);
                $("#topicId").val(id);
                createItemSelectCategory(categories, topic.categories);
                $("#detailCategory").modal("show");
            }
        }

        async function showSortTopic(topicId, sort) {
            $("#topicSort").val(sort);
            $("#topicId").val(topicId);
            $("#modalTopicSort").modal("show");
        }

        function getNewCategory() {
            getCategory()
                .then((data) => {
                    categories = data;
                })
                .catch((err) => {});
        }

        function signCategory(topicId, sign, name, categories) {
            $(".topic-id-sign").val(topicId);
            $(".name-topic-sign").val(name);
            $(".category-topic-sign").val(categories);
            if (sign == 1) {
                $("#modalTopicSign").modal("show");
            } else {
                $("#modalTopicUnSign").modal("show");
            }
        }

        function updateImage(topicId, type = "icon") {
            $(".topic-id").val(topicId);
            if (type == "icon") {
                $(".title-modal-icon").text("Changing the icon in the topic");
                $(".type-upload").val("icon");
            } else {
                $(".type-upload").val("cover");
                $(".title-modal-icon").text("Changing the cover in the topic");
            }
            $("#modalChangeIcon").modal("show");
        }

        $(document).ready(function() {
            $(".btn-limit-topic").click(function() {
                $(".current-limit-topic").val(currentLimitTopic);
                $("#modalTopicLimit").modal("show");
            });

            getCurrentLimitTopic();

            getCategory()
                .then((data) => {
                    categories = data;
                })
                .catch((err) => {});

            dataTable = $("#tableTopics").DataTable({
                searching: false,
                stateSave: true,
                language: {
                    processing: "Loading...",
                    emptyTable: "No Data Topics",
                },
                serverSide: true,
                ajax: {
                    url: "/topics/data",
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
                    console.log(xhr);
                    console.log(error);
                    console.log(thrown);
                },
                columns: [{
                        data: "topic_id",
                        className: "menufilter textfilter",
                        render: function(data, type, row) {
                            return data;
                        },
                    },
                    {
                        data: "name",
                        className: "menufilter textfilter",
                        render: function(data, type, row) {
                            return `
                                    <div class="btn-detail"  data-item="${row}">${data}</div>
                                    `;
                        },
                    },
                    {
                        data: "icon_path",
                        orderable: false,
                        render: function(data, type, row) {
                            let icon = row.icon_path;
                            let img = "";
                            if (icon != "" && icon != " " && icon != null) {
                                img = '<img src="' + icon + '" width="30" height="20" />';
                            } else {
                                img = "No Icon";
                            }
                            return `<button style="background: transparent; outline: none; border: none" onclick='updateImage(${row.topic_id}, "icon")'>${img}</button>`;
                        },
                        defaultContent: "No Icon",
                    },
                    {
                        data: "cover_path",
                        orderable: false,
                        render: function(data, type, row) {
                            let icon = row.cover_path;
                            let img = "";
                            if (icon != "" && icon != " " && icon != null) {
                                img = '<img src="' + icon + '" width="30" height="20" />';
                            } else {
                                img = "No Icon";
                            }
                            return `<button style="background: transparent; outline: none; border: none" onclick='updateImage(${row.topic_id}, "cover")'>${img}</button>`;
                        },
                        defaultContent: "No Icon",
                    },
                    {
                        data: "categories",
                        className: "menufilter textfilter",
                        render: function(data, type, row) {
                            let value = "";
                            value +=
                                `<button style="border: none; background: transparent; width: 100%; height: 100%" onclick='showDetailCategory(${row.topic_id})' >`;
                            value += "<p>" + data + "</p>";

                            value += "</button>";
                            return value;
                        },
                    },
                    {
                        data: "created_at",
                        className: "menufilter textfilter",
                    },
                    {
                        data: "sort",
                        className: "menufilter textfilter",
                        render: function(data, type, row) {
                            let value = "";
                            value +=
                                `<button style="border: none; background: transparent" onclick='showSortTopic(${row.topic_id}, ${row.sort})' >`;
                            value += "<p>" + data + "</p>";

                            value += "</button>";
                            return value;
                        },
                    },
                    {
                        data: "followers",
                        render: function(data, type, row) {
                            return (
                                " <a href='/follow-topics?topic_id=" +
                                row.topic_id +
                                "'> <button type='button' class='btn btn-primary'>#Followers</button> </a>"
                            );
                        },
                    },
                    {
                        data: "total_user_topics",
                        render: function(data, type, row) {
                            return data;
                        },
                    },
                    {
                        data: "sign",
                        render: function(data, type, row) {
                            let total = 0;
                            if (row.posts.length >= 1) {
                                total = row.posts.length;
                            }
                            return total;
                        },
                    },
                    {
                        data: "sign",
                        render: function(data, type, row) {
                            let topicId = row.topic_id;
                            let name = row.name;
                            let categories = row.categories;
                            if (row.sign) {
                                return `<button class="btn btn-danger btn-delete" onclick='signCategory(${topicId}, 0, "${name}", "${categories}")'>Remove from OB</button>`;
                            } else {
                                return `<button class="btn btn-primary" onclick='signCategory(${topicId}, 1, "${name}", "${categories}")'>Add to OB</button>`;
                            }
                        },
                    },
                    {
                        data: "topic_id",
                        render: function(data, type, row) {
                            let content = '';
                            let topicId = row.topic_id;

                            let total = 0;
                            if (row.posts.length >= 1) {
                                total = row.posts.length;
                            }
                            if (total == 0) {
                                content = `
                                    <button class="btn btn-danger btn-delete-topic" onclick="deleteTopic(${row.topic_id})">Delete</button>
                                    `;

                            }

                            return content;
                        },
                    }
                ],
            });

            $("#search").on("submit", function(e) {
                dataTable.draw();
                e.preventDefault();
            });

            $("#formTopicSort").submit(function(e) {
                e.preventDefault();
                let form = $(this);
                let url = form.attr("action");
                let topicId = $("#topicId").val();
                let topicSort = $("#topicSort").val();
                let data = {
                    topic_id: topicId,
                    sort: topicSort,
                };

                $.ajaxSetup({
                    headers: {
                        "X-CSRF-Token": $("meta[name=csrf-token]").attr("content")
                    },
                });
                $.ajax({
                    type: "PUT",
                    url: url,
                    data: data,
                    success: function(data) {
                        if (data.status === "success") {
                            $("#modalTopicSort").modal("hide");
                            $("#modalTopicSort").on("hidden.bs.modal", function() {
                                cleanCode();
                            });

                            getNewCategory();
                            dataTable.ajax.reload(null, false);
                            return Swal.fire({
                                icon: "success",
                                title: "Success",
                                text: "Topic Updated",
                            });
                        } else {
                            return Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: data.message,
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        return Swal.fire({
                            icon: "error",
                            title: xhr.statusText,
                            text: xhr.responseJSON.message,
                        });
                    },
                });
            });

            $("#modal-category").submit(function(e) {
                e.preventDefault();
                let form = $(this);
                let url = form.attr("action");
                let topicId = $("#topicId").val();
                let topicName = $("#topicName").val();
                let categorySelect = $("#categorySelect").val();
                let categoryInput = $("#categoryInput").val();

                let category = "";
                if (categorySelect) {
                    category = categorySelect;
                }

                if (categoryInput) {
                    category = categoryInput;
                }

                let data = {
                    topic_id: topicId,
                    name: topicName,
                    categories: category,
                };

                $.ajaxSetup({
                    headers: {
                        "X-CSRF-Token": $("meta[name=csrf-token]").attr("content")
                    },
                });
                console.log(url);
                $.ajax({
                    type: "PUT",
                    url: url,
                    data: data,
                    success: function(data) {
                        console.log(data);
                        if (data.status === "success") {
                            $("#detailCategory").modal("hide");
                            $("#detailCategory").on("hidden.bs.modal", function() {
                                cleanCode();
                            });

                            getNewCategory();
                            dataTable.ajax.reload(null, false);
                        } else {
                            return Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: data.message,
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr);
                        console.log('status', status);
                        console.log('errrors', error);
                        return Swal.fire({
                            icon: "error",
                            title: 'Error',
                            text: 'Oops...',
                        });
                    },
                });
            });

            $("#formTopicLimit").submit(function(e) {
                e.preventDefault();
                const form = $(this);
                const url = form.attr("action");
                let limit = $("#limitTopic").val();
                let data = {
                    limit: limit,
                };

                $.ajaxSetup({
                    headers: {
                        "X-CSRF-Token": $("meta[name=csrf-token]").attr("content")
                    },
                });
                $.ajax({
                    type: "POST",
                    url: url,
                    data: data,
                    success: function(data) {
                        if (data.status === "success") {
                            $("#modalTopicLimit").modal("hide");
                            $("#modalTopicLimit").on("hidden.bs.modal", function() {
                                cleanCode();
                            });
                            getCurrentLimitTopic();
                            return Swal.fire({
                                icon: "success",
                                title: "Success",
                                text: "Limit Topic Updated",
                            });
                        } else {
                            return Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: data.message,
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        return Swal.fire({
                            icon: "error",
                            title: xhr.statusText,
                            text: xhr.responseJSON.message,
                        });
                    },
                });
            });
        });

        function showTopic(topicId) {
            let formData = new FormData();
            formData.append("topic_id", topicId);

            $.ajaxSetup({
                headers: {
                    "X-CSRF-Token": $("meta[name=csrf-token]").attr("content")
                },
            });
            $.ajax({
                type: "POST",
                dataType: "JSON",
                data: formData,
                contentType: false,
                processData: false,
                url: "/show/topics",
                success: function(data) {
                    if (data.success) {
                        dataTable.ajax.reload(null, false);
                    } else {
                        dataTable.ajax.reload(null, false);
                        return Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: data.message,
                        });
                    }
                },
                error: function(data) {
                    dataTable.ajax.reload(null, false);
                    return Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: data.message,
                    });
                },
            });
        }

        $(".btn-change-category").click(function() {
            let oldCategory = $("#oldCategory").val();
            let newCategory = $("#newCategory").val();
            if (oldCategory) {
                confirmAction(
                    "Are you sure?", {
                        old_category: oldCategory,
                        new_category: newCategory,
                    },
                    "/topics/category",
                    "Category changed successfully",
                    "Category changed failed",
                    function(data) {
                        Swal.fire({
                            icon: "success",
                            title: "Success",
                            text: "Category changed successfully",
                        });

                        dataTable.ajax.reload(null, false);
                        $("#modalChangeCategory").modal("hide");
                    },
                    "PUT"
                );
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Old Category is required",
                });
            }
        });

        $(".btn-delete-category").click(function() {
            let oldCategory = $("#oldCategory").val();
            if (oldCategory) {
                confirmAction(
                    "Are you sure?", {
                        old_category: oldCategory,
                    },
                    "/topics/category",
                    "Category deleted successfully",
                    "Category deleted failed",
                    function(data) {
                        Swal.fire({
                            icon: "success",
                            title: "Success",
                            text: "Category deleted successfully",
                        });
                        dataTable.ajax.reload(null, false);
                        $("#modalChangeCategory").modal("hide");
                        console.log(data);
                    },
                    "DELETE"
                );
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Old Category is required",
                });
            }
        });

        $("#formTopicSign").on("submit", function(e) {
            e.preventDefault();
            confirmAction(
                "Are you sure?", {
                    topic_id: $(".topic-id-sign").val(),
                    sign: 1,
                },
                "/topics/sign",
                "Topic signed successfully",
                "Topic signed failed",
                function(data) {
                    console.log(data);
                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        text: "Topic signed successfully",
                    });
                    dataTable.draw();
                    $("#modalTopicSign").modal("hide");
                }
            );
        });

        $("#formUnSignTopic").on("submit", function(e) {
            e.preventDefault();
            confirmAction(
                "Are you sure?", {
                    topic_id: $(".topic-id-sign").val(),
                    sign: 0,
                },
                "/topics/un-sign",
                "Topic unsigned successfully",
                "Topic unsigned failed",
                function(data) {
                    console.log(data);
                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        text: "Topic unsigned successfully",
                    });
                    dataTable.draw();
                    $("#modalTopicUnSign").modal("hide");
                }
            );
        });
    </script>
@endpush
