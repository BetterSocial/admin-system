let dataTablePost;
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
        "X-CSRF-Token": $("meta[name=csrf-token]").attr("content"),
      },
      body: JSON.stringify(body),
    });
    let res = await response.json();
    console.log(res.status);
    if (res.status === "success") {
      return res.data;
    } else {
      Swal.fire("Error", res.message).then(() => {
        location.reload();
      });
    }
  } catch (err) {
    console.log(err);
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
  console.log(value);
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
              "X-CSRF-Token": $("meta[name=csrf-token]").attr("content"),
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

const hideOrShowPost = async (id, isHide) => {
  try {
    const body = {
      is_hide: isHide,
    };
    console.log(body);
    const response = await fetch(`/post/hide/${id}`, {
      method: "POST",
      headers: {
        "X-CSRF-Token": $("meta[name=csrf-token]").attr("content"),
        "Content-Type": "application/json",
      },
      body: JSON.stringify(body),
    });
    let res = await response.json();
    return res;
  } catch (error) {
    console.log(error);
    Swal.fire("Error", "Error load data from getstream", "error").then(() => {
      location.reload();
    });
  }
};

const hidePost = (status, postId) => {
  Swal.fire({
    title: "Are you sure?",
    text: "",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, hide it!",
  }).then((result) => {
    if (result.isConfirmed) {
      hideOrShowPost(postId, status)
        .then((res) => {
          console.log(res);
          Swal.fire("Success", "Success hide post", "success").then(() => {
            location.reload();
          });
        })
        .catch((err) => {
          console.log(err);
        });
    }
  });
};

const showPost = (status, postId) => {
  Swal.fire({
    title: "Are you sure?",
    text: "",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, show it!",
  }).then((result) => {
    if (result.isConfirmed) {
      hideOrShowPost(postId, status)
        .then((res) => {
          console.log(res);
          Swal.fire("Success", "Success show post", "success").then(() => {
            location.reload();
          });
        })
        .catch((err) => {
          console.log(err);
        });
    }
  });
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

const generateCommentObject = (id, text, avatar, username) => {
  return {
    id,
    text,
    avatar,
    username,
  };
};

function makeImage(avatar) {
  const image = document.createElement("img");
  image.classList.add("border", "rounded-circle", "me-2");
  image.setAttribute("src", avatar);
  image.style.height = "40px";
  return image;
}

function makeProfile(username) {
  let container = document.createElement("a");
  container.classList.add("text-dark", "mb-0");
  let item = document.createElement("strong");
  item.innerText = username;
  container.append(item);
  return container;
}

function makeItemComment(text) {
  let container = document.createElement("a");
  container.classList.add("text-muted", "d-block");
  let item = document.createElement("strong");
  item.innerText = text;
  container.append(item);
  return container;
}

function makeContent(text, username) {
  let container = document.createElement("div");
  container.classList.add("ml-3", "w-75");
  let containerContent = document.createElement("div");
  containerContent.classList.add("bg-light", "rounded-3", "px-3", "py-1");
  let profile = makeProfile(username);
  containerContent.append(profile);
  let itemComment = makeItemComment(text);
  containerContent.append(itemComment);
  container.append(containerContent);
  return container;
}

function deleteComment(commentId) {
  console.log(commentId);
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
            "X-CSRF-Token": $("meta[name=csrf-token]").attr("content"),
            "Content-Type": "application/json",
          },
        });
        let res = await response.json();
        console.log(res);
        if (res.status === "success") {
          Swal.fire("Success", "Success delete comment", "success").then(() => {
            location.reload();
          });
        } else {
          Swal.fire("Error", res.message).then(() => {
            location.reload();
          });
        }
      } catch (err) {
        console.log(err);
        Swal.fire("Error", err).then(() => {
          location.reload();
        });
      }
    }
  });
}

function makeBtnDelete(commentId) {
  // `<button class="btn btn-info mt-2" onclick='detail(${item})'>Detail</button`
  let btn = document.createElement("button");
  btn.classList.add("btn", "btn-danger");
  btn.innerText = "X";
  btn.addEventListener("click", function () {
    deleteComment(commentId);
  });
  return btn;
}

function makeComment(comment) {
  let { id, text, avatar, username } = comment;
  const container = document.createElement("div");
  container.classList.add("d-flex", "mb-3");

  let image = makeImage(avatar);
  container.append(image);

  let content = makeContent(text, username);
  container.append(content);
  let btnDelete = makeBtnDelete(id);
  container.append(btnDelete);
  return container;
}

const detailComment = (post) => {
  console.log(post);
  let { latest_reactions } = post;

  $("#detailCommentModal").modal("show");
  let container = $("#cardBodyComment");
  latest_reactions.comment.map((item) => {
    let commentItem = generateCommentObject(
      item.id,
      item.data.text,
      item.user.data.profile_pic_url,
      item.user.data.username
    );
    let comment = makeComment(commentItem);
    container.append(comment);
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
            "X-CSRF-Token": $("meta[name=csrf-token]").attr("content"),
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

$(document).ready(function () {
  $("#detailCommentModal").on("hide.bs.modal", function (e) {
    let container = document.getElementById("cardBodyComment");
    while (container.firstChild) {
      container.removeChild(container.lastChild);
    }
  });

  dataTablePost = $("#tablePostBlock").DataTable({
    searching: false,
    stateSave: true,
    processing: true,
    language: {
      processing: "Loading...",
      emptyTable: "No Data Post",
    },
    serverSide: true,
    ajax: {
      url: "/post-blocks/data",
      type: "POST",
      headers: { "X-CSRF-Token": $("meta[name=csrf-token]").attr("content") },
      data: function (d) {
        d.total = $("#total").val();
      },
    },
    error: function (xhr, error, thrown) {
      console.log("xhr", xhr);
      console.log("error", error);
      console.log("thrown", thrown);
    },
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
        render: function (data, type, row) {
          // console.log(row);
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
        className: "menufilter textfilter",
        render: function (data, type, row) {
          let { images_url } = row;
          // message tab
          if (row.post_type === 1) {
            return `
                <div class="btn-detail"  data-item="${row}">${data}</div>
                `;
          } else if (row.post_type === 2) {
            return `
                <div class="btn-detail"  data-item="${row}">${data}</div>
                `;
          } else {
            return `
              <div class="btn-detail"  data-item="${row}">${data}</div>
              `;
          }
        },
      },
      {
        data: "message",
        orderable: false,
        className: "menufilter textfilter",
        render: function (data, type, row) {
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
        render: function (data, type, row) {
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
        render: function (data, type, row) {
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
        orderable: false,
        className: "menufilter textfilter",
        render: function (data, type, row) {
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
        orderable: false,
        className: "menufilter textfilter",
        render: function (data, type, row) {
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
        orderable: false,
        className: "menufilter textfilter",
      },
      {
        data: "post_type",
        orderable: false,
        className: "menufilter textfilter",
        render: function (data, type, row) {
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
        data: "post_type",
        orderable: false,
        render: function (data, type, row) {
          // action
          let isHide = false;
          if (row.is_hide) {
            isHide = true;
          }
          let html = "";
          if (isHide) {
            html =
              "<button type='button' data-deleted='false' onclick='showPost(false,\"" +
              row.id +
              "\")' class='btn btn-info btn-sm'>Show</button>" +
              "<br/>" +
              "<br/>" +
              "<button  type='button' data-deleted='false' onclick='bannedUserByPostId(\"" +
              row.id +
              "\")' class='btn btn-danger btn-sm'>Ban</button>" +
              " <br/>";
          } else {
            html =
              "<button data-deleted='true' type='button' onclick='hidePost(true,\"" +
              row.id +
              "\")' class='btn btn-danger btn-sm'>Hide</button>" +
              " <br/>" +
              " <br/>" +
              "<button  data-deleted='true' type='button' onclick='bannedUserByPostId(\"" +
              row.id +
              "\")' class='btn btn-danger btn-sm'>Ban</button>" +
              " <br/>";
          }
          return html;
        },
      },
    ],
  });

  $("#search").on("submit", function (e) {
    dataTablePost.draw();
    e.preventDefault();
  });
  /// end
});
