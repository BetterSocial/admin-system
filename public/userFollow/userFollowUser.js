$(document).ready(function () {
  var id = $("#userId").val();
  var type = $("#type").val();
  var datatble = $("#tableUsersFollow").DataTable({
    searching: false,
    processing: true,
    stateSave: true,
    lengthMenu: [50, 100, 250],
    pageLength: 50,
    language: {
      loadingRecords: "</br></br></br></br>;",
      processing: "Loading...",
      emptyTable: "No User Follow",
    },
    serverSide: true,
    ajax: {
      url: "/user/follow/list",
      type: "POST",
      headers: { "X-CSRF-Token": $("meta[name=csrf-token]").attr("content") },
      data: function (d) {
        d.user_id = id;
        d.type = type;
      },
    },
    columns: [
      {
        data: "user_id",
        visible: false,
      },
      {
        data: "username",
        className: "menufilter textfilter",
      },
      {
        data: "real_name",
        className: "menufilter textfilter",
      },
      {
        data: "country_code",
        orderable: true,
      },
    ],
  });
});
