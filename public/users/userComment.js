let userCommentTabel = null;

userCommentTabel = $("#tableCommentUser").DataTable({
  searching: false,
  stateSave: true,
  serverSide: true,
  ajax: {
    url: "/users/comments/data",
    type: "POST",
    headers: { "X-CSRF-Token": $("meta[name=csrf-token]").attr("content") },
    data: function(d) {
      d.user_id = $("#user_id").val();
      console.log(d);
    },
  },
  columns: [
    { data: "post_id", orderable: true },
    { data: "comment_id", orderable: true },
    { data: "comment", orderable: true },
  ],
});
