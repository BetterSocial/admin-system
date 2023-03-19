$(document).ready(function () {
  $("#createTopic").on("submit", function (e) {
    var name = $("#name").val();
    var category = $("#category").val();
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
    Swal.fire({
      title: "Please Wait !",
      html: "data uploading",
      showCancelButton: false, // There won't be any cancel button
      showConfirmButton: false, // There won't be any confirm button
      allowOutsideClick: false,
      onBeforeOpen: () => {
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
        if (data.success) {
          $("#createTopic")[0].reset();
          $("#myFirstImage").val("");
          Swal.hideLoading();
          return Swal.fire({
            icon: "success",
            title: "Success",
            text: "Topic Created",
          });
        } else {
          Swal.hideLoading();
          return Swal.fire({
            icon: "error",
            title: "Oops...",
            text: data.message,
          });
        }
      },
      error: function (data) {
        Swal.hideLoading();
        return Swal.fire({
          icon: "error",
          title: "Oops...",
          text: data.responseJSON.errors.file[0],
        });
      },
    });
  });
});
