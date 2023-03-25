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
      // body: JSON.stringify(body),
    });
    let res = await response.json();
    console.log(res);
    if (res.status === "success") {
      console.log(res.data);
      currentLimitTopic = res.data.limit;
    } else {
      // Swal.fire("Error", res.message).then(() => {
      //   location.reload();
      // });
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
      // body: JSON.stringify(body),
    });
    let res = await response.json();
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
    .catch((err) => {
      console.log(err);
    });
}

function deleteTopic(topic) {
  console.log(topic.topic_id);
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
        type: "DELETE",
        dataType: "JSON",
        contentType: false,
        processData: false,
        url: `/topic/${topic.topic_id}`,
        success: function (data) {
          console.log(data);
          if (data.status === "success") {
            // $("#tableUsers").DataTable().ajax.reload();
            Swal.close();
            dataTable.ajax.reload(null, false);
            return Swal.fire({
              icon: "success",
              title: "Success",
              text: "Topic deleted",
            });
          }
        },
        error: function (data) {
          console.log(data);
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
        data: "flg_show",
        orderable: false,
        render: function (data, type, row) {
          let item = JSON.stringify(row);
          return `<button class="btn btn-danger btn-delete" onclick='deleteTopic(${item})'>Delete</button>`;
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

    let category = "";
    if (categorySelect) {
      category = categorySelect;
    }

    if (categoryInput) {
      category = categoryInput;
    }

    let data = {
      topic_id: topicId,
      sort: topicSort,
    };

    console.log(data);

    $.ajaxSetup({
      headers: { "X-CSRF-Token": $("meta[name=csrf-token]").attr("content") },
    });
    $.ajax({
      type: "PUT",
      url: url,
      // data: form.serialize(), // serializes the form's elements.
      data: data,
      success: function (data) {
        // alert(data); // show response from the php script.
        if (data.status === "success") {
          $("#modalTopicSort").modal("hide");
          $("#modalTopicSort").on("hidden.bs.modal", function () {
            $(this).find("input").val("");
            $(this).find("select").prop("selectedIndex", 0);
            $(this).find("textarea").val("");
          });
          // dataTable.draw();

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

  $("#modal-category").submit(function (e) {
    e.preventDefault(); // prevent the form from submitting via the browser
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

    console.log(data);

    $.ajaxSetup({
      headers: { "X-CSRF-Token": $("meta[name=csrf-token]").attr("content") },
    });
    $.ajax({
      type: "PUT",
      url: url,
      // data: form.serialize(), // serializes the form's elements.
      data: data,
      success: function (data) {
        // alert(data); // show response from the php script.
        console.log(data);
        if (data.status === "success") {
          $("#detailCategory").modal("hide");
          $("#detailCategory").on("hidden.bs.modal", function () {
            $(this).find("input").val("");
            $(this).find("select").prop("selectedIndex", 0);
            $(this).find("textarea").val("");
          });
          // dataTable.draw();

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
      // data: form.serialize(), // serializes the form's elements.
      data: data,
      success: function (data) {
        // alert(data); // show response from the php script.
        console.log(data);
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
