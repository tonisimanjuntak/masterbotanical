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
                  <h3 class="mb-5 text-success">Upload Proof Of Payment</h3>
                </div>


            </div>
            <div class="row">
                <div class="col-12">
                  <h3>Order Information</h3>
                </div>
                <div class="col-12">
                  <table class="table" border="0">
                    <tbody>
                      <tr>
                        <td style="width: 15%;">ID Order</td>
                        <td style="width: 5%;">:</td>
                        <td><?php echo $rowpenjualan->idpenjualan ?></td>
                      </tr>
                      <tr>
                        <td>Date Order</td>
                        <td>:</td>
                        <td><?php echo date('Y-m-d H:i:s', strtotime($rowpenjualan->tglcheckout)) ?></td>
                      </tr>
                      <tr>
                        <td>Country</td>
                        <td>:</td>
                        <td><?php echo $rowpenjualan->negara ?></td>
                      </tr>
                      <tr>
                        <td>Province</td>
                        <td>:</td>
                        <td><?php echo $rowpenjualan->propinsi ?></td>
                      </tr>
                      <tr>
                        <td>City</td>
                        <td>:</td>
                        <td><?php echo $rowpenjualan->kota ?></td>
                      </tr>
                      <tr>
                        <td>Village</td>
                        <td>:</td>
                        <td><?php echo $rowpenjualan->desa ?></td>
                      </tr>
                      <tr>
                        <td>Address</td>
                        <td>:</td>
                        <td><?php echo $rowpenjualan->alamatpengiriman ?></td>
                      </tr>
                      <tr>
                        <td>Amount To Transfer</td>
                        <td>:</td>
                        <td><strong>$<?php echo format_decimal($rowpenjualan->totalpenjualan,2) ?></strong></td>
                      </tr>
                      <tr>
                        <td>Bank To Transfer</td>
                        <td>:</td>
                        <td>
                          <strong><?php echo $rowpenjualan->namabank ?></strong><br>
                          <span>Rekening Acc : <?php echo $rowpenjualan->norekening ?></span><br>
                          <span>Country : <?php echo $rowpenjualan->negara ?></span><br>
                          <span>Branch : <?php echo $rowpenjualan->cabang ?></span>
                        </td>
                      </tr>

                    </tbody>
                  </table>
                </div>
                <div class="col-12 mt-5">
                  <h3>Detail Order</h3>
                </div>
                <div class="col-12">
                  
                  <table class="table">
                    <thead>
                      <tr>
                        <th style="width: 5%; text-align: center;">#</th>
                        <th style="text-align: center;">ID PRODUCT</th>
                        <th style="text-align: center;">PRODUCT NAME</th>
                        <th style="text-align: center;">WEIGHT</th>
                        <th style="text-align: center;">PRICE</th>
                        <th style="text-align: center;">QTY</th>
                        <th style="text-align: center;">SUBTOTAL</th>
                      </tr>
                    </thead>
                    <tbody>
                      
                        <?php  
                          $totalpenjualan = 0;
                          if ($rspenjualandetail->num_rows()>0) {
                            $no=1;
                            foreach ($rspenjualandetail->result() as $row) {

                              echo '
                                <tr>
                                  <td style="text-align: center;">'.$no++.'</td>
                                  <td style="text-align: center;">'.$row->idproduk.'</td>
                                  <td style="text-align: center;">'.$row->namaproduk.'</td>
                                  <td style="text-align: center;">'.format_decimal($row->beratproduk,2).'</td>
                                  <td style="text-align: center;">$'.format_decimal($row->hargaproduk,2).'</td>
                                  <td style="text-align: center;">'.$row->qty.'</td>
                                  <td style="text-align: center;">$'.format_decimal($row->subtotal,2).'</td>
                                </tr>
                              ';
                              $totalpenjualan += $row->subtotal;
                            }
                          }
                        ?>
                    </tbody>
                    <footer>
                      <tr style="font-weight: bold; font-size: 14px;">
                        <td style="text-align: right;" colspan="6">TOTAL</td>
                        <td style="text-align: center;">$<?php echo format_decimal($totalpenjualan,2) ?></td>
                      </tr>
                    </footer>
                  </table>

                </div>

                <div class="col-12 mt-5">
                  <h3>Upload Proof Of Payment</h3>
                </div>
                <div class="col-12">
                  <?php  
                    if (empty($rowpenjualan->uploadbukti)) {
                      $gambarbukti = base_url('images/nofoto.png');
                    }else{
                      $gambarbukti = base_url('uploads/penjualan/'.$rowpenjualan->uploadbukti);
                    }
                  ?>
                  <img src="<?php echo $gambarbukti; ?>" class="img-thumbnail" style="width:300px;height:300px;">
                </div>
                <?php  
                  if ($rowpenjualan->statuskonfirmasi=='Menunggu') { ?>
                
                    <div class="col-12 mt-3">
                      <form action="<?php echo site_url('myaccount/uploadsubmit') ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="idpenjualan" id="idpenjualan" value="<?php echo $rowpenjualan->idpenjualan ?>">
                        <input type="file" name="file" id="file" accept="image/*" onchange="this.form.submit()">
                        <input type="hidden" value="" name="file_lama" id="file_lama" class="form-control" />
                      </form>
                    </div>

                <?php
                  }else{
                    echo '
                        <div class="col-12 mt-3 text-danger">
                          This transaction has been proccess by admin cannot be edit
                        </div>

                    ';
                    
                  }
                ?>
                
                <div class="col-12">
                  <a href="<?php echo site_url('myaccount/orderhistory') ?>" class="btn btn-success btn-sm float-right">Back</a>
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