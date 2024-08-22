let datatable;

function updateStatus(domain_page_id, status) {
  let body = {
    id: domain_page_id,
    status: status,
  };
  confirmAction(
    "Are you sure?",
    body,
    "/domain/update-status",
    "",
    "",
    (data) => {
      if (data.status === "success") {
        Swal.fire({
          icon: "success",
          title: "Success",
          text: data.message,
        });
        datatable.draw();
      } else {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: data.message,
        });
      }
    },
    "POST"
  );
}

$(document).ready(function() {
  datatable = $("#tableDomain").DataTable({
    searching: false,
    stateSave: true,
    processing: true,
    language: {
      processing: "Loading...",
      emptyTable: "No Data Domain",
    },
    serverSide: true,
    ajax: {
      url: "/domain/data",
      type: "POST",
      headers: { "X-CSRF-Token": $("meta[name=csrf-token]").attr("content") },
      data: function(d) {
        d.domainName = $("#domainName").val();
      },
    },
    lengthMenu: [
        [10, 100, 1000],
        [10, 100, 1000]
    ],
    columns: [
      {
        data: "action",
        orderable: false,
        render: function(data, type, row) {
          return (
            " <a href='/domain/form-logo?domain_page_id=" +
            row.domain_page_id +
            "'> <button type='button' class='btn btn-primary'>Add Logo</button> </a>"
          );
        },
      },
      {
        data: "domain_page_id",
        visible: false,
      },
      {
        data: "domain_name",
        className: "menufilter textfilter",
      },
      {
        data: "logo",
        orderable: false,
        render: function(data, type, row) {
          if (data != "" || data != " " || data != null) {
            return '<img src="' + data + '" width="30" height="20" />';
          }
        },
        defaultContent: "No Icon",
      },
      {
        data: "short_description",
        className: "menufilter textfilter",
      },
      {
        data: "created_at",
        className: "menufilter textfilter",
      },
      {
        data: "status",
        className: "menufilter textfilter",
        render: function(data, type, row) {
          if (data) {
            return (
              '<button type="button" class="btn btn-danger" onclick=\'updateStatus("' +
              row.domain_page_id +
              "\", false)'>Hide</button>"
            );
          } else {
            return (
              '<button type="button" class="btn btn-primary" onclick=\'updateStatus("' +
              row.domain_page_id +
              "\", true)'>Show</button>"
            );
          }
        },
      },
    ],
  });

  $("#search").on("submit", function(e) {
    datatable.draw();
    e.preventDefault();
  });
});
