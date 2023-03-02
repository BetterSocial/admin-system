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
    ],
  });

  $("#search").on("submit", function (e) {
    dataTable.draw();
    e.preventDefault();
  });
});
