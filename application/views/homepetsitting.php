<!DOCTYPE html>
<html lang="en">
  <head>
    <?php $this->load->view('template/petsitting-master/header');?>

  </head>
  <body>

    <?php $this->load->view('template/petsitting-master/top-sosmed');?>

    <?php $this->load->view('template/petsitting-master/top-menu');?>

    <?php $this->load->view('template/petsitting-master/carousel');?>









    <section class="ftco-section bg-light ftco-no-pt ftco-intro mt-5">
      <div class="container">
        <div class="row">


          <div class="col-md-4 d-flex align-self-stretch px-4 ftco-animate">
            <div class="d-block services text-center bg-success text-light">
              <div class="icon d-flex align-items-center justify-content-center">
                <span class="fa <?php echo $rowtabinfo->tab1icon ?>"></span>
              </div>
              <div class="media-body">
                <h3 class="heading"><?php echo $rowtabinfo->tab1judul ?></h3>
                <p><?php echo $rowtabinfo->tab1deskripsi ?></p>
                <a href="#" class="btn-custom d-flex align-items-center justify-content-center"><span class="fa fa-chevron-right"></span><i class="sr-only">Read more</i></a>
              </div>
            </div>
          </div>

          <div class="col-md-4 d-flex align-self-stretch px-4 ftco-animate">
            <div class="d-block services text-center bg-success text-light">
              <div class="icon d-flex align-items-center justify-content-center">
                <span class="fa <?php echo $rowtabinfo->tab2icon ?>"></span>
              </div>
              <div class="media-body">
                <h3 class="heading"><?php echo $rowtabinfo->tab2judul ?></h3>
                <p><?php echo $rowtabinfo->tab2deskripsi ?></p>
                <?php  
                  if (!empty($rowtabinfo->judulpageseo1)) {
                    echo '
                      <a href="'.site_url('pages/read/'.$rowtabinfo->judulpageseo1).'" class="btn-custom d-flex align-items-center justify-content-center"><span class="fa fa-chevron-right"></span><i class="sr-only">Read more</i></a>
                    ';
                  }else{
                    echo '
                      <a href="#" class="btn-custom d-flex align-items-center justify-content-center"><span class="fa fa-chevron-right"></span><i class="sr-only">Read more</i></a>
                    ';
                  }
                ?>
              </div>
            </div>
          </div>

          <div class="col-md-4 d-flex align-self-stretch px-4 ftco-animate">
            <div class="d-block services text-center bg-success text-light">
              <div class="icon d-flex align-items-center justify-content-center">
                <span class="fa <?php echo $rowtabinfo->tab3icon ?>"></span>
              </div>
              <div class="media-body">
                <h3 class="heading"><?php echo $rowtabinfo->tab3judul ?></h3>
                <p><?php echo $rowtabinfo->tab3deskripsi ?></p>
                <a href="#" class="btn-custom d-flex align-items-center justify-content-center"><span class="fa fa-chevron-right"></span><i class="sr-only">Read more</i></a>
              </div>
            </div>
          </div>


        </div>
      </div>
    </section>

    <section class="ftco-section ftco-no-pt ftco-no-pb">
      <div class="container">
        <div class="row d-flex no-gutters">
          <div class="col-md-5 d-flex">
            <div class="img img-video d-flex align-self-stretch align-items-center justify-content-center justify-content-md-center mb-4 mb-sm-0" style="background-image:url(<?php echo (empty($rowwhychooseus->gambarsampul)) ? base_url('images/nofoto.png') : base_url('uploads/whychooseus/' . $rowwhychooseus->gambarsampul); ?>);">
            </div>
          </div>
          <div class="col-md-7 pl-md-5 py-md-5">
            <?php echo $rowwhychooseus->deskripsi ?>
          </div>
        </div>
      </div>
    </section>

    <section class="ftco-counter" id="section-counter">
      <div class="container">
        <div class="row">

          <div class="col-md-4 col-lg-4 d-flex justify-content-center counter-wrap ftco-animate">
            <div class="block-18 text-center">
              <div class="text">
                <strong class="number" data-number="<?php echo $jlhcostumer ?>">0</strong>
              </div>
              <div class="text">
                <span>Customer</span>
              </div>
            </div>
          </div>

          <div class="col-md-4 col-lg-4 d-flex justify-content-center counter-wrap ftco-animate">
            <div class="block-18 text-center">
              <div class="text">
                <strong class="number" data-number="<?php echo $jlhproduk ?>">0</strong>
              </div>
              <div class="text">
                <span>Products</span>
              </div>
            </div>
          </div>

          <div class="col-md-4 col-lg-4 d-flex justify-content-center counter-wrap ftco-animate">
            <div class="block-18 text-center">
              <div class="text">
                <strong class="number" data-number="<?php echo $jlhtotalsale ?>">0</strong>
              </div>
              <div class="text">
                <span>Total Sale (Kg)</span>
              </div>
            </div>
          </div>
          
        </div>
      </div>
    </section>

    <section class="ftco-section bg-light ftco-faqs">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 order-md-last">
            <?php  
              $rowvideo = $this->db->query("select * from utilvideo")->row();
              $urlvideo = $rowvideo->urlvideo;
              if (!empty($rowvideo->sampulvideo)) {
                $sampulvideo = base_url('uploads/video/'.$rowvideo->sampulvideo);                
              }else{
                $sampulvideo = base_url('images/youtube.jpg');                                
              }
            ?>
            <div class="img img-video d-flex align-self-stretch align-items-center justify-content-center justify-content-md-center mb-4 mb-sm-0" style="background-image:url(<?php echo $sampulvideo ?>);">
              <a href="<?php echo $urlvideo ?>" class="icon-video popup-vimeo d-flex justify-content-center align-items-center">
                <span class="fa fa-play"></span>
              </a>
            </div>
            
          </div>

          <div class="col-lg-6">
            <div class="heading-section mb-5 mt-5 mt-lg-0">
              <h2 class="mb-3">Frequently Asks Questions</h2>
              <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
            </div>
            <div id="accordion" class="myaccordion w-100" aria-multiselectable="true">


              <?php
if ($rsfaq->num_rows() > 0) {
    $i = 0;
    foreach ($rsfaq->result() as $row) {
        $i++;
        if ($i == 1) {

            echo '
                          <div class="card">
                              <div class="card-header p-0" id="heading' . $row->idfaq . '">
                                <h2 class="mb-0">
                                  <button href="#collapse' . $row->idfaq . '" class="d-flex py-3 px-4 align-items-center justify-content-between btn btn-link" data-parent="#accordion" data-toggle="collapse" aria-expanded="true" aria-controls="collapse' . $row->idfaq . '">
                                    <p class="mb-0">' . $row->pertanyaan . '</p>
                                    <i class="fa" aria-hidden="true"></i>
                                  </button>
                                </h2>
                              </div>
                              <div class="collapse show" id="collapse' . $row->idfaq . '" role="tabpanel" aria-labelledby="heading' . $row->idfaq . '">
                                <div class="card-body py-3 px-0">
                                  ' . $row->jawaban . '
                                </div>
                              </div>
                            </div>
                        ';
        } else {
            echo '
                        <div class="card">
                          <div class="card-header p-0" id="heading' . $row->idfaq . '" role="tab">
                            <h2 class="mb-0">
                              <button href="#collapse' . $row->idfaq . '" class="d-flex py-3 px-4 align-items-center justify-content-between btn btn-link" data-parent="#accordion" data-toggle="collapse" aria-expanded="false" aria-controls="collapse' . $row->idfaq . '">
                                <p class="mb-0">' . $row->pertanyaan . '</p>
                                <i class="fa" aria-hidden="true"></i>
                              </button>
                            </h2>
                          </div>
                          <div class="collapse" id="collapse' . $row->idfaq . '" role="tabpanel" aria-labelledby="heading' . $row->idfaq . '">
                            <div class="card-body py-3 px-0">
                              ' . $row->jawaban . '
                            </div>
                          </div>
                        </div>
                      ';
        }

    }
}
?>






            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="ftco-section testimony-section" style="background-image: url('<?php echo $bghappyclient ?>');">
      <div class="overlay"></div>
      <div class="container">
        <div class="row justify-content-center pb-5 mb-3">
          <div class="col-md-7 heading-section text-center ftco-animate">
            <h2>Happy Clients &amp; Feedbacks</h2>
          </div>
        </div>
        <div class="row ftco-animate">
          <div class="col-md-12">
            <div class="carousel-testimony owl-carousel ftco-owl">
              <?php
if ($rshappyclient->num_rows() > 0) {
    foreach ($rshappyclient->result() as $row) {
        echo '
                        <div class="item">
                          <div class="testimony-wrap py-4">
                            <div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-quote-left"></span></div>
                            <div class="text">
                              <p class="mb-4">' . $row->statement . '</p>
                              <div class="d-flex align-items-center">
                                <div class="user-img" style="background-image: url(uploads/happyclient/' . $row->fotoclient . ')"></div>
                                <div class="pl-3">
                                  <p class="name">' . $row->namaclient . '</p>
                                  <span class="position">' . $row->pekerjaan . '</span>
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

    <section class="ftco-section bg-light">
      <div class="container">
        <div class="row justify-content-center pb-5 mb-3">
          <div class="col-md-7 heading-section text-center ftco-animate">
            <h2>Best Seller</h2>
          </div>
        </div>
        <div class="row">

          <?php
if ($rsbestseller->num_rows() > 0) {
    $output = '';
    foreach ($rsbestseller->result() as $row) {
        if (!empty($row->gambarproduk)) {
            $gambarproduk = base_url('uploads/produk/' . $row->gambarproduk);
        } else {
            $gambarproduk = base_url('images/nofoto.png');
        }

        $img_discount = '';
        if ($row->is_discount==1) {
          $img_discount = '<img src="'.base_url('images/discount.png').'" alt="" style="width: 25%;">';
        }
        $output .= '
                    <div class="col-md-4 ftco-animate">
                        <div class="block-7">
                          <div class="img" style="background-image: url(' . $gambarproduk . ');">
                            '.$img_discount.'
                          </div>
                          <div class="text-center p-4">
                            <span class="excerpt d-block">' . $row->namaproduk . '</span>
                            <span class="price"><sup>$</sup> <span class="number">' . $row->lowestprice . '</span> <sub>/mos</sub></span>

                            <ul class="pricing-text mb-5">';

        $rsdetailharga = $this->db->query("select * from produkharga where idproduk='" . $row->idproduk . "' order by berat");
        if ($rsdetailharga->num_rows() > 0) {
            foreach ($rsdetailharga->result() as $rowdetail) {
                $hargasebelumdiskon ='';
                if ( ($rowdetail->harga!=$rowdetail->hargasebelumdiskon) && $rowdetail->hargasebelumdiskon !='0' ) {
                  $hargasebelumdiskon = '<span class="text-danger"><del>'.format_decimal($rowdetail->hargasebelumdiskon, 2).'</del></span>';
                }

                $output .= '
                          <li><span class="fa fa-check mr-2"></span>' . format_decimal($rowdetail->berat, 2) . ' Kg = '.$hargasebelumdiskon.' $' . format_decimal($rowdetail->harga, 2) . '</li>
                        ';
            }
        }

        $output .= '
                            </ul>

                            <a href="#" class="btn btn-primary d-block px-2 py-3">See Product</a>
                          </div>
                        </div>
                      </div>
                ';
    }

    echo $output;
}
?>


        </div>
      </div>
    </section>



    <section class="ftco-section bg-light">
      <div class="container">
        <div class="row justify-content-center pb-5 mb-3">
          <div class="col-md-7 heading-section text-center ftco-animate">
            <h2>Special Offer</h2>
            <!-- <a href="" class="text-info"><u>See ALL Special Offer</u></a> -->
          </div>
        </div>
        <div class="row">

          <?php
if ($rsspesialoffer->num_rows() > 0) {
    $output = '';
    foreach ($rsspesialoffer->result() as $row) {
        if (!empty($row->gambarproduk)) {
            $gambarproduk = base_url('uploads/produk/' . $row->gambarproduk);
        } else {
            $gambarproduk = base_url('images/nofoto.png');
        }

        $output .= '
                    <div class="col-md-4 ftco-animate">
                        <div class="block-7">
                          <div class="img" style="background-image: url(' . $gambarproduk . ');">
                            <img src="'.base_url('images/discount.png').'" alt="" style="width: 25%;">
                          </div>
                          <div class="text-center p-4">
                            <span class="excerpt d-block">' . $row->namaproduk . '</span>
                            <span class="price"><sup>$</sup> <span class="number">' . $row->lowestprice . '</span> <sub>/mos</sub></span>

                            <ul class="pricing-text mb-5">';

        $rsdetailharga = $this->db->query("select * from produkharga where idproduk='" . $row->idproduk . "' order by berat");
        if ($rsdetailharga->num_rows() > 0) {
            foreach ($rsdetailharga->result() as $rowdetail) {
                $hargasebelumdiskon ='';
                if ( ($rowdetail->harga!=$rowdetail->hargasebelumdiskon) && $rowdetail->hargasebelumdiskon !='0' ) {
                  $hargasebelumdiskon = '<span class="text-danger"><del>'.format_decimal($rowdetail->hargasebelumdiskon, 2).'</del></span>';
                }

                $output .= '
                          <li><span class="fa fa-check mr-2"></span>' . format_decimal($rowdetail->berat, 2) . ' Kg = '.$hargasebelumdiskon.' $' . format_decimal($rowdetail->harga, 2) . '</li>
                        ';
            }
        }

        $output .= '
                            </ul>

                            <a href="#" class="btn btn-primary d-block px-2 py-3">See Product</a>
                          </div>
                        </div>
                      </div>
                ';
    }

    echo $output;
}
?>


        </div>
      </div>
    </section>


    <section class="ftco-section">
      <div class="container">
        <div class="row justify-content-center pb-5 mb-3">
          <div class="col-md-7 heading-section text-center ftco-animate">
            <h2>Botanical Gallery</h2>
          </div>
        </div>
        <div class="row">

          <?php  
            $rsgallery = $this->db->query("select * from gallery where tampildifront='Ya' order by idgallery");
            if ($rsgallery->num_rows()>0) {
              foreach ($rsgallery->result() as $rowgallery) {
                echo '
                  <div class="col-md-4 ftco-animate">
                    <div class="work mb-4 img d-flex align-items-end" style="background-image: url(uploads/gallery/'.$rowgallery->filegallery.');">
                      <a href="'.base_url('uploads/gallery/'.$rowgallery->filegallery).'" class="icon image-popup d-flex justify-content-center align-items-center">
                        <span class="fa fa-expand"></span>
                      </a>
                      <div class="desc w-100 px-4">
                        <div class="text w-100 mb-3">
                          <h2>'.$rowgallery->judulgambar.'</h2>
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
    </section>



    <section class="ftco-section bg-light">
      <div class="container">
        <div class="row justify-content-center pb-5 mb-3">
          <div class="col-md-7 heading-section text-center ftco-animate">
            <h2>Latest news from our blog</h2>
          </div>
        </div>
        <div class="row d-flex">
          
          <?php  
              $rsnewslatest = $this->db->query("select * from v_news where ispublish='Ya' order by tglinsert desc limit 3");
              if ( $rsnewslatest->num_rows()>0 ) {
                foreach ($rsnewslatest->result() as $row) {
                  if (!empty($row->gambarsampul)) {
                    $gambarsampul = base_url('uploads/news/'.$row->gambarsampul);
                  }else{
                    $gambarsampul = 'images/nofoto.png';
                  }
                  $countviews = $row->countviews;
                  if (empty($countviews)) {
                    $countviews =0;
                  }

                  echo '
                        
                        <div class="col-md-4 d-flex ftco-animate">
                          <div class="blog-entry align-self-stretch">
                            <a href="blog-single.html" class="block-20 rounded" style="background-image: url('.$gambarsampul.');">
                            </a>
                            <div class="text p-4">
                              <div class="meta mb-2">
                                <div><a href="#">'.date('M d, Y', strtotime($row->tglinsert)).'</a></div>
                                <div><a href="#">'.$row->namapengguna.'</a></div>
                                <div><a href="#" class="meta-chat"><span class="fa fa-eye"></span> '.$countviews.'</a></div>
                              </div>
                              <h3 class="heading"><a href="#">'.$row->judulnews.'</a></h3>
                            </div>
                          </div>
                        </div>

                  ';
                }
              }
            ?>

          



        </div>
      </div>
    </section>

    <section class="ftco-appointment ftco-section ftco-no-pt ftco-no-pb img" style="background-image: url(<?php echo $logofreeconsultation; ?>);">
      <div class="overlay"></div>
      <div class="container">
        <div class="row d-md-flex justify-content-end">
          <div class="col-md-12 col-lg-6 half p-3 py-5 pl-lg-5 ftco-animate">
            <h2 class="mb-4">Free Consultation</h2>
            <form action="<?php echo site_url('HomePetsitting/simpanconsultation') ?>" class="appointment" method="post" id="formconsultation">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                        <input type="text" class="form-control" name="consulservice" id="consulservice" placeholder="What Service You Want to Consultation">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <input type="text" class="form-control" name="consulname" id="consulname" placeholder="Your Name">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <input type="email" class="form-control" name="consulemail" id="consulemail" placeholder="Your Email">
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <textarea name="consulmessage" id="consulmessage" cols="30" rows="7" class="form-control" placeholder="Message"></textarea>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <input type="submit" value="Send message" class="btn btn-primary py-3 px-4">
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>


    <?php $this->load->view('template/petsitting-master/footer');?>
    <!-- Bootstrap validator -->
    <script src="<?php echo (base_url("admin/assets/")) ?>bootstrap-validator/js/bootstrapValidator.js"></script>



<script type="text/javascript">
  
  $(document).ready(function() {

    //----------------------------------------------------------------- > validasi
    $("#formconsultation").bootstrapValidator({
      feedbackIcons: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
      },
      fields: {
        consulservice: {
          validators:{
            notEmpty: {
                message: "service can not empty"
            },
          }
        },
        consulname: {
          validators:{
            notEmpty: {
                message: "your name can not empty"
            },
          }
        },
        consulemail: {
          validators:{
            notEmpty: {
                message: "your email can not empty"
            },
          }
        },      
        consulmessage: {
          validators:{
            notEmpty: {
                message: "message can not empty"
            },
          }
        },
      }
    });

  }); //end (document).ready
  

</script>


  </body>
</html>