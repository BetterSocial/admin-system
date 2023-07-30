let table;
$(document).ready(function () {
  table = $("#tableImage").DataTable({
    searching: false,
    stateSave: true,
    language: {
      processing: "Loading...",
      emptyTable: "No Data Topics",
    },
    serverSide: true,
    ajax: {
      url: "/image/data",
      type: "POST",
      headers: { "X-CSRF-Token": $("meta[name=csrf-token]").attr("content") },
      data: function (d) {
        d.name = $("#name").val();
        d.category = $("#category").val();
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
        name: "id",
        orderable: true,
        className: "menufilter textfilter",
        render: function (data, type, row) {
          console.log(data);
          return data;
        },
      },
      {
        data: "name",
        orderable: true,
        className: "menufilter textfilter",
      },
      {
        data: "url",
        orderable: false,
      },
      {
        data: "url",
        orderable: false,
        render: function (data, type, row) {
          let html = `
          <a href="${data}" target="_blank">
                <img src="${data}" alt="Preview Image" width="300" height="200">
          </a>

          `;
          return html;
        },
      },
    ],
  });

  //   $("#search").on("submit", function (e) {
  //     dataTable.draw();
  //     e.preventDefault();
  //   });
});
