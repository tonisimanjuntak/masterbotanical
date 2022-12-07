<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo $this->session->userdata('logo') ?>" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo base_url('assets/login-form-08/') ?>fonts/icomoon/style.css">

    <link rel="stylesheet" href="<?php echo base_url('assets/login-form-08/') ?>css/owl.carousel.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/login-form-08/') ?>css/bootstrap.min.css">

    <!-- Style -->
    <link rel="stylesheet" href="<?php echo base_url('assets/login-form-08/') ?>css/style.css">

    <style>
      .has-error .help-block {
        color: red;
      }
    </style>
    <title>Create Account Master Botanical</title>
  </head>
  <body>



  <div class="content">
    <div class="container">
      <div class="row">
        <div class="col-md-6 order-md-2">
          <img src="<?php echo base_url('assets/login-form-08/') ?>images/undraw_file_sync_ot38.svg" alt="Image" class="img-fluid">
        </div>
        <div class="col-md-6 contents">
          <div class="row justify-content-center">
            <div class="col-md-8">
              <div class="mb-4">
              <h5>Create Account <strong><a href="<?php echo site_url() ?>">Master Botanical</a></strong></h5>
              <p class="mb-4">Please complete your personal data.</p>
            </div>
            <form action="<?php echo site_url('login/simpanaccountbaru') ?>" method="post" id="form">
              <div class="form-group first">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email">
              </div>
              <div class="form-group first">
                <label for="namakonsumen">Name</label>
                <input type="text" class="form-control" id="namakonsumen" name="namakonsumen">
              </div>
              <div class="form-group last mb-4">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password">
              </div>
              <div class="form-group last mb-4">
                <label for="password">Repeat Password</label>
                <input type="password" class="form-control" id="password2" name="password2">
              </div>

              
              <input type="submit" value="Create Account" class="btn text-white btn-block btn-primary">

              <span class="d-block text-left my-4 text-muted"> or <a href="<?php echo site_url('login') ?>">Login Here</a></span>

              <!-- <div class="social-login">
                <a href="#" class="facebook">
                  <span class="icon-facebook mr-3"></span>
                </a>
                <a href="#" class="twitter">
                  <span class="icon-twitter mr-3"></span>
                </a>
                <a href="#" class="google">
                  <span class="icon-google mr-3"></span>
                </a>
              </div> -->


            </form>
            </div>
          </div>

        </div>

      </div>
    </div>
  </div>


    <script src="<?php echo base_url('assets/login-form-08/') ?>js/jquery-3.3.1.min.js"></script>
    <script src="<?php echo base_url('assets/login-form-08/') ?>js/popper.min.js"></script>
    <script src="<?php echo base_url('assets/login-form-08/') ?>js/bootstrap.min.js"></script>
    <script src="<?php echo base_url('assets/login-form-08/') ?>js/main.js"></script>

    <script src="<?php echo (base_url('assets/')) ?>sweetalert/sweetalert.min.js"></script>

    <script src="<?php echo(base_url('admin/assets/')) ?>bootstrap-validator/js/bootstrapValidator.js"></script>


    <script>
      
    $(document).ready(function() {

        //----------------------------------------------------------------- > validasi
        $("#form").bootstrapValidator({
          feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
          },
          fields: {
            email: {
              validators:{
                notEmpty: {
                    message: "email cannot be empty"
                },
              }
            },
            namakonsumen: {
              validators:{
                notEmpty: {
                    message: "name cannot be empty"
                },
              }
            },
            password: {
              validators:{
                notEmpty: {
                    message: "password cannot be empty"
                },
              }
            },
            password2: {
              validators:{
                notEmpty: {
                    message: "repeat password cannot be empty"
                },
              }
            },
          }
        });
      //------------------------------------------------------------------------> END VALIDASI DAN SIMPAN


    });


    </script>

<?php
$pesan = $this->session->flashdata("pesan");
if (!empty($pesan)) {
    echo $pesan;
}
?>

  </body>
</html>