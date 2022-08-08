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
                  <h3 class="mb-5 text-success">My Account Information</h3>
                </div>


            </div>
            <div class="row">

              <div class="col-12">
                <div class="card">
                  <div class="card-body">
                    <form action="<?php echo site_url('myaccount/saveinformation') ?>" method="post" id="form">
                      
                      <div class="row">

                        <div class="col-md-6">                        
                          <div class="form-group">
                            <label for="">Full Name</label>
                            <input type="text" name="namakonsumen" id="namakonsumen" class="form-control" placeholder="Full Name" value="<?php echo $rowkonsumen->namakonsumen ?>">
                          </div>
                        </div>
                        <div class="col-md-6">                        
                          <div class="form-group">
                            <label for="">Gender</label>
                            <select name="gender" id="gender" class="form-control">
                              <option value="">Gender...</option>
                              <option value="Laki-laki" <?php echo ($rowkonsumen->jk=='Laki-laki') ? 'selected="selected"' : '' ?> >Male</option>
                              <option value="Perempuan" <?php echo ($rowkonsumen->jk=='Perempuan') ? 'selected="selected"' : '' ?>>Female</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">                        
                          <div class="form-group">
                            <label for="">Address</label>
                            <input type="text" name="alamatpengiriman" id="alamatpengiriman" class="form-control" placeholder="Address" value="<?php echo $rowkonsumen->alamatpengiriman ?>">
                          </div>
                        </div>
                        <div class="col-md-6">                        
                          <div class="form-group">
                            <label for="">Country</label>
                            <input type="text" name="negara" id="negara" class="form-control" placeholder="Country" value="<?php echo $rowkonsumen->negara ?>">
                          </div>
                        </div>
                        <div class="col-md-6">                        
                          <div class="form-group">
                            <label for="">Province</label>
                            <input type="text" name="propinsi" id="propinsi" class="form-control" placeholder="Province" value="<?php echo $rowkonsumen->propinsi ?>">
                          </div>
                        </div>
                        <div class="col-md-6">                        
                          <div class="form-group">
                            <label for="">City</label>
                            <input type="text" name="kota" id="kota" class="form-control" placeholder="City" value="<?php echo $rowkonsumen->kota ?>">
                          </div>
                        </div>
                        <div class="col-md-6">                        
                          <div class="form-group">
                            <label for="">Village</label>
                            <input type="text" name="desa" id="desa" class="form-control" placeholder="Village" value="<?php echo $rowkonsumen->desa ?>">
                          </div>
                        </div>
                        <div class="col-md-6">                        
                          <div class="form-group">
                            <label for="">Phone Number</label>
                            <input type="text" name="notelp" id="notelp" class="form-control" placeholder="+60 8282891901" value="<?php echo $rowkonsumen->notelp ?>">
                          </div>
                        </div>
                        <div class="col-md-6">                        
                          <div class="form-group">
                            <label for="">WhattsApp Number</label>
                            <input type="text" name="nowa" id="nowa" class="form-control" placeholder="WhatsApp Number" value="<?php echo $rowkonsumen->nowa ?>">
                          </div>
                        </div>
                        <div class="col-md-6">                        
                          <div class="form-group">
                            <label for="">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Email" value="<?php echo $rowkonsumen->email ?>" disabled>
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
          namakonsumen: {
            validators:{
              notEmpty: {
                  message: "Full name cannot be empty"
              },
            }
          },
          gender: {
            validators:{
              notEmpty: {
                  message: "Gender cannot be empty"
              },
            }
          },
          email: {
            validators:{
              notEmpty: {
                  message: "email cannot be empty"
              },
            }
          },
          notelp: {
            validators:{
              notEmpty: {
                  message: "Phone Number cannot be empty"
              },
            }
          },
        }
      });



    });
    </script>
  </body>
</html>