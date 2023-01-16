$(document).ready(function () {
  var datatble = $("#tableUsers").DataTable({
    searching: false,
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
      url: "/users/data",
      type: "POST",
      headers: { "X-CSRF-Token": $("meta[name=csrf-token]").attr("content") },
      data: function (d) {
        d.username = $("#username").val();
        d.countryCode = $("#countryCode").val();
      },
    },
    columns: [
      {
        data: "Action",
        orderable: false,
        render: function (data, type, row) {
          var html =
            "<a href='/user-detail-view?user_id=" +
            row.user_id +
            "'> <button type='button' class='btn btn-primary btn-sm'>Show Detail</button> </a>";
          if (row.status == "Y") {
            html +=
              `<button type='button' onclick='changeStatus(this,\"` +
              row.user_id +
              "\")' class='btn btn-danger btn-sm'>Banned</button>";
          } else {
            html +=
              "<button type='button' onclick='changeStatus(this,\"" +
              row.user_id +
              "\")' class='btn btn-success btn-sm'>Active</button>";
          }
          return html;
        },
      },
      {
        data: "user_id",
        visible: false,
      },
      {
        data: "username",
        className: "menufilter textfilter",
      },
      {
        data: "country_code",
        orderable: true,
      },
      {
        data: "created_at",
        orderable: true,
      },
      {
        data: "status",
        orderable: false,
        render: function (data, type, row) {
          if (row.status == "Y") {
            return "<span class='badge badge-success'>Active</span>";
          } else {
            return "<span class='badge badge-danger'>Banned</span>";
          }
        },
      },

      {
        data: "followers",
        orderable: false,
        render: function (data, type, row) {
          //return "<a href='/user-follow/FOLLOWERS/"+row.user_id +"'> <button type='button' class='btn btn-primary btn-sm'>#Followers</button> </a>";
          return (
            "<a href='/user-follow-detail?type=FOLLOWERS&user_id=" +
            row.user_id +
            "'> <button type='button' class='btn btn-primary  btn-sm'>#Followers</button> </a>"
          );
        },
      },
      {
        data: "following",
        orderable: false,
        render: function (data, type, row) {
          return (
            "<a href='/user-follow-detail?type=FOLLOWING&user_id=" +
            row.user_id +
            "'> <button type='button' class='btn btn-primary btn-sm'>#Following</button> </a>"
          );
        },
      },
      {
        data: "posts",
        orderable: false,
        render: function (data, type, row) {
          return (
            " <a href='/user-show-post-list?user_id=" +
            row.user_id +
            "'> <button type='button' class='btn btn-primary btn-sm'>#posts</button> </a>"
          );
        },
      },
      {
        data: "session",
        orderable: false,
        render: function (data, type, row) {
          return " <a href='http://www.facebook.com'> <button type='button' class='btn btn-primary btn-sm'>#session</button> </a>";
        },
      },
      {
        data: "user_score",
        orderable: false,
        render: function (data, type, row) {
          return "<p> user score </p>";
        },
      },
    ],
  });

  $("#search").on("submit", function (e) {
    datatble.draw();
    e.preventDefault();
  });
});

//   function downloadCsv(){
//     var formData = new FormData();
//     formData.append('username', $('#username').val());
//     formData.append('countryCode', $('#countryCode').val());
//     Swal.fire({
//         title: 'Please Wait !',
//         html: 'data uploading',
//         showCancelButton: false, // There won't be any cancel button
//         showConfirmButton: false,// There won't be any confirm button
//         allowOutsideClick: false,
//         onBeforeOpen: () => {
//             Swal.showLoading()
//         },
//     });
//     $.ajaxSetup({
//         headers: { "X-CSRF-Token" : $("meta[name=csrf-token]").attr("content") }
//     });

//     $.ajax({
//         type: 'POST',
//         data:formData,
//         contentType: false,
//         processData: false,
//         url: '/download-csv',
//         success: function(data,status,filename){
//             console.log(filename);
//             console.log(data);
//             //window.location = 'download.php';
//         },
//         error:function(data){
//             console.log("INI ERROR");
//             console.log(data);
//         }

//     });
// }

function downloadCsv(e) {
  var username = $("#username").val();
  var countryCode = $("#countryCode").val();

  var popUpCsv = window.open("{{ route('download') }}", "_blank");
  popUpCsv.location =
    "/download-csv" + "?username=" + username + "&countryCode=" + countryCode;
}

function changeStatus(status, data) {
  var formData = new FormData();
  console.log(status);
  formData.append("user_id", data);
  Swal.fire({
    title: "Are you sure?",
    text: "",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes",
  }).then(async (result) => {
    if (result.isConfirmed) {
      Swal.fire({
        title: "Please Wait !",
        showCancelButton: false, // There won't be any cancel button
        showConfirmButton: false, // There won't be any confirm button
        allowOutsideClick: false,
        willOpen: () => {
          Swal.showLoading();
        },
      });
      updateStatus(status, formData)
        .then(() => {
          $("#tableUsers").DataTable().ajax.reload();
          Swal.close();
        })
        .catch((error) => {
          console.log(error);
          Swal.close();
          return Swal.fire({
            icon: "error",
            title: "Oops...",
            text: error.message,
          });
        });
    }
  });
}

function updateStatus(status, formData) {
  return fetch(`/update-${status}`, {
    method: "POST",
    body: formData,
    headers: {
      "X-CSRF-Token": $("meta[name=csrf-token]").attr("content"),
    },
  }).then((response) => {
    if (!response.ok) {
      throw new Error(response.statusText);
    }
    return response.json();
  });
}
