@extends('layouts.app')

@section('content')
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">

                <h2><b>Post by Blocks</b></h2>

                <div id="alert-container" class="alert alert-danger alert-dismissible fade show mb-3" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <ul id="alert-message"></ul>
                </div>

                <div class="widget-content widget-content-area br-6">
                    <div class="row">
                        <div class="col-4">
                            <form class="form-inline" method="GET" id="searchTopic">
                                <div class="form-group">
                                    <input type="text" name="topic" id="topic" class="form-control"
                                        placeholder="Search by Topic">
                                    &nbsp;&nbsp;
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </form>

                        </div>
                        <div class="col-4">
                            <form class="form-inline" method="POST" id="searchMessage">
                                <div class="form-group">
                                    <input type="text" id="message" class="form-control"
                                        placeholder="Search by Username">
                                    &nbsp;&nbsp;
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive mb-4 mt-4">
                        <table id="tablePostBlock" class="table table-hover" style="width:100%">
                            <caption>List Post</caption>
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>username</th>
                                    <th>message</th>
                                    <th>Comments</th>
                                    <th>Image</th>
                                    <th>Poll</th>
                                    <th>Upvote</th>
                                    <th>Downvote</th>
                                    <th>Total Block</th>
                                    <th>Status</th>
                                    <th>Post Date</th>
                                    <th>Topics</th>
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

    <div class="modal fade" id="detailModal" tabindex="0" aria-labelledby="detailModalLabel">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="detailCommentModal" tabindex="0" aria-labelledby="detailModalLabel">
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
        const showAlert = (title, message, type) => {
            const alertContainer = document.getElementById('alert-container');
            const alertMessage = document.getElementById('alert-message');

            alertContainer.classList.remove('alert-danger', 'alert-success', 'alert-warning');
            alertContainer.classList.add(`alert-${type}`);
            alertMessage.innerHTML = `<li>${title}: ${message}</li>`;

            alertContainer.style.display = 'block';
        };

        let dataTablePost;

        let token = $("meta[name=csrf-token]").attr("content");

        const getUsernameByAnonymousId = async (userId) => {
            let body = {
                user_id: userId,
            };
            try {
                const response = await fetch("/user-name-by-anonymous-id", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-Token": token,
                    },
                    body: JSON.stringify(body),
                });
                let res = await response.json();
                if (res.status === "success") {
                    return res.data.username;
                } else {
                    return "-";
                }
            } catch (err) {
                return "err";
            }
        };

        const getFeeds = async (feedGroup, user_id) => {
            let body = {
                feed_group: feedGroup,
                user_id: user_id,
            };
            try {
                const response = await fetch("/post-blocks/data", {
                    method: "POST",
                    headers: {
                        "X-CSRF-Token": token,
                    },
                    body: JSON.stringify(body),
                });
                let res = await response.json();
                if (res.status === "success") {
                    return res.data;
                } else {
                    Swal.fire("Error", res.message).then(() => {
                        location.reload();
                    });
                }
            } catch (err) {
                Swal.fire("Error", err).then(() => {
                    location.reload();
                });
            }
        };

        const handleType = (type) => {
            let message = "";
            let url = "";
            if (type === "upvote") {
                message = "upvote";
                url = "{{ route('post.upvote') }}";
            } else {
                message = "downvote";
                url = "{{ route('post.downvote') }}";
            }
            return {
                message,
                url
            };
        };

        const createInput = async (message) => {
            const {
                value
            } = await Swal.fire({
                title: `Input total ${message}`,
                input: "number",
                inputLabel: "",
                inputPlaceholder: `Enter number ${message}`,
                showCancelButton: true,
            });
            return value;
        };

        const reactionPost = async (activityId, type) => {
            let {
                message,
                url
            } = handleType(type);
            let value = await createInput(message);

            if (value && value >= 1) {
                try {
                    Swal.showLoading();

                    // Get current page number
                    const currentPage = dataTablePost.page();

                    const body = {
                        activity_id: activityId,
                        total: value,
                    };

                    const response = await fetch(url, {
                        method: "POST",
                        headers: {
                            "X-CSRF-Token": token,
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify(body),
                    });

                    let res = await response.json();
                    if (res.status === "success") {
                        // Redraw the table and go back to the same page
                        dataTablePost.draw(false).page(currentPage).draw(false);
                    } else {
                        Swal.fire("Error", `Error ${message}`, "error").then(() => {});
                    }
                } catch (error) {
                    Swal.fire("Error", `Error ${message}`, "error").then(() => {});
                } finally {
                    Swal.hideLoading();
                }
            } else {
                Swal.fire(`Value must be greater than or equal to one`);
            }
        };


        function tableCreate() {
            const exampleArray = [{
                    header: "ID",
                    values: [1, 2],
                },
                {
                    header: "First Name",
                    values: ["John", "Jayne"],
                },
                {
                    header: "Last Name",
                    values: ["Doe", "Doe"],
                },
            ];

            const header = $("#tableReaction thead tr");
            const body = $("#tableReaction tbody");

            exampleArray.forEach((column) => {
                header.append($(`<th>${column.header}</th>`));
            });

            // Compute the number of rows in the array
            const nRows = exampleArray[0].values.length;

            for (let i = 0; i < nRows; i++) {
                // row contains all cells in a row
                let row = $("<tr/>");
                // Loop over the columns
                exampleArray.forEach((column) => {
                    // For each column, we add the i-th value, since we're building the i-th row
                    row.append(`<td>${column.values[i]}</td>`);
                });
                // Add the row to the table body
                body.append(row);
            }
        }

        const detail = (data) => {
            console.log(data);
            tableCreate();
            getFeeds();
        };

        const generateCommentObject = (id, text, avatar, username, isAnonymous, emojiCode) => ({
            id,
            text,
            avatar,
            username,
            isAnonymous,
            emojiCode,
        });
        const createImageElement = (avatar, isAnonymous, emojiCode) => {
            const element = isAnonymous ? document.createElement("span") : document.createElement("img");
            if (isAnonymous) {
                element.innerText = emojiCode;
            } else {
                element.classList.add("border", "rounded-circle", "me-2");
                element.setAttribute("src", avatar);
                element.style.height = "40px";
            }
            return element;
        };

        const createProfileLink = (username) => {
            const link = document.createElement("a");
            link.classList.add("text-dark", "mb-0");
            const strong = document.createElement("strong");
            strong.innerText = username;
            link.appendChild(strong);
            return link;
        };

        const createCommentLink = (text) => {
            const link = document.createElement("a");
            link.classList.add("text-muted", "d-block");
            const strong = document.createElement("strong");
            strong.innerText = text;
            link.appendChild(strong);
            return link;
        };

        const createContentElement = (text, username) => {
            const container = document.createElement("div");
            container.classList.add("ml-3", "w-75");

            const content = document.createElement("div");
            content.classList.add("bg-light", "rounded-3", "px-3", "py-1");

            const profile = createProfileLink(username);
            content.appendChild(profile);

            const commentLink = createCommentLink(text);
            content.appendChild(commentLink);

            container.appendChild(content);
            return container;
        };

        const deleteComment = async (commentId) => {
            Swal.fire({
                title: "Are you sure?",
                text: "",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        const response = await fetch(`/post/comment/${commentId}`, {
                            method: "DELETE",
                            headers: {
                                "X-CSRF-Token": token,
                            },
                        });
                        let res = await response.json();
                        console.log(res);
                        if (res.status === "success") {
                            Swal.fire("Success", "Successfully deleted the comment", "success").then(
                                () => {
                                    location.reload();
                                });
                        } else {
                            Swal.fire("Error", "An error occurred while deleting the comment").then(
                                () => {
                                    location.reload();
                                });
                        }
                    } catch (err) {
                        console.log(err);
                        Swal.fire("Error", "An error occurred while deleting the comment").then(() => {
                            location.reload();
                        });
                    }
                }
            });
        };

        const createDeleteButton = (commentId) => {
            const button = document.createElement("button");
            button.classList.add("btn", "btn-danger");
            button.innerText = "X";
            button.addEventListener("click", () => {
                deleteComment(commentId);
            });
            return button;
        };

        const createComment = (comment) => {
            const {
                id,
                text,
                avatar,
                username,
                isAnonymous,
                emojiCode
            } = comment;

            const container = document.createElement("div");
            container.classList.add("d-flex", "mb-3");

            const image = createImageElement(avatar, isAnonymous, emojiCode);
            container.append(image);

            const content = createContentElement(text, username);
            container.append(content);

            const btnDelete = createDeleteButton(id);
            container.append(btnDelete);

            return container;
        };

        const detailComment = async (post) => {
            const {
                latest_reactions
            } = post;
            $("#detailCommentModal").modal("show");
            const container = document.getElementById("cardBodyComment");

            const createCommentLevel = (item) => {
                const username = item.data.is_anonymous ? item.user_id : item.user.data.username;
                const commentItem = generateCommentObject(
                    item.id,
                    item.data.text,
                    item.user.data.profile_pic_url,
                    username,
                    item.data.is_anonymous,
                    item.data.is_anonymous ? item.data.anon_user_info_emoji_code : ""
                );
                return commentItem;
            };

            latest_reactions.comment.forEach((item) => {
                const comment = createComment(createCommentLevel(item));
                container.append(comment);

                if (item.children_counts.comment >= 1) {
                    item.latest_children.comment.forEach((child) => {
                        const childComment = createComment(createCommentLevel(child));
                        childComment.style.marginLeft = "16px";
                        container.append(childComment);

                        if (child.children_counts.comment >= 1) {
                            child.latest_children.comment.forEach((grandchild) => {
                                const grandchildComment = createComment(createCommentLevel(
                                    grandchild));
                                grandchildComment.style.marginLeft = "36px";
                                container.append(grandchildComment);
                            });
                        }
                    });
                }

                const separator = document.createElement("div");
                separator.style.margin = "20px 0";
                separator.style.border = "none";
                separator.style.borderTop = "1px solid #ccc";
                container.append(separator);
            });
        };

        const bannedUserByPostId = (postId) => {
            Swal.fire({
                title: "Are you sure?",
                text: "",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, do it!",
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        const body = {
                            activity_id: postId,
                        };
                        const response = await fetch(`/post/banned-user`, {
                            method: "POST",
                            headers: {
                                "X-CSRF-Token": token,
                                "Content-Type": "application/json",
                            },
                            body: JSON.stringify(body),
                        });
                        let res = await response.json();
                        if (res.status === "success") {
                            Swal.fire("Success", "Success banned user", "success").then(() => {
                                dataTablePost.draw();
                            });
                        } else {
                            Swal.fire("Error", res.message).then(() => {});
                        }
                    } catch (err) {
                        Swal.fire("Error", err).then(() => {});
                    }
                }
            });
        };

        function createButton(type, text, onclick) {
            return `<button type="button" class="btn btn-${type} btn-sm my-2" onclick="${onclick}">${text}</button>`;
        }

        function createLinkButton(url, text) {
            return `<a href="${url}"><button type="button" class="btn btn-primary btn-sm">${text}</button></a>`;
        }

        $(document).ready(function() {
            $("#detailCommentModal").on("hide.bs.modal", function(e) {
                let container = document.getElementById("cardBodyComment");
                while (container.firstChild) {
                    container.removeChild(container.lastChild);
                }
            });

            dataTablePost = $("#tablePostBlock").DataTable({
                searching: false,
                stateSave: true,
                serverSide: true,
                processing: true,
                lengthMenu: [
                    [10, 25, 100],
                    [10, 25, 100]
                ],
                pageLength: 100,
                language: {
                    processing: "Loading...",
                    emptyTable: "No Data Post",
                    info: "",
                    infoEmpty: "",
                    infoFiltered: "",
                    zeroRecords: "No matching records found",
                    search: "Cari:",
                },
                ajax: {
                    url: "{{ route('post-block.data') }}",
                    type: "get",
                    headers: {
                        "X-CSRF-Token": token
                    },
                    data: function(d) {
                        d.message = $("#message").val();
                        d.topic = $('#topic').val();
                    },
                },

                stateSaveCallback: function(settings, data) {
                    localStorage.setItem('DataTables_' + settings.sInstance, JSON.stringify(data));
                },
                stateLoadCallback: function(settings) {
                    return JSON.parse(localStorage.getItem('DataTables_' + settings.sInstance));
                },
                initComplete: function(settings, json) {
                    console.log(json);
                },
                columns: [
                    // 1. ID
                    {
                        data: "id",
                        orderable: false,
                        className: "menufilter textfilter",
                    },
                    // 2. username
                    {
                        data: "verb",
                        orderable: false,
                        className: "menufilter textfilter",
                        render: function(data, type, row) {
                            if (row.anonimity) {
                                return row.anon_user_info_color_name + " " + row
                                    .anon_user_info_emoji_name;
                            } else {
                                if (row.actor.error) {
                                    return row.actor.error;
                                }
                                return row.actor?.data?.username ?? "User not found";
                            }
                        },
                    },
                    // 3. mesasge
                    {
                        data: "message",
                        orderable: false,
                        className: "message",
                        render: function(data, type, row) {
                            return `
                <div class="btn-detail"  data-item="${row}">${data}</div>
                `;
                        },
                    },
                    // 4. comments
                    {
                        data: "message",
                        orderable: false,
                        className: "menufilter textfilter",
                        render: function(data, type, row) {
                            // comments tab;
                            let value = "";
                            let {
                                latest_reactions
                            } = row;
                            if (latest_reactions) {
                                let {
                                    comment
                                } = latest_reactions;
                                if (comment) {
                                    let postInJson = JSON.stringify(row);
                                    value +=
                                        `<button style="border: none; background: transparent" onclick='detailComment(${postInJson})' >`;
                                    comment.forEach((element) => {
                                        let username = element.user?.data?.username ||
                                            "username not found";
                                        let item = "<p>" + username + ": " + element.data
                                            .text + "</p>";
                                        value = value + item;
                                    });

                                    value += "</button>";
                                }
                            }
                            return value;
                        },
                    },
                    // 5. image
                    {
                        data: "images_url", // Ubah sesuai dengan data yang benar dari server Anda
                        orderable: false,
                        className: "text-center",
                        render: function(data, type, row) {
                            if (data && data.length > 0) {
                                // Jika ada beberapa gambar, render semuanya sebagai thumbnail yang bisa diklik
                                let imagesHtml = '';
                                data.forEach(function(url) {
                                    imagesHtml += `
                                        <a href="#" class="image-preview" data-image-url="${url}">
                                            <img src="${url}" alt="Image" class="rounded" width="100" height="100" style="margin-right: 5px;">
                                        </a>`;
                                });
                                return imagesHtml;
                            } else {
                                return 'No Image';
                            }
                        },
                    },
                    // 6. Poll Options
                    {
                        data: "verb",
                        orderable: false,
                        className: "menufilter textfilter",
                        render: function(data, type, row) {
                            // poll options tab;
                            let value = "";
                            if (data === "poll") {
                                value = value + "<ul>";
                                row.polling_options.forEach(renderProductList);

                                function renderProductList(element, index, arr) {
                                    let item = "<li>" + element + "</li>";
                                    value = value + item;
                                }

                                value = value + "</ul>";
                            }
                            return value;
                        },
                    },
                    // 7. Upvote
                    {
                        data: "count_upvotes",
                        orderable: true,
                        className: "menufilter textfilter",
                        render: function(data, type, row) {
                            let upvote = data || 0;
                            return `<button style="border: none; background: transparent" onclick='reactionPost("${row.id}", "upvote")'> ${upvote} </button>`;
                        },
                    },
                    {
                        data: "count_downvotes",
                        orderable: true,
                        className: "menufilter textfilter",
                        render: function(data, type, row) {
                            let downvote = data || 0;
                            return `<button style="border: none; background: transparent" onclick='reactionPost("${row.id}", "downvote")'> ${downvote} </button>`;
                        },
                    },

                    // 9. total block
                    {
                        data: "total_block",
                        orderable: true,
                        className: "menufilter textfilter",
                        render: function(data, type, row) {
                            // Render total_block, default to 0 if null
                            return data || 0;
                        },
                    },
                    // 10. Status
                    {
                        data: "post_type",
                        orderable: false,
                        className: "menufilter textfilter",
                        render: function(data, type, row) {
                            //status
                            let isHide = false;
                            if (row.is_hide) {
                                isHide = true;
                            }
                            let html = "";
                            if (isHide) {
                                html = `<p class="info">Hidden</p>`;
                            } else {
                                html = `<p>Show</p>`;
                            }

                            return html;
                            // status tab
                        },
                    },
                    // 11. post date
                    {
                        data: "time",
                        orderable: true,
                        className: "menufilter textfilter",
                        render: function(data, type, row) {
                            // time from post date
                            const tanggal = new Date(row.time);
                            const namaBulan = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul",
                                "Aug", "Sep", "Oct", "Nov", "Dec"
                            ];

                            const tanggalFormatted =
                                tanggal.getDate() +
                                " " +
                                namaBulan[tanggal.getMonth()] +
                                " " +
                                tanggal.getFullYear() +
                                " " +
                                ("0" + tanggal.getHours()).slice(-2) +
                                ":" +
                                ("0" + tanggal.getMinutes()).slice(-2) +
                                ":" +
                                ("0" + tanggal.getSeconds()).slice(-2);

                            return tanggalFormatted;
                        },
                    },
                    // 12. topics
                    {
                        data: "topics",
                        name: "topics",
                        orderable: false,
                        className: "menufilter",
                        render: function(data, type, row) {
                            if (data.length >= 1) {
                                let topics = "";
                                data.map((item) => {
                                    topics += `#${item} <br>`;
                                });
                                return topics;
                            }
                            return data;
                        },
                    },
                    // 13. action
                    {
                        data: "post_type",
                        orderable: false,
                        render: function(data, type, row) {
                            // action
                            let userId = row.actor.id;
                            let clickBlockUser = "blockUser('" + userId + "')";
                            let clickUnBlockUser = "unBlockUser('" + userId + "')";

                            const btnUnBlockUser = createButton("primary", "Remove downrank",
                                clickUnBlockUser);
                            const btnBlockUser = createButton("danger", "Downrank user",
                                clickBlockUser);
                            let isHide = false;
                            if (row.is_hide) {
                                isHide = true;
                            }
                            let btnBlok = "";
                            if (row.hasOwnProperty("user") && row.user != null) {
                                let user = row.user;
                                if (user.blocked_by_admin) {
                                    btnBlok = btnUnBlockUser;
                                } else {
                                    btnBlok = btnBlockUser;
                                }
                            }
                            let html = "";
                            if (isHide) {
                                let clickShow = "hideOrShowPost(false,'" + row.id + "')";
                                html += createButton("primary", "Show Post", clickShow);
                                let clickBanned = "bannedUserByPostId('" + row.id + "')";
                                html += createButton("danger", "Ban User", clickBanned);
                                html += btnBlok;
                            } else {
                                let clickHide = "hideOrShowPost(true,'" + row.id + "')";
                                html += createButton("danger", "Hide Post", clickHide);
                                let clickBanned = "bannedUserByPostId('" + row.id + "')";
                                html += createButton("danger", "Ban User", clickBanned);
                                html += btnBlok;
                            }
                            return html;
                        },
                    },
                ],
            });

            $('#searchTopic').on('submit', function(e) {
                e.preventDefault();
                dataTablePost.draw();
            })

            $("#searchMessage").on("submit", function(e) {
                e.preventDefault();
                dataTablePost.draw();
                e.preventDefault();
            });

            $("#search").on("submit", function(e) {
                dataTablePost.draw();
                e.preventDefault();
            });

            $('#tablePostBlock').on('click', '.image-preview', function(e) {
                e.preventDefault();
                const imageUrl = $(this).data('image-url');
                $('#previewImage').attr('src', imageUrl);
                $('#imagePreviewModal').modal('show');
            });

            /// end
        });

        function confirmAction(title, body, url, successMessage, errorMessage, successCallback) {
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

                    fetch(url, {
                            method: "POST",
                            headers: {
                                "X-CSRF-Token": token,
                                "Content-Type": "application/json",
                            },
                            body: JSON.stringify(body),
                        })
                        .then((response) => response.json())
                        .then((data) => {
                            Swal.close();
                            successCallback(data);
                        })
                        .catch((error) => {
                            Swal.close();
                            console.log(error);
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                text: error.message || errorMessage,
                            });
                        });
                }
            });
        }

        function bannedUser(status, userId) {
            confirmAction(
                "Are you sure?", {
                    user_id: userId,
                },
                `/users/banned/${userId}`,
                "Success",
                "Oops...",
                function(data) {
                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        text: data.message,
                    });
                    dataTablePost.draw();
                }
            );
        }

        function blockUser(userId) {
            confirmAction(
                "Are you sure?", {
                    user_id: userId,
                },
                `/users/admin-block-user`,
                "Success",
                "Error",
                function(data) {
                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        text: data.message,
                    });
                    dataTablePost.draw();
                }
            );
        }

        function unBlockUser(userId) {
            confirmAction(
                "Are you sure?", {
                    user_id: userId,
                },
                `/users/admin-unblock-user`,
                "Success",
                "Error",
                function(data) {
                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        text: data.message,
                    });
                    dataTablePost.draw();
                }
            );
        }

        const hideOrShowPost = (status, postId) => {
            let body = {
                is_hide: status,
            };
            console.log(body);
            confirmAction("Are you sure?", body, `/post/hide/${postId}`, "Success", "Oops...", function(data) {
                console.log(data);
                Swal.fire("Success", status ? "Success hide post" : "Success show post", "success").then(() => {
                    dataTablePost.draw();
                });
            });
        };
    </script>
@endpush
