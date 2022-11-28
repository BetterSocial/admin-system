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

const hideOrShowPost = async (id, isDeleted) => {
  try {
    const body = {
      is_deleted: isDeleted,
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
    title: "Are you sure?" + status,
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!",
  }).then((result) => {
    if (result.isConfirmed) {
      hideOrShowPost(postId, status)
        .then((res) => {
          console.log(res);
        })
        .catch((err) => {
          console.log(err);
        });
      //   Swal.fire("Deleted!", "Your file has been deleted.", "success");
    }
  });
};

const showPost = (e, postId) => {
  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!",
  }).then((result) => {
    if (result.isConfirmed) {
      Swal.fire("Deleted!", "Your file has been deleted.", "success");
    }
  });
};

$(document).ready(function () {
  getFeeds().then((data) => {
    console.log(data);
    dataTableLocations = $("#tablePostBlock").DataTable({
      searching: false,
      stateSave: true,
      //   serverSide: true,
      processing: true,
      language: {
        loadingRecords: "</br></br></br></br>;",
        processing: "Loading...",
        emptyTable: "No Data Locations",
      },
      data: data,
      columns: [
        {
          data: "id",
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
          data: "score_details.D_bench_score",
          className: "menufilter textfilter",
        },
        {
          data: "post_type",
          orderable: false,
          render: function (data, type, row) {
            // console.log("ini data: ", data);
            // console.log("ini type: ", type);
            // console.log("ini row: ", row);
            let isDeleted = false;
            if (row.is_deleted) {
              isDeleted = true;
            }
            let html = "";
            if (isDeleted) {
              html =
                "<button type='button' data-deleted='false' onclick='hidePost(false,\"" +
                row.id +
                "\")' class='btn btn-danger btn-sm'>Show</button>";
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
