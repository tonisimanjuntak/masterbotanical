<!DOCTYPE html>
<html lang="en">
  <head>

<!--
    <link rel="stylesheet" href="<?php echo base_url('assets/ogani-master/') ?>css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url('assets/ogani-master/') ?>css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url('assets/ogani-master/') ?>css/elegant-icons.css" type="text/css">
 -->

    <link rel="stylesheet" href="<?php echo base_url('assets/ogani-master/') ?>css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url('assets/ogani-master/') ?>css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url('assets/ogani-master/') ?>css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url('assets/ogani-master/') ?>css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url('assets/ogani-master/') ?>css/style.css" type="text/css">

    <?php $this->load->view('template/petsitting-master/header');?>

  </head>
  <body>

    <?php $this->load->view('template/petsitting-master/top-sosmed');?>

    <?php $this->load->view('template/petsitting-master/top-menu');?>




    <!-- Shoping Cart Section Begin -->
    <section class="product-details spad">
        <div class="container">
            <div class="row">
                <div class="col-12">
                  <h3 class="mb-5 text-success">Change Password</h3>
                </div>


            </div>
            <div class="row">

              <div class="col-12">
                <div class="card">
                  <div class="card-body">
                    <form action="<?php echo site_url('myaccount/savechangepassword') ?>" method="post" id="form">
                      
                      <div class="row">

                        <div class="col-md-12">                        
                          <div class="form-group">
                            <label for="">Old Password</label>
                            <input type="password" name="oldpassword" id="oldpassword" class="form-control" placeholder="************">
                          </div>
                        </div>

                        <div class="col-md-12">                        
                          <div class="form-group">
                            <label for="">New Password</label>
                            <input type="password" name="newpassword" id="newpassword" class="form-control" placeholder="************">
                          </div>
                        </div>

                        <div class="col-md-12">                        
                          <div class="form-group">
                            <label for="">Repeat New Password</label>
                            <input type="password" name="newpassword2" id="newpassword2" class="form-control" placeholder="************">
                          </div>
                        </div>

                        <div class="col-12 mt-5">
                          <button type="submit" class="btn btn-success btn-sm float-right">Save Information</button>
                        </div>
                      </div>


                    </form>




                  </div>
                </div>
              </div>
                


                


            </div>
        </div>
    </section>
    <!-- Shoping Cart Section End -->



    <script src="<?php echo base_url('assets/ogani-master/') ?>js/jquery-3.3.1.min.js"></script>
    <script src="<?php echo base_url('assets/ogani-master/') ?>js/jquery.slicknav.js"></script>
    <script src="<?php echo base_url('assets/ogani-master/') ?>js/jquery.nice-select.min.js"></script>
    <script src="<?php echo base_url('assets/ogani-master/') ?>js/jquery-ui.min.js"></script>

<!--
    <script src="<?php echo base_url('assets/ogani-master/') ?>js/mixitup.min.js"></script>
    <script src="<?php echo base_url('assets/ogani-master/') ?>js/bootstrap.min.js"></script>
 -->

    <script src="<?php echo base_url('assets/ogani-master/') ?>js/owl.carousel.min.js"></script>
    <script src="<?php echo base_url('assets/ogani-master/') ?>js/main.js"></script>

    <?php $this->load->view('template/petsitting-master/footer');?>


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
          oldpassword: {
            validators:{
              notEmpty: {
                  message: "Old password cannot be empty"
              },
            }
          },
          newpassword: {
            validators:{
              notEmpty: {
                  message: "New password cannot be empty"
              },
            }
          },
          newpassword2: {
            validators:{
              notEmpty: {
                  message: "Repeat new password cannot be empty"
              },
            }
          },
        }
      });



    });
    </script>
  </body>
</html>