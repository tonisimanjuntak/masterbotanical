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
    <section class="shoping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-12">
                  <h3 class="mb-5 text-success">Shopping Chart</h3>
                </div>
                <div class="col-lg-12">
                    <div class="shoping__cart__table">
                        <table>
                            <thead>
                                <tr>
                                    <th class="">Products</th>
                                    <th style="text-align: center;">Weight</th>
                                    <th style="text-align: center;">Price</th>
                                    <th style="text-align: center;">Quantity</th>
                                    <th style="text-align: center;">Total</th>
                                    <th style="text-align: right;">Action</th>
                                </tr>
                            </thead>
                            <tbody>


                                <?php

$totalhargabarang = 0;
if (count($this->cart->contents()) > 0) {
    foreach ($this->cart->contents() as $items) {

        if (!empty($items['foto'])) {
            $foto = base_url('uploads/produk/' . $items['foto']);
        } else {
            $foto = base_url('images/nofoto.png');
        }

        echo '
                                            <tr>
                                                <td class="shoping__cart__item">
                                                    <img src="' . $foto . '" alt="" style="height:80px; width:100px;">
                                                    <h5>' . $items["name"] . '<br><span>Batchnumber: ' . $items["nomorbatch"] . '</span></h5>
                                                    
                                                </td>
                                                <td class="shoping__cart__price">
                                                    ' . $items["berat"] . ' Kg
                                                </td>
                                                <td class="shoping__cart__price">
                                                    $' . format_decimal($items["hargajual"], 2) . '
                                                </td>
                                                <td class="shoping__cart__price">
                                                    ' . $items["qty"] . '
                                                </td>
                                                <td class="shoping__cart__total">
                                                    $' . format_decimal($items["subtotal"], 2) . '
                                                </td>
                                                <td class="shoping__cart__item__close">
                                                    <span class="icon_close"></span>
                                                </td>
                                                <td class="shoping__cart__price">
                                                    <a href="' . site_url('chart/removeitem/' . $items['rowid']) . '" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                                </td>
                                            </tr>

                                          ';

        $totalhargabarang += $items["subtotal"];

    }
} else {
    echo '
                                          <tr style="height: 80px;">
                                            <td colspan="5" style="text-align: center;"><h4 class="mb-3">Your shopping cart is empty...</h4> <a href="' . site_url('shop') . '" class="btn btn-sm btn-outline-success">Buy a Product</a> OR <a href="' . site_url() . '" class="btn btn-sm btn-outline-success">Back to Home</a></td>
                                          </tr>
                                        ';
}

?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__btns">
                        <a href="<?php echo site_url('shop') ?>" class="primary-btn cart-btn">CONTINUE SHOPPING</a>
                        <!-- <a href="#" class="primary-btn cart-btn cart-btn-right"><span class="icon_loading"></span>
                            Upadate Cart</a> -->
                    </div>
                </div>
                <div class="col-lg-6">
                    <!-- <div class="shoping__continue">
                        <div class="shoping__discount">
                            <h5>Discount Codes</h5>
                            <form action="#">
                                <input type="text" placeholder="Enter your coupon code">
                                <button type="submit" class="site-btn">APPLY COUPON</button>
                            </form>
                        </div>
                    </div> -->
                </div>
                <div class="col-lg-6">
                    <div class="shoping__checkout">
                        <h5>Cart Total</h5>
                        <ul>
                            <li>Subtotal <span>$<?php echo format_decimal($totalhargabarang, 2) ?></span></li>
                            <!-- <li>Total <span>$454.98</span></li> -->
                        </ul>
                        <a href="<?php echo site_url('chart/checkout/') ?>" class="primary-btn">PROCEED TO CHECKOUT</a>
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