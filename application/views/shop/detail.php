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




    <!-- Product Details Section Begin -->
    <section class="product-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__pic">
                        <div class="product__details__pic__item">
                            <?php
if ($rowproduk->gambarproduk != '') {
    $gambarproduk = base_url('uploads/produk/' . $rowproduk->gambarproduk);
} else {
    $gambarproduk = base_url('images/nofoto.png');
}
?>
                            <img class="product__details__pic__item--large"
                                src="<?php echo $gambarproduk ?>" alt="">
                        </div>
                        <div class="product__details__pic__slider owl-carousel">
                            <?php
$rsprodukimage = $this->db->query("select * from produkimage where idproduk='.$rowproduk->idproduk.' order by idprodukimage");
if ($rsprodukimage->num_rows() > 0) {
    foreach ($rsprodukimage->result() as $row) {
        $produkimage = base_url('uploads/produkdetail/' . $row->gambarproduk);

        echo '
                                    <img data-imgbigurl="' . $produkimage . '" src="' . $produkimage . '" alt="">
                                  ';
    }
}
?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                  <form action="<?php echo site_url('shop/add_to_cart') ?>" method="post">
                    <input type="hidden" name="idproduk" id="idproduk" value="<?php echo $rowproduk->idproduk ?>">


                    <div class="product__details__text">
                        <h3><?php echo $rowproduk->namaproduk ?></h3>
                        <div class="product__details__rating mb-3">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-half-o"></i>
                            <span>(18 reviews)</span>
                        </div>
                        <?php
$rshargaproduk = $this->db->query("select * from produkharga where idproduk='$rowproduk->idproduk' order by berat");
if ($rshargaproduk->num_rows() > 0) {
    $i = 0;
    foreach ($rshargaproduk->result() as $row) {
        $i++;
        $checked = '';
        if ($i == 1) {
            $checked = "checked";
        }

        $hargasebelumdiskon = '';
        if ($row->harga != 0 and $row->harga < $row->hargasebelumdiskon) {
          $hargasebelumdiskon = '<span class="text-danger"><del>'.format_decimal($row->hargasebelumdiskon, 2).'</del></span>';
        }
        echo '

                                <div class="form-check mb-3 text-lg ">
                                  <input class="form-check-input" type="radio" name="idprodukharga[]" id="idprodukharga' . $row->idprodukharga . '" value="' . $row->idprodukharga . '" ' . $checked . '>
                                  <label class="form-check-label" for="idprodukharga' . $row->idprodukharga . '">
                                    <strong>' . format_decimal($row->berat, 2) . ' Kg = '.$hargasebelumdiskon.' $' . format_decimal($row->harga, 2) . '</strong>
                                  </label>
                                </div>
                              ';
    }
} else {
    echo '
                                <div class="product__details__price">Sorry, this product is not available</div>
                              ';
}
?>
                        <!-- <div class="product__details__price">$50.00</div> -->
                        <p class="mt-4"><?php echo $rowproduk->deskripsiproduk ?></p>
                        <div class="product__details__batchnumber">
                            

                            <?php  
                                $i =0;
                                $rsbatch = $this->db->query("select * from produkbatchnumber where idproduk='".$rowproduk->idproduk."' order by nomorbatch asc");
                                foreach ($rsbatch->result() as $rowbatch) {
                                    
                                    $i++;
                                    $checked = '';
                                    if ($i == 1) {
                                        $checked = "checked";
                                    }

                                    echo '

                                        <div class="form-check mb-3 text-lg ">
                                          <input class="form-check-input" type="radio" name="idprodukbatchnumber[]" id="idprodukbatchnumber' . $rowbatch->idprodukbatchnumber . '" value="' . $rowbatch->idprodukbatchnumber . '" ' . $checked . '>
                                          <label class="form-check-label" for="idprodukbatchnumber' . $rowbatch->idprodukbatchnumber . '">
                                            <strong>
                                                <a href="'.base_url('uploads/batchnumber/'.$rowbatch->filebatch).'" target="_blank">'.$rowbatch->nomorbatch.'</a>
                                                <br>
                                                <span>'.$rowbatch->deskripsi.'</span>
                                            </strong>
                                          </label>
                                        </div>
                                      ';

                                }

                            ?>
                        </div>
                        <div class="product__details__quantity">
                            <div class="quantity">
                                <div class="pro-qty">
                                    <input type="text" name="qty" id="qty" value="1">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="primary-btn">ADD TO CARD</button>
                        <ul>
                            <li><b>Availability</b> <span>In Stock</span></li>
                            <!-- <li><b>Shipping</b> <span>01 day shipping. <samp>Free pickup today</samp></span></li> -->
                            <li><b>Category</b> <span><?php echo $rowproduk->namajenis ?></span></li>
                            <!-- <li><b>Share on</b>
                                <div class="share">
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                    <a href="#"><i class="fa fa-instagram"></i></a>
                                    <a href="#"><i class="fa fa-pinterest"></i></a>
                                </div>
                            </li> -->
                        </ul>
                    </div>

                  </form>



                </div>



            </div>
        </div>
    </section>
    <!-- Product Details Section End -->



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