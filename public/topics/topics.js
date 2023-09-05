var dataTable;

let categories = [];

let currentLimitTopic = 0;

async function getCurrentLimitTopic() {
  try {
    const response = await fetch("/topic/limit", {
      method: "GET",
      headers: {
        "X-CSRF-Token": $("meta[name=csrf-token]").attr("content"),
      },
    });
    let res = await response.json();
    if (res.status === "success") {
      currentLimitTopic = res.data.limit;
    }
  } catch (error) {
    console.log("error", error);
  }
}

async function getCategory() {
  try {
    const response = await fetch("/topic/category", {
      method: "POST",
      headers: {
        "X-CSRF-Token": $("meta[name=csrf-token]").attr("content"),
      },
    });
    let res = await response.json();
    if (res.status === "success") {
      return res.data;
    }
  } catch (err) {}
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

async function showSortTopic(item) {
  $("#topicSort").val(item.sort);
  $("#topicId").val(item.topic_id);
  $("#modalTopicSort").modal("show");
}

function getNewCategory() {
  getCategory()
    .then((data) => {
      categories = data;
    })
    .catch((err) => {});
}

function signCategory(topic, sign) {
  $(".topic-id-sign").val(topic.topic_id);
  $(".name-topic-sign").val(topic.name);
  $(".category-topic-sign").val(topic.categories);
  if (sign == 1) {
    $("#modalTopicSign").modal("show");
  } else {
    $("#modalTopicUnSign").modal("show");
  }
}

$(document).ready(function () {
  $(".btn-limit-topic").click(function () {
    $(".current-limit-topic").val(currentLimitTopic);
    $("#modalTopicLimit").modal("show");
  });

  getCurrentLimitTopic();

  getCategory()
    .then((data) => {
      categories = data;
    })
    .catch((err) => {});

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
        console.log(d);
      },
    },
    error: function (xhr, error, thrown) {},
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
          } else {
            return '<img src="" width="30" height="20">';
          }
        },
        defaultContent: "No Icon",
      },
      {
        data: "categories",
        className: "menufilter textfilter",
        render: function (data, type, row) {
          let value = "";
          let item = JSON.stringify(row);
          value += `<button style="border: none; background: transparent; width: 100%; height: 100%" onclick='detailCategory(${item})' >`;
          value += "<p>" + data + "</p>";

          value += "</button>";
          return value;
        },
      },
      {
        data: "created_at",
        className: "menufilter textfilter",
      },
      {
        data: "sort",
        className: "menufilter textfilter",
        render: function (data, type, row) {
          let value = "";
          let item = JSON.stringify(row);
          value += `<button style="border: none; background: transparent" onclick='showSortTopic(${item})' >`;
          value += "<p>" + data + "</p>";

          value += "</button>";
          return value;
        },
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
        data: "total_user_topics",
        render: function (data, type, row) {
          return data;
        },
      },
      {
        data: "sign",
        render: function (data, type, row) {
          console.log(row);
          let total = 0;
          if (row.posts.length >= 1) {
            total = row.posts.length;
          }
          return total;
        },
      },
      {
        data: "sign",
        render: function (data, type, row) {
          let item = JSON.stringify(row);
          if (row.sign) {
            return `<button class="btn btn-danger btn-delete" onclick='signCategory(${item}, 0)'>Remove from OB</button>`;
          } else {
            return `<button class="btn btn-primary" onclick='signCategory(${item}, 1)'>Add to OB</button>`;
          }
        },
      },
      {
        data: "flg_show",
        orderable: false,
        render: function (data, type, row) {
          return "<div></div>";
        },
      },
    ],
  });

  $("#search").on("submit", function (e) {
    dataTable.draw();
    e.preventDefault();
  });

  $("#formTopicSort").submit(function (e) {
    e.preventDefault();
    var form = $(this);
    var url = form.attr("action");
    let topicId = $("#topicId").val();
    let topicSort = $("#topicSort").val();
    let data = {
      topic_id: topicId,
      sort: topicSort,
    };

    $.ajaxSetup({
      headers: { "X-CSRF-Token": $("meta[name=csrf-token]").attr("content") },
    });
    $.ajax({
      type: "PUT",
      url: url,
      data: data,
      success: function (data) {
        if (data.status === "success") {
          $("#modalTopicSort").modal("hide");
          $("#modalTopicSort").on("hidden.bs.modal", function () {
            $(this).find("input").val("");
            $(this).find("select").prop("selectedIndex", 0);
            $(this).find("textarea").val("");
          });

          getNewCategory();
          dataTable.ajax.reload(null, false);
          return Swal.fire({
            icon: "success",
            title: "Success",
            text: "Topic Updated",
          });
        } else {
          return Swal.fire({
            icon: "error",
            title: "Oops...",
            text: data.message,
          });
        }
      },
      error: function (xhr, status, error) {
        return Swal.fire({
          icon: "error",
          title: xhr.statusText,
          text: xhr.responseJSON.message,
        });
      },
    });
  });

  $("#modal-category").submit(function (e) {
    e.preventDefault();
    var form = $(this);
    var url = form.attr("action");
    let topicId = $("#topicId").val();
    let topicName = $("#topicName").val();
    let categorySelect = $("#categorySelect").val();
    let categoryInput = $("#categoryInput").val();

    let category = "";
    if (categorySelect) {
      category = categorySelect;
    }

    if (categoryInput) {
      category = categoryInput;
    }

    let data = {
      topic_id: topicId,
      name: topicName,
      categories: category,
    };

    $.ajaxSetup({
      headers: { "X-CSRF-Token": $("meta[name=csrf-token]").attr("content") },
    });
    $.ajax({
      type: "PUT",
      url: url,
      data: data,
      success: function (data) {
        if (data.status === "success") {
          $("#detailCategory").modal("hide");
          $("#detailCategory").on("hidden.bs.modal", function () {
            $(this).find("input").val("");
            $(this).find("select").prop("selectedIndex", 0);
            $(this).find("textarea").val("");
          });

          getNewCategory();
          dataTable.ajax.reload(null, false);
          return Swal.fire({
            icon: "success",
            title: "Success",
            text: "Topic Updated",
          });
        } else {
          return Swal.fire({
            icon: "error",
            title: "Oops...",
            text: data.message,
          });
        }
      },
      error: function (xhr, status, error) {
        return Swal.fire({
          icon: "error",
          title: xhr.statusText,
          text: xhr.responseJSON.message,
        });
      },
    });
  });

  $("#formTopicLimit").submit(function (e) {
    e.preventDefault();
    const form = $(this);
    const url = form.attr("action");
    let limit = $("#limitTopic").val();
    console.log("limit", limit);
    let data = {
      limit: limit,
    };

    $.ajaxSetup({
      headers: { "X-CSRF-Token": $("meta[name=csrf-token]").attr("content") },
    });
    $.ajax({
      type: "POST",
      url: url,
      data: data,
      success: function (data) {
        if (data.status === "success") {
          $("#modalTopicLimit").modal("hide");
          $("#modalTopicLimit").on("hidden.bs.modal", function () {
            $(this).find("input").val("");
            $(this).find("select").prop("selectedIndex", 0);
            $(this).find("textarea").val("");
          });
          getCurrentLimitTopic();
          return Swal.fire({
            icon: "success",
            title: "Success",
            text: "Limit Topic Updated",
          });
        } else {
          return Swal.fire({
            icon: "error",
            title: "Oops...",
            text: data.message,
          });
        }
      },
      error: function (xhr, status, error) {
        console.log("Error: " + error);
        console.log("Status: " + status);
        console.log(xhr);
        return Swal.fire({
          icon: "error",
          title: xhr.statusText,
          text: xhr.responseJSON.message,
        });
      },
    });
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
      dataTable.ajax.reload(null, false);
      return Swal.fire({
        icon: "error",
        title: "Oops...",
        text: data.message,
      });
    },
  });
}
