var btnLogin = $("#btnLogin");
var btnRegister = $("#btnRegister");

btnLogin.click(function(){
if(!($(this).hasClass("collapsed"))){
    $(this).hide()
    btnRegister.show()
}
});

btnRegister.click(function(){
if(!($(this).hasClass("collapsed"))){
    $(this).hide()
    btnLogin.show()
}
});

// show login when another link's page
var login = localStorage.getItem("login");
if (login == "true") {
  btnLogin.click();
  localStorage.removeItem("login");
}

// show register when another link's page
var register = localStorage.getItem("register");
if (register == "true") {
  btnRegister.click();
  localStorage.removeItem("register");
}

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

// validation form
var spinner = $('#loader');
(() => {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  const forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()

      }
      // show spinner when validation form
      if (form.checkValidity()) {
      console.log("validation");
      spinner.show();
      }

      form.classList.add('was-validated')
    }, false)
  })
})()

// forgeten pass
var boxLogin = $(".boxLogin");
var boxForgetPass = $(".boxForgetPass");
var loginTitle = $(".loginTitle");
var boxForgetPass = $(".boxForgetPass");

$(".btnForgetPass").click(function(){
boxLogin.hide();
loginTitle.hide();
boxForgetPass.show();
});

$(".btnBackLogin").click(function(){
    boxLogin.show();
    loginTitle.show();
    boxForgetPass.hide();
    });