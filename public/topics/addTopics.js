$(document).ready(function () {
  const sortInput = document.getElementById("sort");
  const sortError = document.getElementById("sort-error");

  sortInput.addEventListener("input", function (event) {
    const input = event.target.value;

    if (!/^[0-9]*$/.test(input)) {
      sortError.textContent = "Input must be number";
      sortInput.setCustomValidity("Input must be number");
    } else {
      sortError.textContent = "";
      sortInput.setCustomValidity("");
    }
  });

  $("#createTopic").on("submit", function (e) {
    e.preventDefault();
    var name = $("#name").val();
    var category = $("#category").val();
    let sort = $("#sort").val();
    if (name == null || name == "") {
      return Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "Name must be fill",
      });
    }
    if (category == null || category == "") {
      return Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "category must be fill",
      });
    }
    var firstUpload = $("#file").prop("files")[0];
    var formData = new FormData();
    formData.append("file", firstUpload);
    formData.append("name", name);
    formData.append("category", category);
    formData.append("sort", sort);
    Swal.fire({
      title: "Please Wait !",
      html: "data uploading",
      showCancelButton: false, // There won't be any cancel button
      showConfirmButton: false, // There won't be any confirm button
      allowOutsideClick: false,
      didOpen: () => {
        Swal.showLoading();
      },
    });
    $.ajaxSetup({
      headers: { "X-CSRF-Token": $("meta[name=csrf-token]").attr("content") },
    });
    $.ajax({
      type: "POST",
      dataType: "JSON",
      data: formData,
      contentType: false,
      processData: false,
      url: "/add/topics",
      success: function (data) {
        console.log(data);
        Swal.close();
        if (data.status == "success") {
          $("#createTopic")[0].reset();
          $("#myFirstImage").val("");
          return Swal.fire({
            icon: "success",
            title: "Success",
            text: "Topic Created",
          });
        } else {
          return Swal.fire({
            icon: "error",
            title: "error",
            text: data.message,
          });
        }
      },
      error: function (data, xhr, message) {
        Swal.close();
        console.log(data);
        console.log(xhr);
        console.log(message);
        return Swal.fire({
          icon: "error",
          title: "Internal Server Error",
          text: data.responseJSON.errors.file[0],
        });
      },
    });
  });
});
