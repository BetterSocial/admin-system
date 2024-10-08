var datatableLocations;
$(document).ready(function () {
  console.log("MASUUKKK");
  datatableLocations = $("#tableLocations").DataTable({
    searching: false,
    stateSave: true,
    serverSide: true,
    processing: true,
    language: {
      loadingRecords: "</br></br></br></br>;",
      processing: "Loading...",
      emptyTable: "No Data Locations",
    },
    ajax: {
      url: "/locations/data",
      type: "POST",
      headers: { "X-CSRF-Token": $("meta[name=csrf-token]").attr("content") },
      data: function (d) {
        console.log("datatest: ", d);
        d.neighborhood = $("#neighborhood").val();
        d.city = $("#city").val();
        d.state = $("#state").val();
        d.country = $("#country").val();
      },
    },
    lengthMenu: [
        [10, 100, 1000],
        [10, 100, 1000]
    ],
    columns: [
      {
        data: "location_id",
        visible: false,
      },
      {
        data: "zip",
        className: "menufilter textfilter",
      },
      {
        data: "neighborhood",
        className: "menufilter textfilter",
      },
      {
        data: "city",
        className: "menufilter textfilter",
      },
      {
        data: "state",
        className: "menufilter textfilter",
      },
      {
        data: "country",
        className: "menufilter textfilter",
      },
      {
        data: "location_level",
        className: "menufilter textfilter",
      },
      // {
      //     "data" :'status',
      //     "visible": false,
      // },
      {
        data: "location_icon",
        orderable: false,
        render: function (data, type, row) {
          console.log("from render: ", data);
          if (data != "" || data != " " || data != null) {
            if (data == "City") {
              return '<img src="https://res.cloudinary.com/hpjivutj2/image/upload/v1616639587/icons/city-icon_oyltzy.png" width="30" height="30" />';
            }

            if (data == "Neighborhood") {
              return '<img src="https://res.cloudinary.com/hpjivutj2/image/upload/v1616639587/icons/neighboorhod_iwvmaf.png" width="30" height="30" />';
            }

            if (data == "State") {
              return '<img src="https://res.cloudinary.com/hpjivutj2/image/upload/v1616639587/icons/state_uyxckp.png" width="30" height="30" />';
            }
          }
        },
        defaultContent: "No Icon",
      },
      {
        data: "flg_show",
        orderable: false,
        render: function (data, type, row) {
          if (row.flg_show == "N") {
            return (
              "<input type='checkbox' class='new-control-input' style='zoom:1.5;' onChange='showLocation(" +
              row.location_id +
              ")'>"
            );
          } else {
            return (
              "<input type='checkbox' checked class='new-control-input' style='zoom:1.5;' onChange='showLocation(" +
              row.location_id +
              ")'>"
            );
          }
        },
      },
    ],
  });

  $("#search").on("submit", function (e) {
    datatableLocations.draw();
    e.preventDefault();
  });
});

function showLocation(locationId) {
  console.log("MASUK YUK");
  var formData = new FormData();
  formData.append("location_id", locationId);

  $.ajaxSetup({
    headers: { "X-CSRF-Token": $("meta[name=csrf-token]").attr("content") },
  });
  $.ajax({
    type: "POST",
    dataType: "JSON",
    data: formData,
    contentType: false,
    processData: false,
    url: "/show/location",
    success: function (data) {
      if (data.success) {
        datatableLocations.ajax.reload(null, false);
      } else {
        datatableLocations.ajax.reload(null, false);
        return Swal.fire({
          icon: "error",
          title: "Oops...",
          text: data.message,
        });
      }
    },
    error: function (data) {
      console.log(data);
      datatableLocations.ajax.reload(null, false);
      return Swal.fire({
        icon: "error",
        title: "Oops...",
        text: data.message,
      });
    },
  });
}
