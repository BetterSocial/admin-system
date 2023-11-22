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
        "Content-Type": "application/json", // Set header untuk JSON
        "X-CSRF-Token": token,
      },
      body: JSON.stringify(body), // Mengubah objek menjadi JSON string
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
  let data = [];
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
    url = "/post/upvote";
  } else {
    message = "downvote";
    url = "/post/downvote";
  }
  return { message, url };
};

const createInput = async (message) => {
  const { value } = await Swal.fire({
    title: `Input total ${message}`,
    input: "number",
    inputLabel: "",
    inputPlaceholder: `Enter number ${message}`,
    showCancelButton: true,
  });
  return value;
};

const reactionPost = async (activityId, type) => {
  let { message, url } = handleType(type);
  let value = await createInput(message);
  if (value && value >= 1) {
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
          Swal.showLoading();
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
            Swal.fire("Success", `success ${message}`, "success").then(() => {
              dataTablePost.draw();
            });
          } else {
            Swal.fire("Error", `Error ${message}`, "error").then(() => {});
          }
        } catch (error) {
          Swal.fire("Error", `Error ${message}`, "error").then(() => {});
        } finally {
          Swal.hideLoading();
        }
      }
    });
  } else {
    Swal.fire(`Value must be greater than equal to one`);
  }
};

function tableCreate() {
  const exampleArray = [
    {
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
  $(".test-class").val("testing set");
  let { latest_reactions } = data;
  if (latest_reactions) {
    let { comment } = latest_reactions;
    if (comment) {
    }
  }
  //   $("#detailModal").modal("show");
  getFeeds;
};

const generateCommentObject = (
  id,
  text,
  avatar,
  username,
  isAnonymous,
  emojiCode
) => ({
  id,
  text,
  avatar,
  username,
  isAnonymous,
  emojiCode,
});
const createImageElement = (avatar, isAnonymous, emojiCode) => {
  const element = isAnonymous
    ? document.createElement("span")
    : document.createElement("img");
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
        if (res.status === "success") {
          Swal.fire(
            "Success",
            "Successfully deleted the comment",
            "success"
          ).then(() => {
            location.reload();
          });
        } else {
          Swal.fire(
            "Error",
            "An error occurred while deleting the comment"
          ).then(() => {
            location.reload();
          });
        }
      } catch (err) {
        console.log(err);
        Swal.fire("Error", "An error occurred while deleting the comment").then(
          () => {
            location.reload();
          }
        );
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
  const { id, text, avatar, username, isAnonymous, emojiCode } = comment;

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
  const { latest_reactions } = post;
  $("#detailCommentModal").modal("show");
  const container = document.getElementById("cardBodyComment");

  const createCommentLevel = (item) => {
    const username = item.data.is_anonymous
      ? item.user_id
      : item.user.data.username;
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
            const grandchildComment = createComment(
              createCommentLevel(grandchild)
            );
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
        console.log(res);
        if (res.status === "success") {
          Swal.fire("Success", "Success banned user", "success").then(() => {
            dataTablePost.draw();
          });
        } else {
          Swal.fire("Error", res.message).then(() => {});
        }
      } catch (err) {
        console.log(err);
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
    language: {
      processing: "Loading...",
      emptyTable: "No Data Post",
    },
    ajax: {
      url: "/post-blocks/data",
      type: "POST",
      headers: { "X-CSRF-Token": token },
      data: function(d) {
        d.total = $("#total").val();
        d.message = $("#message").val();
        console.log(d);
      },
    },
    // error: function(xhr, error, thrown) {
    //   console.log("xhr", xhr);
    //   console.log("error", error);
    //   console.log("thrown", thrown);
    // },
    columns: [
      {
        data: "id",
        orderable: false,
        className: "menufilter textfilter",
      },
      {
        data: "verb",
        orderable: false,
        className: "menufilter textfilter",
        render: function(data, type, row) {
          if (row.anonimity) {
            return (
              row.anon_user_info_color_name +
              " " +
              row.anon_user_info_emoji_name
            );
          } else {
            if (row.actor.error) {
              return row.actor.error;
            }
            return row.actor?.data?.username ?? "User not found";
          }
        },
      },
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
      {
        data: "message",
        orderable: false,
        className: "menufilter textfilter",
        render: function(data, type, row) {
          // comments tab;
          let value = "";
          let { latest_reactions } = row;
          if (latest_reactions) {
            let { comment } = latest_reactions;
            if (comment) {
              let postInJson = JSON.stringify(row);
              value += `<button style="border: none; background: transparent" onclick='detailComment(${postInJson})' >`;
              comment.forEach((element) => {
                let item =
                  "<p>" + element.user?.data.username ??
                  "username not found" + ": " + element.data.text + "</p>";
                value = value + item;
              });

              value += "</button>";
            }
          }
          return value;
        },
      },
      {
        data: "message",
        orderable: false,
        className: "menufilter textfilter",
        render: function(data, type, row) {
          let { images_url } = row;
          // image tab
          if (images_url.length > 1) {
            let value = `<div class="btn-detail" style="100px"  data-item="${row}">`;
            images_url.map((item) => {
              value += `<a href="${item}" target="_blank"><img src="${item}" alt="${data}" class="rounded h-10" width="128" height="128"></a>`;
            });
            value += "</div>";
            return value;
          } else if (images_url.length == 1) {
            return `
                    <div class="btn-detail" style="100px"  data-item="${row}"><a href="${images_url}" target="_blank"><img src="${images_url}" alt="${data}" class="rounded h-10" width="128" height="128"></a></div>
                    `;
          } else {
            return `
                <div class="btn-detail"  data-item="${row}">-</div>
                `;
          }
        },
      },
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
      {
        data: "id",
        orderable: true,
        className: "menufilter textfilter",
        render: function(data, type, row) {
          // upvote
          let { reaction_counts } = row;
          let upvote = reaction_counts.upvotes || 0;
          let activityId = row.id;
          let html = "";
          html = `<button style="border: none; background: transparent" onclick='reactionPost("${activityId}", "upvote")'> ${upvote} </button>`;
          return html;
        },
      },
      {
        data: "anonimity",
        orderable: true,
        className: "menufilter textfilter",
        render: function(data, type, row) {
          // downvote;
          let { reaction_counts } = row;
          let downvote = reaction_counts.downvotes || 0;
          let activityId = row.id;
          let html = "";
          html = `<button style="border: none; background: transparent" onclick='reactionPost("${activityId}", "downvote")'> ${downvote} </button>`;
          return html;
        },
      },
      {
        data: "post_type",
        orderable: true,
        className: "menufilter textfilter",
        render: function(data, type, row) {
          // total block
          return row.total_block;
        },
      },
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
      {
        data: "time",
        orderable: true,
        className: "menufilter textfilter",
        render: function(data, type, row) {
          // time from post date
          const tanggal = new Date(row.time);
          const namaBulan = [
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
      {
        data: "post_type",
        orderable: false,
        className: "menufilter textfilter",
        render: function(data, type, row) {
          const tanggal = new Date(row.time);
          const namaBulan = [
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
      {
        data: "post_type",
        orderable: false,
        render: function(data, type, row) {
          // action
          let userId = row.actor.id;
          let clickBlockUser = "blockUser('" + userId + "')";
          let clickUnBlockUser = "unBlockUser('" + userId + "')";

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

  $("#searchMessage").on("submit", function(e) {
    e.preventDefault();
    dataTablePost.draw();
    e.preventDefault();
  });

  $("#search").on("submit", function(e) {
    dataTablePost.draw();
    e.preventDefault();
  });
  /// end
});

function confirmAction(
  title,
  body,
  url,
  successMessage,
  errorMessage,
  successCallback
) {
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
    "Are you sure?",
    {
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
    "Are you sure?",
    {
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
    "Are you sure?",
    {
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
  confirmAction(
    "Are you sure?",
    body,
    `/post/hide/${postId}`,
    "Success",
    "Oops...",
    function(data) {
      console.log(data);
      Swal.fire(
        "Success",
        status ? "Success hide post" : "Success show post",
        "success"
      ).then(() => {
        dataTablePost.draw();
      });
    }
  );
};
