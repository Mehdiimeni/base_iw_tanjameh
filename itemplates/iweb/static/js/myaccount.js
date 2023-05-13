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

// buy another size
$(".btnAnotherSize").click(function(){
$(this).parent(".boxModalOwned").removeClass("d-flex");
$(this).parent(".boxModalOwned").toggleClass("d-none");
$(this).parent().parent().find(".boxAnotherSize").addClass("d-flex flex-column flex-grow-1");
});

// remove owned item
$(".btnRequestSize").click(function(event){
  const toastLiveExample = document.getElementById('boxRequestSize')
  const toast = new bootstrap.Toast(toastLiveExample)
  toast.show()
  $(this).parent().parent().find(".boxModalOwned").removeClass("d-none");
  $(this).parent().parent().find(".boxModalOwned").toggleClass("d-flex");
  $(this).parent(".boxAnotherSize").removeClass("d-flex flex-column flex-grow-1");
});

// Notification exists product
$(".btnNotification").click(function(){
  const toastLiveExample = document.getElementById('boxRequestSize')
  const toast = new bootstrap.Toast(toastLiveExample)
  toast.show()

  if ( $(this).hasClass( "unNotify" ) ) {
    $(this).removeClass("unNotify")
    $(this).html('<i class="fa-solid fa-bell-slash text-success" aria-hidden="true"></i>');
  }
  if ( $(this).hasClass( "notify" ) ) {
    $(this).addClass("unNotify")
    $(this).html('<i class="fa-regular fa-bell" aria-hidden="true"></i>');
  }
  $(this).toggleClass("notify");
});
