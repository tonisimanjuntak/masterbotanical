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




    <section class="ftco-counter bg-light" >
      <div class="container">
        <div class="row">
          <div class="col-md-3">
            <h3>Category</h3>


<ul class="list-group mt-4">

                <?php
$rsjenis = $this->db->query("select * from v_jenis_with_countproduk order by namajenis");
if ($rsjenis->num_rows() > 0) {
    $jumlahproduksemuaproduk = 0;
    foreach ($rsjenis->result() as $row) {
        $active    = '';
        $textColor = 'text-dark';
        if ($row->idjenis == $idjenis) {
            $active    = 'bg-success';
            $textColor = 'text-light';
        }

        echo '
                  <li class="list-group-item d-flex justify-content-between align-items-center '.$active.' ">
                    <a href="' . site_url('shop/filter/' . $this->encrypt->encode($row->idjenis)) . '/name' . '" class="'.$textColor.'">
                    ' . $row->namajenis . '
                  </a>
                    <span class="badge badge-primary badge-pill">' . $row->jumlahproduk . '</span>
                  </li>

                        ';
        $jumlahproduksemuaproduk += $row->jumlahproduk;
    }

    echo '
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="' . site_url('shop/filter/all/name') . '" class="list-group-item-action">
                    All Product
                  </a>
                    <span class="badge badge-primary badge-pill">' . $jumlahproduksemuaproduk . '</span>
                  </li>

                        ';
}
?>

</ul>

          </div>
          <div class="col-md-9">
            <div class="row">
              <div class="col-12">
                <div class="row">


                    
                  <div class="col-md-12">



                  <!-- sembunyikan section -->
                  <?php if (!$hidebestseller) { ?>
                    <div class="product__discount">
                        <div class="section-title product__discount__title">
                            <h2>Best Seller Product</h2>
                        </div>
                        <div class="row">
                            <div class="product__discount__slider owl-carousel">

                              <?php
$rsbestseller = $this->db->query("select * from v_utilbestseller order by namaproduk");
if ($rsbestseller->num_rows() > 0) {
    foreach ($rsbestseller->result() as $row) {

        if (!empty($row->gambarproduk)) {
            $gambarproduk = base_url('uploads/produk/' . $row->gambarproduk);
        } else {
            $gambarproduk = base_url('images/nofoto.png');
        }

        $img_discount = '';
        if ($row->is_discount==1) {
          $img_discount = '<img src="'.base_url('images/discount.png').'" alt="" style="width: 45%;">';
        }

        echo '
                                          <div class="col-lg-4">
                                            <div class="product__discount__item">
                                                <div class="product__discount__item__pic set-bg"
                                                    data-setbg="' . $gambarproduk . '">
                                                    '.$img_discount.'
                                                    <ul class="product__item__pic__hover">
                                                        <li><a href="' . site_url('shop/detail/' . $this->encrypt->encode($row->idproduk)) . '"><i class="fa fa-heart"></i></a></li>
                                                        <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                                    </ul>
                                                </div>
                                                <div class="product__discount__item__text">
                                                    <span>' . $row->namajenis . '</span>
                                                    <h5><a href="' . site_url('shop/detail/' . $this->encrypt->encode($row->idproduk)) . '">' . $row->namaproduk . '</a></h5>
                                                    <div class="product__item__price">$' . format_decimal($row->lowestprice, 2) . '</div>
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

                    <div class="product__discount">
                        <div class="section-title product__discount__title">
                            <h2>Special Offer</h2>
                        </div>
                        <div class="row">
                            <div class="product__discount__slider owl-carousel">

                              <?php
                              $rsspesialoffer   = $this->db->query("
                                select * from v_spesialoffer
                                ");


if ($rsspesialoffer->num_rows() > 0) {
    foreach ($rsspesialoffer->result() as $rowspesialoffer) {

        if (!empty($rowspesialoffer->gambarproduk)) {
            $gambarproduk = base_url('uploads/produk/' . $rowspesialoffer->gambarproduk);
        } else {
            $gambarproduk = base_url('images/nofoto.png');
        }

        $img_discount = '<img src="'.base_url('images/discount.png').'" alt="" style="width: 45%;">';

        echo '
                                          <div class="col-lg-4">
                                            <div class="product__discount__item">
                                                <div class="product__discount__item__pic set-bg"
                                                    data-setbg="' . $gambarproduk . '">
                                                    '.$img_discount.'
                                                    <ul class="product__item__pic__hover">
                                                        <li><a href="' . site_url('shop/detail/' . $this->encrypt->encode($rowspesialoffer->idproduk)) . '"><i class="fa fa-heart"></i></a></li>
                                                        <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                                    </ul>
                                                </div>
                                                <div class="product__discount__item__text">
                                                    <span>' . $rowspesialoffer->namajenis . '</span>
                                                    <h5><a href="' . site_url('shop/detail/' . $this->encrypt->encode($rowspesialoffer->idproduk)) . '">' . $rowspesialoffer->namaproduk . '</a></h5>
                                                    <div class="product__item__price">$' . format_decimal($rowspesialoffer->lowestprice, 2) . '</div>
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
                    <?php } ?> 
                    <!-- end sembunyikan section -->


                    <div class="filter__item">
                        <div class="row">
                            <div class="col-lg-4 col-md-5">
                                <div class="filter__sort">
                                    <span>Sort By</span>
                                    <select name="idorderby" id="idorderby">
                                        <option value="name">Name</option>
                                        <option value="category">Category</option>
                                        <option value="price">Price</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="filter__found">
                                    <h6><span><?php echo $data->num_rows() ?></span> Products found</h6>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-3">
                                <div class="form-group row">
                                  
                                    <label for="" class="col-md-4">Search:</label>
                                    <div class="col-md-8">
                                      <form action="<?php echo site_url('shop/searchproduct') ?>" method="post" id="formsearch">
                                        <input type="text" name="search" id="search" class="" style="width: 100%;">                                        
                                      </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                      <?php
if ($data->num_rows() > 0) {
    foreach ($data->result() as $row) {
        if (!empty($row->gambarproduk)) {
            $gambarproduk = base_url('uploads/produk/' . $row->gambarproduk);
        } else {
            $gambarproduk = base_url('images/nofoto.png');
        }

        $img_discount = '';
        if ($row->is_discount==1) {
          $img_discount = '<img src="'.base_url('images/discount.png').'" alt="" style="width: 45%;">';
        }

        echo '
                                  <div class="col-lg-4 col-md-6 col-sm-6">
                                      <div class="product__item">
                                          <div class="product__item__pic set-bg" data-setbg="' . $gambarproduk . '">
                                          '.$img_discount.'
                                              <ul class="product__item__pic__hover">
                                                  <li><a href="' . site_url('shop/detail/' . $this->encrypt->encode($row->idproduk)) . '"><i class="fa fa-heart"></i></a></li>
                                                  <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                              </ul>
                                          </div>
                                          <div class="product__item__text">
                                              <span>' . $row->namajenis . '</span>
                                              <h6><a href="' . site_url('shop/detail/' . $this->encrypt->encode($row->idproduk)) . '">' . $row->namaproduk . '</a></h6>
                                              <h5>$' . format_decimal($row->lowestprice, 2) . '</h5>
                                          </div>
                                      </div>
                                  </div>
                              ';
    }
}
?>


                    </div>
                    <div class="row">
                      <div class="col-12">
                        <?php echo $pagination; ?>                        
                      </div>
                    </div>
                    <!-- <div class="product__pagination">

                        <a href="#">1</a>
                        <a href="#">2</a>
                        <a href="#">3</a>
                        <a href="#"><i class="fa fa-long-arrow-right"></i></a>
                    </div> -->
                </div>



                </div>
              </div>
            </div>
          </div>


        </div>
      </div>
    </section>



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
      var idjenis = "<?php echo $idjenis; ?>";
      var idjenisencrypt = "<?php echo $this->encrypt->encode($idjenis);  ?>";
      var varidorderby = "<?php echo $idorderby; ?>";

      $('#idorderby').change(function() {
        // varidorderby = $(this).val();

        console.log('test');

        // if (idjenis=='') {
        //   window.open("<?php echo site_url() ?>"+"/filter/all/"+varidorderby,"_self");
        // }else{
        //   window.open("<?php echo site_url() ?>"+"/filter/all/"+varidorderby,"_self");
        // }

      });


      
      $('#searchproduct').on('keypress',function(e) {
          if(e.which == 13) {
              e.preventDefault();
              alert('You pressed enter!');
              $('#formsearch').submit();
          }
      });




    </script>
  </body>
</html>