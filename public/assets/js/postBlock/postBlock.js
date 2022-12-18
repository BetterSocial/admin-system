let dataTableLocations;
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
    return res;
  } catch (err) {
    console.log(err);
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
  }
};

const hidePost = (status, postId) => {
  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
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
    text: "You won't be able to revert this!",
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

$(document).ready(function () {
  getFeeds().then((data) => {
    dataTableLocations = $("#tablePostBlock").DataTable({
      //   searching: false,
      //   stateSave: true,
      //   processing: true,
      language: {
        loadingRecords: "</br></br></br></br>;",
        processing: "Loading...",
        emptyTable: "No Data",
      },
      order: [[5, "desc"]],
      data: data,
      columns: [
        {
          data: "id",
          className: "menufilter textfilter",
        },
        {
          data: "actor.data.username",
          className: "menufilter textfilter",
        },
        {
          data: "message",
          className: "menufilter textfilter",
        },
        {
          data: "privacy",
          className: "menufilter textfilter",
        },
        {
          data: "anonimity",
          className: "menufilter textfilter",
        },
        {
          data: "total_block",
          className: "menufilter textfilter",
        },
        {
          data: "post_type",
          className: "menufilter textfilter",
          render: function (data, type, row) {
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
          },
        },
        {
          data: "post_type",
          orderable: false,
          render: function (data, type, row) {
            let isHide = false;
            if (row.is_hide) {
              isHide = true;
            }
            let html = "";
            if (isHide) {
              html =
                "<button type='button' data-deleted='false' onclick='showPost(false,\"" +
                row.id +
                "\")' class='btn btn-info btn-sm'>Show</button>";
            } else {
              html =
                "<button data-deleted='true' type='button' onclick='hidePost(true,\"" +
                row.id +
                "\")' class='btn btn-danger btn-sm'>Hide</button>";
            }

            return html;
          },
        },
      ],
    });
  });
});
