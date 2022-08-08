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
                  <h3 class="mb-5 text-success">News</h3>
                </div>


            </div>
            <div class="row">

                <div class="col-md-4">
                  <h3>Most Viewed</h3>
                  <div class="row">

                    


                    <?php  
                      if ($rsnewsmostviewed->num_rows()>0) {
                        foreach ($rsnewsmostviewed->result() as $row) {

                          if (!empty($row->gambarsampul)) {
                            $gambarsampul = base_url('uploads/news/'.$row->gambarsampul);
                          }else{
                            $gambarsampul = base_url('images/nofoto.png');
                          }


                          echo '
                              <div class="col-12 p-3">

                                    <div class="row">
                                        <div class="col-md-4">
                                          <img src="'.$gambarsampul.'" alt="" style="width: 80%;">
                                        </div>
                                        <div class="col-md-8">
                                          <a href="'.site_url('news/read/'.$row->judulnewsseo).'">'.$row->judulnews.'</a>
                                        </div>
                                    </div>

                              </div>
                          ';
                        }
                      }
                    ?>
                  </div>
                </div>

                <div class="col-md-8">
                  <div class="row">

                    <?php  
                        // echo "select * from v_news where ispublish = 'Ya' order by tglinsert desc";
                      if ($rsnews->num_rows()>0) {
                        foreach ($rsnews->result() as $row) {
                          if (!empty($row->gambarsampul)) {
                            $gambarsampul = base_url('uploads/news/'.$row->gambarsampul);
                          }else{
                            $gambarsampul = base_url('images/nofoto.png');
                          }

                          $tampungisi = strip_tags($row->isinews);

                          if (strlen($tampungisi)>255) {
                            $isinews = substr($tampungisi, 0,255);
                          }else{
                            $isinews = $tampungisi;
                          }

                          $countviews = $row->countviews;
                          if (empty($countviews)) {
                            $countviews =0;
                          }

                          echo '

                              <div class="col-12 mb-3">
                                <div class="card">
                                  <div class="card-body">
                                    <div class="row">
                                      <div class="col-md-4">
                                        <img src="'.$gambarsampul.'" alt="" style="width: 80%;">
                                      </div>
                                      <div class="col-md-8">
                                        <a href="'.site_url('news/read/'.$row->judulnewsseo).'"><h3 class="text-success">'.$row->judulnews.'</h3></a>
                                        <small>Created by: '.$row->namapengguna.' at '.date('M d, Y', strtotime($row->tglinsert)).' <span class="fa fa-eye"></span> '.$countviews.'</small>
                                        <p class="mt-3">'.$isinews.'</p>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>

                          ';
                        }
                      }
                    ?>

                    



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