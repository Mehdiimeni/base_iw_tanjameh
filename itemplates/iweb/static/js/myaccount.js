// password show hide eye
$(".togglePassword").on('click', function() {
    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $(this).parent().parent().find(".password");
    if (input.attr("type") === "password") {
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
  });