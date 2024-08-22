let datatble;
$(document).ready(function() {
  datatble = $("#tableNews").DataTable({
    searching: false,
    stateSave: true,
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
        let sitename = $("#siteName").val();
        if (sitename) {
          d.siteName;
        }
        let title = $("#title").val();
        if (title) {
          d.title;
        }
        let keyword = $("#keyword").val();
        if (keyword) {
          d.keyword;
        }
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
      },
      {
        data: "site_name",
      },
      {
        data: "title",
      },

      {
        data: "author",
      },
      {
        data: "keyword",
      },
      {
        data: "created_at",
      },
    ],
  });

  $("#search").on("submit", function(e) {
    e.preventDefault();
    datatble.draw();
  });
});
