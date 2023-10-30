$(document).ready(function() {
  const formattedDate = (data) => {
    // Mengubah menjadi objek Date
    const date = new Date(data);

    // Daftar nama hari
    const daysOfWeek = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];

    // Daftar nama bulan
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

    // Mendapatkan nama hari dari indeks hari dalam objek Date
    const dayName = daysOfWeek[date.getDay()];

    // Mendapatkan tanggal dari objek Date
    const dayOfMonth = date.getDate();

    // Mendapatkan nama bulan dari indeks bulan dalam objek Date
    const monthName = monthsOfYear[date.getMonth()];

    // Mendapatkan tahun dari objek Date
    const year = date.getFullYear();

    // Format akhir yang diinginkan
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
        console.log(d);
      },
    },
    columns: [
      {
        data: "Action",
        orderable: false,
        render: function(data, type, row) {
          console.log(row);
          let html = "";
          const userDetailViewLink = createLinkButton(
            `/user-detail-view?user_id=${row.user_id}`,
            "Show Detail"
          );
          html += userDetailViewLink;

          if (row.is_banned) {
            console.log("is banned");
            console.log(row.username);
          }

          if (!row.is_banned) {
            let onclick = "bannedUser(this,'" + row.user_id + "')";
            const bannedUserBtn = createButton("danger", "Ban User", onclick);
            html += bannedUserBtn;
          }

          if (row.user_score !== null && row.hasOwnProperty("user_score")) {
            const user_score = row.user_score;

            if (user_score.hasOwnProperty("blocked_by_admin")) {
              html += createButton("primary", "Unblock User");
            } else {
              html += createButton("danger", "Block User");
            }
          } else {
            html += createButton("danger", "Block User");
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
          // pengikut kita
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
          // total yang kita ikuti
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

function bannedUser(status, userId) {
  var formData = new FormData();
  formData.append("user_id", userId);
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

      $.ajaxSetup({
        headers: { "X-CSRF-Token": $("meta[name=csrf-token]").attr("content") },
      });

      $.ajax({
        type: "POST",
        data: formData,
        dataType: "JSON",
        contentType: false,
        processData: false,
        url: `/users/banned/${userId}`,
        success: function(data) {
          console.log(data);
          $("#tableUsers")
            .DataTable()
            .ajax.reload();
          Swal.close();
        },
        error: function(data) {
          Swal.close();
          return Swal.fire({
            icon: "error",
            title: "Oops...",
            text: data.message,
          });
        },
      });
    }
  });
}
