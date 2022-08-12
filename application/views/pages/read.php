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
                  <h3 class="mb-5 text-success">News >> <?php echo $rowpages->judulpage ?></h3>
                </div>


            </div>
            <div class="row">

              

                <div class="col-md-12">
                  <div class="row">

                    <?php  
                      if (!empty($rowpages->gambarsampul)) {
                            $gambarsampul = base_url('uploads/pages/'.$rowpages->gambarsampul);
                          }else{
                            $gambarsampul = base_url('images/nofoto.png');
                          }
                    ?>


                    <div class="col-12 mb-3">
                      <div class="card">
                        <div class="card-body">
                          <div class="row">
                            <div class="col-md-12 text-center">
                              <img src="<?php echo $gambarsampul ?>" alt="" style="width: 60%;">
                            </div>
                            <div class="col-md-12 mt-5">
                              <h3><?php echo $rowpages->judulpage ?></h3>                              
                              <small>Created by: <?php echo $rowpages->namapengguna ?> at <?php echo date('M d, Y', strtotime($rowpages->tglinsert)) ?></small>
                              <p class="mt-3"><?php echo $rowpages->isipage ?></p>
                            </div>
                          </div>
                        </div>
                      </div>
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

  </body>
</html>