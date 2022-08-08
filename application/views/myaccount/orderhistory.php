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
                  <h3 class="mb-5 text-success">My Order History</h3>
                </div>


            </div>
            <div class="row">


                <table class="table">
                  <thead>
                    <tr>
                      <th style="width: 5%; text-align: center;">#</th>
                      <th style="text-align: center;">ID</th>
                      <th style="text-align: center;">Date Order</th>
                      <th style="text-align: center;">Amount</th>
                      <th style="text-align: center;">Konf.Status</th>
                      <th style="text-align: center;">Ship.Status</th>
                      <th style="text-align: center;">Proof Of Payment</th>
                    </tr>
                  </thead>
                  <tbody>
                    
                      <?php  
                        if ($rspenjualan->num_rows()>0) {
                          $no=1;
                          foreach ($rspenjualan->result() as $row) {

                            switch ($row->statuskonfirmasi) {
                              case 'Dikonfirmasi':
                                $statuskonfirmasi = 'Confirmed';
                                break;
                              case 'Ditolak':
                                $statuskonfirmasi = 'Rejected';
                                break;
                              default:
                                $statuskonfirmasi = 'Waiting';
                                break;
                            }

                            switch ($row->statuspengiriman) {
                              case 'Sudah Dikirim':
                                $statuspengiriman = 'Delivered';
                                break;                              
                              default:
                                $statuspengiriman = 'Not Delivered Yet';
                                break;
                            }

                            echo '
                              <tr>
                                <td style="text-align: center;">'.$no++.'</td>
                                <td style="text-align: center;">'.$row->idpenjualan.'</td>
                                <td style="text-align: center;">'.date('Y-m-d H:i:s', strtotime($row->tglcheckout)).'</td>
                                <td style="text-align: center;">$'.format_decimal($row->totalpenjualan,2).'</td>
                                <td style="text-align: center;">'.$statuskonfirmasi.'</td>
                                <td style="text-align: center;">'.$statuspengiriman.'</td>';

                            if (!empty($row->uploadbukti)) {
                              echo '    <td style="text-align: center;"><a href="'.site_url('myaccount/uploadpayment/'.$this->encrypt->encode($row->idpenjualan)).'"><i class="fa fa-check-circle"></i> Uploaded</a>
                                      </td>';
                            }else{
                              echo '    <td style="text-align: center;"><a href="'.site_url('myaccount/uploadpayment/'.$this->encrypt->encode($row->idpenjualan)).'" class="btn btn-success btn-sm"><i class="fa fa-upload"></i></a>
                                      </td>';
                            }

                            echo '  </tr>';
                          }
                        }
                      ?>
                  </tbody>
                </table>


                


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