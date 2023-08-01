var dataPost;
$(document).ready(function () {
  dataPost = $("#tableShowPostList").DataTable({
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
      url: "/user-show-post-list/data",
      type: "POST",
      headers: { "X-CSRF-Token": $("meta[name=csrf-token]").attr("content") },
      data: function (d) {
        d.user_id = $("#userId").val();
        d.message = $("#message").val();
      },
    },
    columns: [
      {
        data: "id",
        visible: false,
      },
      {
        data: "message",
        render: function (data, type, row) {
          console.log(row);
          return `
          <div class="profile-container">
        <img src="path/to/avatar.jpg" alt="Avatar" class="avatar">
        <div class="user-details">
            <div class="user-name">John Doe</div>
            <div class="user-date">June 19, 2023</div>
        </div>
    </div>
          `;
          console.log(row);
          let itemPosList = "";

          var images_url = row.images_url;
          var images_url_length = images_url.length;

          var images_url_string = "<br>";

          for (let i = 0; i < images_url_length; i++) {
            images_url_string +=
              ' &nbsp;&nbsp; <a href=" ' +
              images_url[i] +
              ' " target="_blank"> ' +
              '  <img src="' +
              images_url[i] +
              '" width="100" height="100">  ';
            (" </a> &nbsp;&nbsp;");
          }

          var object = JSON.parse(row.object);

          let user_id = row.actor.substring(3);

          let timestamp = new Date(Date.parse(row.time))
            .toString()
            .substring(24, -1);

          let profile_picture_item =
            ' <a href="/user-detail-view?user_id=' + user_id + ' " > ';

          if (object.profile_pic_path == null)
            profile_picture_item +=
              '  <img src="https://res.cloudinary.com/hpjivutj2/image/upload/v1618554083/icons/no-profile_mvjney.jpg" width="50" height="50" style="border-radius: 50%;">  ';
          else
            profile_picture_item +=
              '  <img src="' +
              object.profile_pic_path +
              '" width="60" height="60">  ';
          profile_picture_item += " </a> ";

          let username_item =
            ' <h6> <a href="/user-detail-view?user_id=' +
            user_id +
            ' " > ' +
            object.username +
            " </a> </h6>  ";

          let post_item = " <p> " + row.message + " </p>";

          let upvote_item = row.count_upvote + " Upvote ";

          let downvote_item = row.count_downvote + " Downvote ";

          return (
            " " +
            '    <div class="widget-content">\n' +
            '        <div class="media">\n' +
            '            <div class="w-img">\n' +
            profile_picture_item +
            "            </div>\n" +
            '            <div class="media-body">\n' +
            username_item +
            '                <p class="meta-date-time">' +
            timestamp +
            " </p>\n" +
            "            </div>\n" +
            "        </div>\n" +
            "        <p> " +
            row.message +
            " </p>" +
            "        <div>    " +
            images_url_string +
            "        </div> <br> " +
            '        <div class="w-action">\n' +
            '            <div class="card-like">\n' +
            "                <span> " +
            upvote_item +
            " </span>\n" +
            "  &nbsp;&nbsp;&nbsp;&nbsp;   " +
            "                <span> " +
            downvote_item +
            " </span>\n" +
            "            </div>\n" +
            "        </div>\n" +
            "    </div>\n" +
            " "
          );
        },
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
