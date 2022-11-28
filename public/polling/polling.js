var dataPost;
$(document).ready(function () {
  dataPost = $("#tablePollingList").DataTable({
    searching: false,
    stateSave: true,
    serverSide: true,
    lengthMenu: [10, 20, 50],
    language: {
      loadingRecords: "</br></br></br></br>;",
      processing: "Loading...",
      emptyTable: "No Post List",
    },
    ajax: {
      url: "/polling/data",
      type: "POST",
      headers: { "X-CSRF-Token": $("meta[name=csrf-token]").attr("content") },
      data: function (d) {
        d.question = $("#question").val();
        d.username = $("#username").val();
      },
    },
    columns: [
      {
        data: "Action",
        orderable: false,
        render: function (data, type, row) {
          return (
            " <a href='/polling/detail?polling_id=" +
            row.polling_id +
            "'> <button type='button' class='btn btn-primary'>Detail</button> </a>"
          );
        },
      },
      {
        data: "polling_id",
        visible: false,
      },

      {
        data: "question",
        className: "menufilter textfilter",
      },
      {
        data: "username",
        className: "menufilter textfilter",
      },
      {
        data: "created_at",
        className: "menufilter textfilter",
      },
      {
        data: "updated_at",
        className: "menufilter textfilter",
      },
    ],
  });

  $("#search").on("submit", function (e) {
    dataPost.draw();
    e.preventDefault();
  });
});

// function showTopic(locationId){
//     var formData = new FormData();
//     formData.append('location_id', locationId);
//
//     $.ajaxSetup({
//         headers: { "X-CSRF-Token" : $("meta[name=csrf-token]").attr("content") }
//     });
//     $.ajax({
//         type: 'POST',
//         dataType:'JSON',
//         data:formData,
//         contentType: false,
//         processData: false,
//         url: '/show/location',
//         success: function(data){
//             if(data.success){
//                 datatableLocations.ajax.reload(null,false);
//
//             }else{
//
//                 return Swal.fire({
//                     icon: 'error',
//                     title: 'Oops...',
//                     text: data.message,})
//             }
//         },
//         error: function(data){
//             console.log(data);
//             return Swal.fire({
//                 icon: 'error',
//                 title: 'Oops...',
//                 text: data.message})
//
//         }
//     });
//
// }
