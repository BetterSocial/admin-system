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

$(document).ready(function () {
  getFeeds().then((data) => {
    dataTableLocations = $("#tablePostBlock").DataTable({
      //   searching: false,
      //   stateSave: true,
      //   processing: true,
      language: {
        loadingRecords: "</br></br></br></br>;",
        processing:
          "<span class='fa-stack fa-lg'>\n\
        <i class='fa fa-spinner fa-spin fa-stack-2x fa-fw'></i>\n\
   </span>&emsp;Processing ...",
        emptyTable: "No Data",
      },
      order: [[5, "desc"]],
      data: data,
      deferLoading: 57,
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
          render: function (data, type, row) {
            let { images_url } = row;
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
          className: "menufilter textfilter",
          render: function (data, type, row) {
            let { images_url } = row;
            // image
            if (images_url.length >= 1) {
              return `
                  <div class="btn-detail" style="100px"  data-item="${row}"><img src="${images_url}" alt="${data}" class="rounded h-10" width="128" height="128"></div>
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
          className: "menufilter textfilter",
          render: function (data, type, row) {
            // poll options;
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
          data: "message",
          className: "menufilter textfilter",
          render: function (data, type, row) {
            // comments;
            let value = "";
            if (data.includes("test post quesgion")) {
              //   console.log(row);
            }
            let { latest_reactions } = row;
            if (latest_reactions) {
              let { comment } = latest_reactions;
              if (comment) {
                comment.forEach((element) => {
                  let item =
                    "<p>" +
                    element.user.data.username +
                    ": " +
                    element.data.text +
                    "</p>";
                  value = value + item;
                });
              }
            }
            return value;
          },
        },
        {
          data: "id",
          className: "menufilter textfilter",
          render: function (data, type, row) {
            // upvote
            let { reaction_counts } = row;
            return reaction_counts.upvotes || 0;
          },
        },
        {
          data: "anonimity",
          className: "menufilter textfilter",
          render: function (data, type, row) {
            // downvote;
            let { reaction_counts } = row;
            return reaction_counts.downvotes || 0;
          },
        },
        {
          data: "total_block",
          className: "menufilter textfilter",
        },
        {
          data: "post_type",
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
          },
        },
        {
          data: "post_type",
          orderable: false,
          render: function (data, type, row) {
            // action
            let isHide = false;
            let item = JSON.stringify(row);
            if (row.is_hide) {
              isHide = true;
            }
            let html = "";
            if (isHide) {
              html =
                "<button type='button' data-deleted='false' onclick='showPost(false,\"" +
                row.id +
                "\")' class='btn btn-info btn-sm'>Show</button>" +
                "<br/>";
              // `<button class="btn btn-info mt-2" onclick='detail(${item})'>Detail</button`;
            } else {
              html =
                "<button data-deleted='true' type='button' onclick='hidePost(true,\"" +
                row.id +
                "\")' class='btn btn-danger btn-sm'>Hide</button>" +
                " <br/>";
              // `<button class="btn btn-info mt-2" onclick='detail(${item})'>Detail</button`;
            }
            // action tab
            return html;
          },
        },
      ],
    });
  });
});
