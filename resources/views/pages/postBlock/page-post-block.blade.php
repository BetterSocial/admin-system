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

                    <div class="table mb-4 mt-4">
                        <table id="tablePostBlocks" class="table table-hover" style="width:100%">
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
                            <tbody>
                                @foreach ($posts as $item)
                                    <tr>
                                        <td>{{ $item->post_id }}</td>
                                        <td>{{ $item->username }}</td>
                                        <td>{{ $item->post_content }}</td>
                                        <td>
                                            @if (!empty($item->comments))
                                                <a href="javascript:void(0);" onclick="showComments('{{ $item->post_id }}')"
                                                    class="" style="color: inherit; text-decoration: none;">
                                                    <ul>
                                                        @foreach ($item->comments as $comment)
                                                            <li>{{ $comment->comment }}</li>
                                                        @endforeach
                                                    </ul>
                                                </a>
                                            @else
                                                <p>No comments</p>
                                            @endif
                                        </td>
                                        <td>image</td>
                                        <td>
                                            @php
                                                $polling = $item->polling;
                                            @endphp
                                            @if ($polling)
                                                <ul>
                                                    @foreach ($polling as $pollItem)
                                                        <li>{{ $pollItem->question }}</li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->statistic)
                                                {{ $item->statistic->upvote_count ?? 0 }}
                                            @else
                                                0
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->statistic)
                                                {{ $item->statistic->downvote_count ?? 0 }}
                                            @else
                                                0
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->statistic)
                                                {{ $item->statistic->block_count ?? 0 }}
                                            @else
                                                0
                                            @endif
                                        </td>
                                        <td>status</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>
                                            @if ($item->topics)
                                                <ul>
                                                    @foreach ($item->topics as $topic)
                                                        <li>{{ $topic->name }}</li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </td>
                                        {{-- Menampilkan Action seperti Block/Unblock, Hide/Show Post --}}
                                        <td>
                                            @if (isset($item->user) && isset($item->user->user_id))
                                                @php
                                                    $userId = $item->user->user_id;
                                                    $isHidden = $item->is_hide ?? false;
                                                    $isBlocked = $item->user->blocked_by_admin ?? false;
                                                @endphp

                                                {{-- Button for blocking/unblocking the user --}}
                                                @if ($isBlocked)
                                                    <button class="btn btn-primary btn-sm my-1"
                                                        onclick="unBlockUser('{{ $userId }}')">Remove
                                                        Downrank</button>
                                                @else
                                                    <button class="btn btn-danger btn-sm my-1"
                                                        onclick="blockUser('{{ $userId }}')">Downrank User</button>
                                                @endif

                                                {{-- Button for hiding/showing the post --}}
                                                @if ($isHidden)
                                                    <button class="btn btn-primary btn-sm my-1"
                                                        onclick="hideOrShowPost(false, '{{ $item->post_id }}')">Show
                                                        Post</button>
                                                @else
                                                    <button class="btn btn-danger btn-sm my-1"
                                                        onclick="hideOrShowPost(true, '{{ $item->post_id }}')">Hide
                                                        Post</button>
                                                @endif

                                                {{-- Button for banning the user --}}
                                                <button class="btn btn-danger btn-sm my-1"
                                                    onclick="bannedUserByPostId('{{ $item->post_id }}')">Ban User</button>
                                            @else
                                                <p class="text-muted">User not found</p>
                                            @endif
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
        let postBlockUrl = "{{ route('post-block') }}";
        const showAlert = (title, message, type) => {
            const alertContainer = document.getElementById('alert-container');
            const alertMessage = document.getElementById('alert-message');

            alertContainer.classList.remove('alert-danger', 'alert-success', 'alert-warning');
            alertContainer.classList.add(`alert-${type}`);
            alertMessage.innerHTML = `<li>${title}: ${message}</li>`;

            alertContainer.style.display = 'block';
        };

        // Fungsi untuk menampilkan komentar di modal
        const showComments = async (postId) => {
            // Kosongkan kontainer sebelum menampilkan komentar baru
            const container = document.getElementById("cardBodyComment");
            container.innerHTML = "";

            // Panggil API untuk mendapatkan komentar berdasarkan postId
            try {
                const response = await fetch(`/post/${postId}/comments`, {
                    method: "GET",
                    headers: {
                        "X-CSRF-Token": token,
                        "Content-Type": "application/json",
                    },
                });
                const data = await response.json();

                if (data.status === "success") {
                    const comments = data.comments;

                    // Loop melalui komentar dan tampilkan di dalam modal
                    comments.forEach((comment) => {
                        const commentElement = createComment({
                            id: comment.id,
                            text: comment.comment,
                            avatar: comment.is_anonymous ?
                                'https://path-to-anonymous-avatar.com/anon.png' : comment.user
                                .profile_pic_path,
                            username: comment.is_anonymous ? 'Anonymous' : comment.user.username,
                            isAnonymous: comment.is_anonymous,
                        });
                        container.append(commentElement);
                    });

                    // Tampilkan modal setelah komentar berhasil dimuat
                    $("#detailCommentModal").modal("show");
                } else {
                    Swal.fire("Error", "Failed to load comments", "error");
                }
            } catch (error) {
                Swal.fire("Error", "Failed to load comments", "error");
            }
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
                        const response = await fetch("{{ route('post.banned-user') }}", {
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

                                window.location.href = postBlockUrl;
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
            $('#tablePostBlocks').dataTable({})

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
                    }).then(() => {
                        // Redirect ke route setelah sukses
                        window.location.href = postBlockUrl;
                    });

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
                    }).then(() => {
                        // Redirect ke route setelah sukses
                        window.location.href = postBlockUrl;
                    });
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
                    }).then(() => {
                        window.location.href = postBlockUrl;
                    })

                }
            );
        }

        const hideOrShowPost = (status, postId) => {
            let body = {
                is_hide: status,
            };
            confirmAction("Are you sure?", body, `/post/hide/${postId}`, "Success", "Oops...", function(data) {

                Swal.fire("Success", status ? "Success hide post" : "Success show post", "success").then(() => {
                    // dataTablePost.draw();
                    window.location.href = postBlockUrl;
                });
            });
        };
    </script>
@endpush
