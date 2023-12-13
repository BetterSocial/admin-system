let dataTable;

let categories = [];

let currentLimitTopic = 0;

function cleanCode() {
  $(this)
    .find("input")
    .val("");
  $(this)
    .find("select")
    .prop("selectedIndex", 0);
  $(this)
    .find("textarea")
    .val("");
}

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
  } catch (error) {}
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

function createItemSelectCategory(categories, category) {
  let categorySelect = document.getElementById("categorySelect");
  categories.map((item) => {
    categorySelect.insertAdjacentHTML("beforeend", `<option value="${item.categories}">${item.categories}</option>`);
  });
  $("#categorySelect").val(category);
}

async function getDetailTopic(id) {
  let topic = null;
  const response = await fetch(`/topics/detail?id=${id}`, {
    method: "GET",
    headers: {
      "X-CSRF-Token": $("meta[name=csrf-token]").attr("content"),
    },
  });
  let res = await response.json();
  if (res.status === "success") {
    topic = res.data;
  }
  return topic;
}

async function showDetailCategory(id) {
  let topic = await getDetailTopic(id);
  if (topic) {
    await $("#topicName").val(topic.name);
    $("#topicId").val(id);
    createItemSelectCategory(categories, topic.categories);
    $("#detailCategory").modal("show");
  }
}

async function showSortTopic(topicId, sort) {
  $("#topicSort").val(sort);
  $("#topicId").val(topicId);
  $("#modalTopicSort").modal("show");
}

function getNewCategory() {
  getCategory()
    .then((data) => {
      categories = data;
    })
    .catch((err) => {});
}

function signCategory(topicId, sign, name, categories) {
  $(".topic-id-sign").val(topicId);
  $(".name-topic-sign").val(name);
  $(".category-topic-sign").val(categories);
  if (sign == 1) {
    $("#modalTopicSign").modal("show");
  } else {
    $("#modalTopicUnSign").modal("show");
  }
}

function updateImage(topicId, type = "icon") {
  $(".topic-id").val(topicId);
  if (type == "icon") {
    $(".title-modal-icon").text("Changing the icon in the topic");
    $(".type-upload").val("icon");
  } else {
    $(".type-upload").val("cover");
    $(".title-modal-icon").text("Changing the cover in the topic");
  }
  $("#modalChangeIcon").modal("show");
}

$(document).ready(function() {
  $(".btn-limit-topic").click(function() {
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
      data: function(d) {
        d.name = $("#name").val();
        d.category = $("#category").val();
      },
    },
    error: function(xhr, error, thrown) {},
    columns: [
      {
        data: "topic_id",
        visible: false,
      },
      {
        data: "name",
        className: "menufilter textfilter",
        render: function(data, type, row) {
          return `
                <div class="btn-detail"  data-item="${row}">${data}</div>
                `;
        },
      },
      {
        data: "icon_path",
        orderable: false,
        render: function(data, type, row) {
          let icon = row.icon_path;
          let img = "";
          if (icon != "" && icon != " " && icon != null) {
            img = '<img src="' + icon + '" width="30" height="20" />';
          } else {
            img = "No Icon";
          }
          return `<button style="background: transparent; outline: none; border: none" onclick='updateImage(${row.topic_id}, "icon")'>${img}</button>`;
        },
        defaultContent: "No Icon",
      },
      {
        data: "cover_path",
        orderable: false,
        render: function(data, type, row) {
          let icon = row.cover_path;
          let img = "";
          if (icon != "" && icon != " " && icon != null) {
            img = '<img src="' + icon + '" width="30" height="20" />';
          } else {
            img = "No Icon";
          }
          return `<button style="background: transparent; outline: none; border: none" onclick='updateImage(${row.topic_id}, "cover")'>${img}</button>`;
        },
        defaultContent: "No Icon",
      },
      {
        data: "categories",
        className: "menufilter textfilter",
        render: function(data, type, row) {
          let value = "";
          value += `<button style="border: none; background: transparent; width: 100%; height: 100%" onclick='showDetailCategory(${row.topic_id})' >`;
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
        render: function(data, type, row) {
          let value = "";
          value += `<button style="border: none; background: transparent" onclick='showSortTopic(${row.topic_id}, ${row.sort})' >`;
          value += "<p>" + data + "</p>";

          value += "</button>";
          return value;
        },
      },
      {
        data: "followers",
        render: function(data, type, row) {
          return (
            " <a href='/follow-topics?topic_id=" +
            row.topic_id +
            "'> <button type='button' class='btn btn-primary'>#Followers</button> </a>"
          );
        },
      },
      {
        data: "total_user_topics",
        render: function(data, type, row) {
          return data;
        },
      },
      {
        data: "sign",
        render: function(data, type, row) {
          let total = 0;
          if (row.posts.length >= 1) {
            total = row.posts.length;
          }
          return total;
        },
      },
      {
        data: "sign",
        render: function(data, type, row) {
          let topicId = row.topic_id;
          let name = row.name;
          let categories = row.categories;
          if (row.sign) {
            return `<button class="btn btn-danger btn-delete" onclick='signCategory(${topicId}, 0, "${name}", "${categories}")'>Remove from OB</button>`;
          } else {
            return `<button class="btn btn-primary" onclick='signCategory(${topicId}, 1, "${name}", "${categories}")'>Add to OB</button>`;
          }
        },
      },
      {
        data: "flg_show",
        orderable: false,
        render: function(data, type, row) {
          return "<div></div>";
        },
      },
    ],
  });

  $("#search").on("submit", function(e) {
    dataTable.draw();
    e.preventDefault();
  });

  $("#formTopicSort").submit(function(e) {
    e.preventDefault();
    let form = $(this);
    let url = form.attr("action");
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
      success: function(data) {
        if (data.status === "success") {
          $("#modalTopicSort").modal("hide");
          $("#modalTopicSort").on("hidden.bs.modal", function() {
            cleanCode();
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
      error: function(xhr, status, error) {
        return Swal.fire({
          icon: "error",
          title: xhr.statusText,
          text: xhr.responseJSON.message,
        });
      },
    });
  });

  $("#modal-category").submit(function(e) {
    e.preventDefault();
    let form = $(this);
    let url = form.attr("action");
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
      success: function(data) {
        if (data.status === "success") {
          $("#detailCategory").modal("hide");
          $("#detailCategory").on("hidden.bs.modal", function() {
            cleanCode();
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
      error: function(xhr, status, error) {
        return Swal.fire({
          icon: "error",
          title: xhr.statusText,
          text: xhr.responseJSON.message,
        });
      },
    });
  });

  $("#formTopicLimit").submit(function(e) {
    e.preventDefault();
    const form = $(this);
    const url = form.attr("action");
    let limit = $("#limitTopic").val();
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
      success: function(data) {
        if (data.status === "success") {
          $("#modalTopicLimit").modal("hide");
          $("#modalTopicLimit").on("hidden.bs.modal", function() {
            cleanCode();
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
      error: function(xhr, status, error) {
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
  let formData = new FormData();
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
    success: function(data) {
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
    error: function(data) {
      dataTable.ajax.reload(null, false);
      return Swal.fire({
        icon: "error",
        title: "Oops...",
        text: data.message,
      });
    },
  });
}

$(".btn-change-category").click(function() {
  let oldCategory = $("#oldCategory").val();
  let newCategory = $("#newCategory").val();
  if (oldCategory) {
    confirmAction(
      "Are you sure?",
      {
        old_category: oldCategory,
        new_category: newCategory,
      },
      "/topics/category",
      "Category changed successfully",
      "Category changed failed",
      function(data) {
        // close modal
        console.log(data);
        // show message use sweet alert
        Swal.fire({
          icon: "success",
          title: "Success",
          text: "Category changed successfully",
        });

        dataTable.ajax.reload(null, false);
        $("#modalChangeCategory").modal("hide");
      },
      "PUT"
    );
  } else {
    Swal.fire({
      icon: "error",
      title: "Oops...",
      text: "Old Category is required",
    });
  }
});

$(".btn-delete-category").click(function() {
  let oldCategory = $("#oldCategory").val();
  if (oldCategory) {
    confirmAction(
      "Are you sure?",
      {
        old_category: oldCategory,
      },
      "/topics/category",
      "Category deleted successfully",
      "Category deleted failed",
      function(data) {
        Swal.fire({
          icon: "success",
          title: "Success",
          text: "Category deleted successfully",
        });
        dataTable.ajax.reload(null, false);
        $("#modalChangeCategory").modal("hide");
        console.log(data);
      },
      "DELETE"
    );
  } else {
    Swal.fire({
      icon: "error",
      title: "Oops...",
      text: "Old Category is required",
    });
  }
});

$("#formTopicSign").on("submit", function(e) {
  e.preventDefault();
  confirmAction(
    "Are you sure?",
    {
      topic_id: $(".topic-id-sign").val(),
      sign: 1,
    },
    "/topics/sign",
    "Topic signed successfully",
    "Topic signed failed",
    function(data) {
      console.log(data);
      Swal.fire({
        icon: "success",
        title: "Success",
        text: "Topic signed successfully",
      });
      dataTable.draw();
      $("#modalTopicSign").modal("hide");
    }
  );
});

$("#formUnSignTopic").on("submit", function(e) {
  e.preventDefault();
  confirmAction(
    "Are you sure?",
    {
      topic_id: $(".topic-id-sign").val(),
      sign: 0,
    },
    "/topics/un-sign",
    "Topic unsigned successfully",
    "Topic unsigned failed",
    function(data) {
      console.log(data);
      Swal.fire({
        icon: "success",
        title: "Success",
        text: "Topic unsigned successfully",
      });
      dataTable.draw();
      $("#modalTopicUnSign").modal("hide");
    }
  );
});
