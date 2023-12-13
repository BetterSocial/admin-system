function confirmAction(title, body, url, successMessage, errorMessage, successCallback, method = "POST") {
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

      fetch(url, {
        method: method,
        headers: {
          "X-CSRF-Token": $("meta[name=csrf-token]").attr("content"),
          "Content-Type": "application/json",
        },
        body: JSON.stringify(body),
      })
        .then((response) => response.json())
        .then((data) => {
          Swal.close();
          successCallback(data);
        })
        .catch((error) => {
          Swal.close();
          console.log(error);
          Swal.fire({
            icon: "error",
            title: "Error",
            text: error.message || errorMessage,
          });
        });
    }
  });
}
