$(document).ready(function() {
  const formattedDate = (data) => {
    const date = new Date(data);

    const daysOfWeek = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];

    const monthsOfYear = [
      "Jan",
      "Feb",
      "Mar",
      "Apr",
      "May",
      "Jun",
      "Jul",
      "Aug",
      "Sep",
      "Oct",
      "Nov",
      "Dec",
    ];

    const dayName = daysOfWeek[date.getDay()];

    const dayOfMonth = date.getDate();

    const monthName = monthsOfYear[date.getMonth()];

    const year = date.getFullYear();

    const formattedDate = `${dayName}, ${dayOfMonth}-${monthName}-${year}`;
    return formattedDate;
  };

  function createButton(type, text, onclick) {
    return `<button type="button" class="btn btn-${type} btn-sm my-2" onclick="${onclick}">${text}</button>`;
  }

  function createLinkButton(url, text) {
    return `<a href="${url}"><button type="button" class="btn btn-primary btn-sm">${text}</button></a>`;
  }

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
      data: function(d) {
        d.username = $("#username").val();
        d.countryCode = $("#countryCode").val();
        d.topic = $("#topic").val();
        d.user_id = $("#userId").val();
      },
    },
    columns: [
      {
        data: "Action",
        orderable: false,
        render: function(data, type, row) {
          let { blocked_by_admin } = row;
          let html = "";
          const userDetailViewLink = createLinkButton(
            `/user-detail-view?user_id=${row.user_id}`,
            "Show Detail"
          );
          html += userDetailViewLink;

          if (!row.is_banned) {
            let onclick = "bannedUser(this,'" + row.user_id + "')";
            const bannedUserBtn = createButton("danger", "Ban User", onclick);
            html += bannedUserBtn;
          }

          let clickBlockUser = "blockUser('" + row.user_id + "')";
          let clickUnBlockUser = "unBlockUser('" + row.user_id + "')";

          const btnUnBlockUser = createButton(
            "primary",
            "Remove downrank",
            clickUnBlockUser
          );
          const btnBlockUser = createButton(
            "danger",
            "Downrank user",
            clickBlockUser
          );
          if (blocked_by_admin) {
            html += btnUnBlockUser;
          } else {
            html += btnBlockUser;
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
        className: "username-table",
        render: function(data, type, row) {
          return `<a href="https://www.instagram.com/${data}" target="_blank">${data}</a>`;
        },
      },
      {
        data: "country_code",
        orderable: true,
      },
      {
        data: "created_at",
        orderable: true,
        render: function(data, type, row) {
          return formattedDate(data);
        },
      },
      {
        data: "status",
        orderable: false,
        render: function(data, type, row) {
          if (row.is_banned) {
            return "<span class='badge badge-danger'>Banned</span>";
          } else {
            return "<span class='badge badge-success'>Active</span>";
          }
        },
      },

      {
        data: "followers",
        orderable: false,
        render: function(data, type, row) {
          let followers = [];
          followers = row.followeds;
          let total = followers.length;
          return `<a href="/user-follow-detail?type=FOLLOWERS&user_id=${row.user_id}"> <button type='button' class='btn btn-primary  btn-sm'>#Followers ${total}</button> </a>`;
        },
      },
      {
        data: "following",
        orderable: false,
        render: function(data, type, row) {
          let followeds = [];
          followeds = row.followers;
          let total = followeds.length;
          return (
            "<a href='/user-follow-detail?type=FOLLOWING&user_id=" +
            row.user_id +
            "'> <button type='button' class='btn btn-primary btn-sm'>#Following " +
            total +
            "</button> </a>"
          );
        },
      },
      {
        data: "posts",
        orderable: false,
        render: function(data, type, row) {
          return (
            " <a href='/user-show-post-list?user_id=" +
            row.user_id +
            "'> <button type='button' class='btn btn-primary btn-sm'>#posts</button> </a>"
          );
        },
      },
      {
        data: "posts",
        orderable: false,
        render: function(data, type, row) {
          return (
            " <a href='/users/comments?user_id=" +
            row.user_id +
            "'> <button type='button' class='btn btn-primary btn-sm'>#coments</button> </a>"
          );
        },
      },
      {
        data: "session",
        orderable: false,
        render: function(data, type, row) {
          return " <a href='http://www.facebook.com'> <button type='button' class='btn btn-primary btn-sm'>#session</button> </a>";
        },
      },
      {
        data: "user_score",
        orderable: false,
        render: function(data, type, row) {
          let userScore = 0;
          if (row.user_score !== null && row.hasOwnProperty("user_score")) {
            let user_score = row.user_score;
            if (user_score.hasOwnProperty("u1_score")) {
              let u1_score = user_score.u1_score;
              if (u1_score != 0) {
                let numericScore = parseFloat(u1_score);
                let formattedScore = numericScore.toFixed(3);
                userScore = formattedScore;
              }
            }
          }
          return `<p> ${userScore} </p>`;
        },
      },
      {
        data: "user_score",
        orderable: false,
        render: function(data, type, row) {
          let total = 0;
          if (row.blocked.length >= 1) {
            total = row.blocked.length;
          }
          return `<p> ${total} </p>`;
        },
      },
      {
        data: "user_topics",
        orderable: false,
        render: function(data, type, row) {
          let text = "";
          if (row.user_topics.length >= 1) {
            for (let index = 0; index < row.user_topics.length; index++) {
              let userTopic = row.user_topics[index];
              let topic = userTopic.topic;
              if (topic) {
                if (topic.name != null) {
                  text += topic.name + ", ";
                }
              }
            }
          }
          return `<p> ${text} </p>`;
        },
      },
    ],
  });

  $("#search").on("submit", function(e) {
    datatble.draw();
    e.preventDefault();
  });
});

function downloadCsv(e) {
  var username = $("#username").val();
  var countryCode = $("#countryCode").val();

  var popUpCsv = window.open("{{ route('download') }}", "_blank");
  popUpCsv.location =
    "/download-csv" + "?username=" + username + "&countryCode=" + countryCode;
}
function confirmAction(
  title,
  userId,
  url,
  successMessage,
  errorMessage,
  successCallback
) {
  var formData = new FormData();
  formData.append("user_id", userId);

  Swal.fire({
    title: title,
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
        showCancelButton: false,
        showConfirmButton: false,
        allowOutsideClick: false,
        willOpen: () => {
          Swal.showLoading();
        },
      });

      $.ajaxSetup({
        headers: { "X-CSRF-Token": $("meta[name=csrf-token]").attr("content") },
      });

      $.ajax({
        type: "POST",
        data: formData,
        dataType: "JSON",
        contentType: false,
        processData: false,
        url: url,
        success: function(data) {
          Swal.close();
          console.log(data);
          successCallback(data);
        },
        error: function(data) {
          Swal.close();
          console.log(data);
          Swal.fire({
            icon: "error",
            title: "Error",
            text: data.responseJSON.message || errorMessage,
          });
        },
      });
    }
  });
}

function bannedUser(status, userId) {
  confirmAction(
    "Are you sure?",
    userId,
    `/users/banned/${userId}`,
    "Success",
    "Oops...",
    function(data) {
      $("#tableUsers")
        .DataTable()
        .ajax.reload();
    }
  );
}

function blockUser(userId) {
  confirmAction(
    "Are you sure?",
    userId,
    `/users/admin-block-user`,
    "Success",
    "Error",
    function(data) {
      Swal.fire({
        icon: "success",
        title: "Success",
        text: data.message,
      });
      $("#tableUsers")
        .DataTable()
        .ajax.reload();
    }
  );
}

function unBlockUser(userId) {
  confirmAction(
    "Are you sure?",
    userId,
    `/users/admin-unblock-user`,
    "Success",
    "Error",
    function(data) {
      Swal.fire({
        icon: "success",
        title: "Success",
        text: data.message,
      });
      $("#tableUsers")
        .DataTable()
        .ajax.reload();
    }
  );
}
