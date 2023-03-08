$(document).ready(function () {
  let dataTable = $("#tableTopics").DataTable({
    searching: false,
    stateSave: true,
    processing: true,
    lengthMenu: [10, 20, 50],
    language: {
      loadingRecords: "</br></br></br></br>;",
      processing: "Loading...",
      emptyTable: "No Data Topics",
    },
    serverSide: true,
    ajax: {
      url: "/topics/data",
      type: "POST",
      headers: { "X-CSRF-Token": $("meta[name=csrf-token]").attr("content") },
      data: function (d) {
        d.name = $("#name").val();
        d.category = $("#category").val();
      },
      error: function (xhr, error, thrown) {
        console.log("xhr", xhr);
        console.log("error: ", error);
        console.log("DataTables error: ", thrown);
      },
    },
    columns: [
      {
        data: "topic_id",
        className: "menufilter textfilter",
      },
      {
        data: "name",
        className: "menufilter textfilter",
      },
      {
        data: "icon_path",
        className: "menufilter textfilter",
      },
      {
        data: "categories",
        className: "menufilter textfilter",
      },
      {
        data: "created_at",
        className: "menufilter textfilter",
      },
      {
        data: "Action",
        orderable: false,
        render: function (data, type, row) {
          var html =
            "<a href='/user-detail-view?user_id=" +
            row.user_id +
            "'> <button type='button' class='btn btn-primary btn-sm'>Show Detail</button> </a>";
          html +=
            `<button type='button' onclick='bannedUser(this,\"` +
            row.user_id +
            "\")' class='btn btn-danger btn-sm'>Banned</button>";
          return html;
        },
      },
    ],
  });

  $("#search").on("submit", function (e) {
    dataTable.draw();
    e.preventDefault();
  });
});
