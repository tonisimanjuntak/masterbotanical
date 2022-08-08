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
                  <h3 class="mb-5 text-success">Checkout</h3>
                </div>


            </div>
            <div class="row">


                <div class="col-md-8">

                    <form action="<?php echo site_url('chart/submitcheckout') ?>" method="post">



                        <div class="col-12">
                            <h3>Shipping Information</h3>
                            <div class="form-group">
                                <label for="">Country</label>
                                <input type="text" name="negara" id="negara" class="form-control" placeholder="Country" value="<?php echo $rowkonsumen->negara ?>">
                            </div>
                            <div class="form-group">
                                <label for="">province</label>
                                <input type="text" name="propinsi" id="propinsi" class="form-control" placeholder="province" value="<?php echo $rowkonsumen->propinsi ?>">
                            </div>
                            <div class="form-group">
                                <label for="">City</label>
                                <input type="text" name="kota" id="kota" class="form-control" placeholder="City" value="<?php echo $rowkonsumen->kota ?>">
                            </div>
                            <div class="form-group">
                                <label for="">Village</label>
                                <input type="text" name="desa" id="desa" class="form-control" placeholder="Village" value="<?php echo $rowkonsumen->desa ?>">
                            </div>
                            <div class="form-group">
                                <label for="">Address</label>
                                <input type="text" name="alamat" id="alamat" class="form-control" placeholder="Address" value="<?php echo $rowkonsumen->alamatpengiriman ?>">
                            </div>

                            <!--  
                            <div class="form-group">
                                <label for="">Shipping Agent</label>
                                <div class="">
                                    <?php
$rsjasapengiriman = $this->db->query("select * from jasapengiriman where statusaktif='Aktif'");
if ($rsjasapengiriman->num_rows() > 0) {
    $num = 0;
    foreach ($rsjasapengiriman->result() as $row) {
        $num++;
        echo '
                                            <div class="form-check">
                                              <input class="form-check-input" type="radio" name="idjasapengiriman" id="idjasapengiriman' . $row->idjasapengiriman . '" value="' . $row->idjasapengiriman . '">
                                              <label class="form-check-label" for="idjasapengiriman' . $row->idjasapengiriman . '">
                                                ' . $row->namajasapengiriman . '
                                              </label>
                                            </div>
                                        ';
    }
}
?>
                                </div>
                            </div>
                            -->


                        </div>


                        <div class="col-12 mt-5">
                            <h3>Payment</h3>
                        </div>
                        <div class="col-12">
                            Your shopping amount is $<?php echo $this->cart->total() ?>. Please make payment by online transfer to the bank account below
                        </div>
                        <div class="col-12 mt-3 mb-3">
                            <?php
$rsbank = $this->db->query("select * from bank where statusaktif='Aktif'");
if ($rsbank->num_rows() > 0) {
    $num = 0;
    foreach ($rsbank->result() as $row) {
        $num++;
        if (!empty($row->logobank)) {
            $logobank = base_url('uploads/bank/' . $row->logobank);
        } else {
            $logobank = base_url('images/nofoto.png');
        }

        if (substr(strtolower($row->norekening), 0, 4)=='http') {
            $norekening ='<a href="'.$row->norekening.'" target="_blank">'.$row->norekening.'</a>';
        }else{
            $norekening = $row->norekening;
        }
        echo '
                                            <div class="form-check mt-3">
                                              <input class="form-check-input" type="radio" name="idbank" id="idbank' . $row->idbank . '" value="' . $row->idbank . '">
                                              <label class="form-check-label" for="idbank' . $row->idbank . '"><img src="' . $logobank . '" alt="" width="30px;">
                                                ' . $row->namabank . ' (' . $norekening . ')
                                              </label>
                                            </div>
                                        ';
    }
}
?>
                        </div>



                        <div class="col-12">
                            <div class="shoping__cart__btns">
                                <button type="submit" class="primary-btn">CONTINUE</button>
                            </div>
                        </div>


                    </form>


                </div>


                <div class="col-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="text-success">Your Cart Detail</h5>

                            <table class="table" style="font-size: 12px;">
                                    <thead>
                                        <tr>
                                            <th class="">Products</th>
                                            <th style="text-align: center;">Total</th>
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
                                                        <td style="text-align: left;" class="">
                                                            ' . $items["name"] . '
                                                        </td>
                                                        <td style="text-align: center;" class="">
                                                            $' . format_decimal($items["subtotal"], 2) . '
                                                        </td>
                                                        <td style="text-align: center;" class="">
                                                            <span class="icon_close"></span>
                                                        </td>
                                                    </tr>

                                                  ';

        $totalhargabarang += $items["subtotal"];

    }
}
?>

                                    </tbody>
                                </table>
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