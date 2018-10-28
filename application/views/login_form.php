

<div class="card card-login mx-auto mt-5">
    <div class="card-header">

        <center><img src="<?php echo base_url(); ?>assets/img/radix-logo.png"></center>
    </div>
    <div class="card-body">
        <!--<form class="container" action="./User_Authentication/login" method="post" id="needs-validation" novalidate>-->
        <?php echo form_open('User_Authentication/login'); ?>
        <?php if (isset($msg)): ?>
            <div class="alert alert-danger" role="alert">
                Invalid login! Please try again.
            </div>

        <?php endif; ?>

        <div class="form-group">


            <div class="input-group mb-2 mb-sm-0">
                <div class="input-group-prepend"><span class="input-group-text fa fa-user"></span></div>
                <input type="input" class="form-control" id="InputUsername" aria-describedby="UsernameHelp" placeholder="Username" name="username" required>
            </div>

            <div class="invalid-feedback">
                Username field is required
            </div>
        </div>
        <div class="form-group">
            <div class="input-group mb-2 mb-sm-0">
                <div class="input-group-prepend"><span class="input-group-text fa fa-lock"></span></div>
                <input type="password" class="form-control" id="InputPassword" placeholder="Password" name="password" required>
            </div>

            <div class="invalid-feedback">
                Password field is required
            </div>
        </div>

        <!--<a class="btn btn-primary btn-block" value="">Login</a>-->
        <input type="submit" name="submit" value="Login" class="btn btn-dark btn-block">
        <?php echo form_close(); ?> 


    </div>
</div>
<div class="text-center">
    <small style="color: white;">Copyright &copy; 2018 IBM - Security Operations Center</small>
</div>

<!--<script>
// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
  "use strict";
  window.addEventListener("load", function() {
    var form = document.getElementById("needs-validation");
    form.addEventListener("submit", function(event) {
      if (form.checkValidity() == false) {
        event.preventDefault();
        event.stopPropagation();
      }
      form.classList.add("was-validated");
    }, false);
  }, false);
}());
</script>-->

