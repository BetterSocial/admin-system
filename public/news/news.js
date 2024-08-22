let datatble;
$(document).ready(function() {
  datatble = $("#tableNews").DataTable({
    searching: false,
    stateSave: true,
    pageLength: 50,
    language: {
      loadingRecords: "</br></br></br></br>;",
      processing: "Loading...",
      emptyTable: "No News Link",
    },
    serverSide: true,
    ajax: {
      url: "/news/data",
      type: "get",
      headers: {
        "X-CSRF-Token": $("meta[name=csrf-token]").attr("content"),
      },
      data: function(d) {
        d.siteName = $("#siteName").val();
        d.title = $("#title").val();
        d.keyword = $("#keyword").val();
      },
    },
    lengthMenu: [
      [10, 100, 1000],
      [10, 100, 1000],
    ],
    columns: [
      {
        data: "news_link_id",
        visible: false,
      },
      {
        data: "news_url",
        orderable: true,
        render: function(data, type, row) {
          return (
            " <a href=" +
            row.news_url +
            "> <button type='button' class='btn btn-primary'>Open Page</button> </a>"
          );
        },
      },
      {
        data: "domain_name",
        orderable: true,
      },
      {
        data: "site_name",
        orderable: true,
      },
      {
        data: "title",
        orderable: true,
      },

      {
        data: "author",
        orderable: true,
      },
      {
        data: "keyword",
        orderable: true,
      },
      {
        data: "created_at",
        orderable: true,
      },
    ],
  });

  $("#search").on("submit", function(e) {
    e.preventDefault();
    datatble.draw();
  });
});
