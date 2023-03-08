var dataTable;

let categories = [];

async function getCategory() {
  try {
    const response = await fetch("/topic/category", {
      method: "POST",
      headers: {
        "X-CSRF-Token": $("meta[name=csrf-token]").attr("content"),
      },
      // body: JSON.stringify(body),
    });
    let res = await response.json();
    console.log(res.status);
    if (res.status === "success") {
      return res.data;
    } else {
      // Swal.fire("Error", res.message).then(() => {
      //   location.reload();
      // });
    }
  } catch (err) {
    console.log(err);
    // Swal.fire("Error", err).then(() => {
    //   location.reload();
    // });
  }
}

function createItemSelectCategory(categories) {
  let categorySelect = document.getElementById("categorySelect");

  categories.map((item) => {
    categorySelect.insertAdjacentHTML(
      "beforeend",
      `<option value="${item.categories}">${item.categories}</option>`
    );
  });
}

async function detailCategory(item) {
  $("#topicName").val(item.name);
  $("#topicId").val(item.topic_id);
  createItemSelectCategory(categories);
  $("#detailCategory").modal("show");
}
$(document).ready(function () {
  getCategory()
    .then((data) => {
      console.log(data[0]);
      categories = data;
    })
    .catch((err) => {
      console.log(err);
    });
  dataTable = $("#tableTopics").DataTable({
    searching: false,
    stateSave: true,
    language: {
      processing: "Loading...",
      emptyTable: "No Data Topics",
    },
    serverSide: true,
    ajax: {
      url: "/topics/data",
      type: "POST",
      headers: { "X-CSRF-Token": $("meta[name=csrf-token]").attr("content") },
      data: function (d) {
        d.name = $("#name").val();
        d.category = $("#category").val();
      },
    },
    error: function (xhr, error, thrown) {
      console.log("xhr", xhr);
      console.log("error", error);
      console.log("thrown", thrown);
    },
    columns: [
      {
        data: "topic_id",
        visible: false,
      },
      {
        data: "name",
        className: "menufilter textfilter",
        render: function (data, type, row) {
          return `
                <div class="btn-detail"  data-item="${row}">${data}</div>
                `;
        },
      },
      {
        data: "icon_path",
        orderable: false,
        render: function (data, type, row) {
          if (data != "" || data != " " || data != null) {
            return '<img src="' + data + '" width="30" height="20" />';
          }
        },
        defaultContent: "No Icon",
      },
      {
        data: "categories",
        className: "menufilter textfilter",
        render: function (data, type, row) {
          console.log("data", data);
          let value = "";
          let item = JSON.stringify(row);
          value += `<button style="border: none; background: transparent" onclick='detailCategory(${item})' >`;
          value += "<p>" + data + "</p>";

          value += "</button>";
          return value;
          return data;
        },
      },
      {
        data: "created_at",
        className: "menufilter textfilter",
      },
      {
        data: "followers",
        render: function (data, type, row) {
          return (
            " <a href='/follow-topics?topic_id=" +
            row.topic_id +
            "'> <button type='button' class='btn btn-primary'>#Followers</button> </a>"
          );
        },
      },
      {
        data: "flg_show",
        orderable: false,
        render: function (data, type, row) {
          if (row.flg_show == "N") {
            return (
              "<input type='checkbox' class='new-control-input' style='zoom:1.5;' onChange='showTopic(" +
              row.topic_id +
              ")'>"
            );
          } else {
            return (
              "<input type='checkbox' checked class='new-control-input' style='zoom:1.5;' onChange='showTopic(" +
              row.topic_id +
              ")'>"
            );
          }
        },
      },
    ],
  });

  $("#search").on("submit", function (e) {
    dataTable.draw();
    e.preventDefault();
  });
});

function showTopic(topicId) {
  var formData = new FormData();
  formData.append("topic_id", topicId);

  $.ajaxSetup({
    headers: { "X-CSRF-Token": $("meta[name=csrf-token]").attr("content") },
  });
  $.ajax({
    type: "POST",
    dataType: "JSON",
    data: formData,
    contentType: false,
    processData: false,
    url: "/show/topics",
    success: function (data) {
      console.log(data);
      if (data.success) {
        dataTable.ajax.reload(null, false);
      } else {
        dataTable.ajax.reload(null, false);
        return Swal.fire({
          icon: "error",
          title: "Oops...",
          text: data.message,
        });
      }
    },
    error: function (data) {
      console.log(data);
      dataTable.ajax.reload(null, false);
      return Swal.fire({
        icon: "error",
        title: "Oops...",
        text: data.message,
      });
    },
  });
}
