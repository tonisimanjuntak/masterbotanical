<?php  
  $this->load->view("template/header");
  $this->load->view("template/topmenu");
  $this->load->view("template/sidemenu");
?>

  <div class="row" id="toni-breadcrumb">
    <div class="col-6">
        <h4 class="text-dark mt-2">Pengiriman Penjualan</h4>
    </div>  
    <div class="col-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="<?php echo(site_url()) ?>">Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo(site_url('penjualanpengiriman')) ?>">Pengiriman Penjualan</a></li>
      </ol>
      
    </div>
  </div>


  <div class="row" id="toni-content">
    <div class="col-md-12">
        <div class="row">
          <div class="col-md-12">
            <div class="card" id="cardcontent">
              
              <div class="card-body">

                  <div class="col-md-12">
                    <?php 
                      $pesan = $this->session->flashdata("pesan");
                      if (!empty($pesan)) {
                        echo $pesan;
                      }
                    ?>
                  </div> 


                  <div class="row">

                    <div class="col-md-12">
                      <div class="card">
                        <div class="card-body">
                          
                          <h5 class="mb-3">Informasi Penjualan</h5>
                          
                          <table class="table">
                            <tbody>
                              <tr>
                                <td style="width: 20%;">Tgl Penjualan</td>
                                <td style="width: 5%;">:</td>
                                <td id="lbltglpenjualan"><?php echo tglindonesia($rowpenjualan->tglpenjualan) ?></td>
                              </tr>
                              <tr>
                                <td>Metode Pembayaran</td>
                                <td>:</td>
                                <td id="lblmetodepembayaran"><?php echo $rowpenjualan->metodepembayaran ?></td>
                              </tr>
                              <tr>
                                <td>Total Pembayaran</td>
                                <td>:</td>
                                <td id="lblmetodepembayaran"><?php echo $this->session->userdata('matauang').' '.format_decimal($rowpenjualan->totalpenjualan,2) ?></td>
                              </tr>
                              <tr>
                                <td>Keterangan</td>
                                <td>:</td>
                                <td id="lblketerangan"><?php echo $rowpenjualan->keterangan ?></td>
                              </tr>
                            </tbody>
                          </table>


                        </div>
                      </div>

                    </div>

                    <div class="col-md-12">
                      <div class="card">
                        <div class="card-body">
                          
                          <h5 class="mb-3">Informasi Konsumen & Pengiriman</h5>

                          <div class="row">
                            <div class="col-md-12">
                              <table class="table">
                                <tbody>
                                  <tr>
                                    <td style="width: 20%;">Nama Konsumen</td>
                                    <td style="width: 5%;">:</td>
                                    <td id="lblnamakonsumen"><?php echo $rowpenjualan->namakonsumen ?></td>
                                  </tr>
                                  <tr>
                                    <td>Kontak</td>
                                    <td>:</td>
                                    <td id="lblkontak"><?php echo 'Email: '.$rowpenjualan->email.' | No. Telp: '.$rowpenjualan->notelp.' | No. WhatsApp: '.$rowpenjualan->nowa ?></td>
                                  </tr>
                                  <tr>
                                    <td>Alamat Pengiriman</td>
                                    <td>:</td>
                                    <td id="lblalamatpengiriman"><?php echo $rowpenjualan->negara.', '.$rowpenjualan->propinsi.', '.$rowpenjualan->kota.', '.$rowpenjualan->desa.', '.$rowpenjualan->alamatpengiriman ?></td>
                                  </tr>
                                </tbody>
                              </table>    
                            </div>
                          </div>

                        </div>
                      </div>
                    </div>



                  </div>

                  


                  <div class="col-md-12">
                    <div class="card">
                      <div class="card-body">
                          <h5 class="mb-3">Detail Penjualan</h5>
                          <hr>

                          

                          <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th style="width: 5%; text-align: center;">No</th>
                                        <th style="">Nama Produk</th>
                                        <th style="">Berat</th>
                                        <th style="">Harga</th>
                                        <th style="">Qty</th>
                                        <th style="">Sub Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php  
                                      $rsdetail = $this->db->query("select * from v_penjualandetail where idpenjualan='$idpenjualan'");
                                      if ($rsdetail->num_rows()>0) {
                                        $no = 1;
                                        foreach ($rsdetail->result() as $row) {
                                          echo '
                                              <tr>
                                                  <td style="width: 5%; text-align: center;">'.$no++.'</td>
                                                  <td style="">'.$row->namaproduk.'</td>
                                                  <td style="">'.$row->beratproduk.'</td>
                                                  <td style="">'.$row->hargaproduk.'</td>
                                                  <td style="">'.$row->qty.'</td>
                                                  <td style="">'.format_decimal($row->subtotal,2).'</td>
                                              </tr>                                    
                                          ';
                                        }
                                      }
                                    ?>
                                </tbody>
                            </table>
                          </div>

                      </div>
                    </div>
                    <input type="hidden" id="total">
                  </div>
                  
                  <div class="col-md-12">
                    <form action="<?php echo site_url('penjualanpengiriman/simpan') ?>" method="post">

                      <h5 class="mb-3">Informasi Pengiriman</h5><hr>
                      <input type="hidden" name="idpenjualan" id="idpenjualan" value="<?php echo $rowpenjualan->idpenjualan ?>">

                      <div class="form-group row">
                        <label for="" class="col-md-3 col-form-label">Tgl Pengiriman</label>
                        <div class="col-md-3">
                          <input type="date" name="tglpengiriman" id="tglpengiriman" class="form-control" value="<?php echo $tglpengiriman ?>">
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="" class="col-md-3 col-form-label">Nomor Resi Pengiriman</label>
                        <div class="col-md-4">
                          <input type="text" name="noresipengiriman" id="noresipengiriman" class="form-control" value="<?php echo $noresipengiriman ?>">
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="" class="col-md-3 col-form-label">Status Pengiriman</label>
                        <div class="col-md-9">
                          <select name="statuspengiriman" id="statuspengiriman" class="form-control">
                                <option value="">Pilih status pengiriman...</option>
                                <option value="Belum Dikirim" <?php echo ($statuspengiriman=='Belum Dikirim') ? 'selected="selected"' : '' ?> >Belum Dikirim</option>
                                <option value="Sudah Dikirim" <?php echo ($statuspengiriman=='Sudah Dikirim') ? 'selected="selected"' : '' ?>>Sudah Dikirim</option>
                              </select>
                          
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="" class="col-md-3 col-form-label">Nama Jasa Pengiriman</label>
                        <div class="col-md-9">
                          <select name="idjasapengiriman" id="idjasapengiriman" class="form-control select2">
                                <option value="">Pilih jasa pengiriman...</option>
                                <?php  
                                  $rsjasapengiriman = $this->db->query("select * from jasapengiriman where statusaktif='Aktif' order by namajasapengiriman");
                                  if ($rsjasapengiriman->num_rows()>0) {
                                    foreach ($rsjasapengiriman->result() as $row) {
                                      $selected = '';
                                      if (!empty($idjasapengiriman) && $idjasapengiriman==$row->idjasapengiriman) {
                                        $selected = ' selected="selected" ';
                                      }

                                      echo '
                                        <option value="'.$row->idjasapengiriman.'" '.$selected.'>'.$row->idjasapengiriman.' '.$row->namajasapengiriman.'</option>
                                      ';
                                    }
                                  }
                                ?>
                              </select>
                          
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="" class="col-md-3 col-form-label">Estimasi Lama Pengiriman</label>
                        <div class="col-md-2">
                          <input type="number" name="estimasiharipengiriman" id="estimasiharipengiriman" class="form-control" min="1" max="1000" value="<?php echo($estimasiharipengiriman) ?>">
                        </div>
                        <label for="" class="col-md-3 col-form-label">Hari</label>
                      </div>


                      <div class="form-group row">
                        <label for="" class="col-md-3 col-form-label">Keterangan Pengiriman</label>
                        <div class="col-md-9">
                          <textarea name="keteranganpenjualanpengiriman" id="keteranganpenjualanpengiriman" class="form-control" rows="3" placeholder="keterangan pengiriman"><?php echo($keteranganpenjualanpengiriman) ?></textarea>
                        </div>
                      </div>


                      <div class="row">
                        <div class="col-12">
                          
                          <button class="btn btn-info float-right" id="simpan"><i class="fa fa-save"></i> Simpan</button>
                          <a href="<?php echo(site_url('penjualanpengiriman')) ?>" class="btn btn-default float-right mr-1 ml-1"><i class="fa fa-chevron-circle-left"></i> Kembali</a>

                        </div>
                      </div>
                    </form>
                  </div>
              </div> <!-- ./card-body -->

              <div class="card-footer">
              </div>

            </div> <!-- /.card -->
          </div> <!-- /.col -->
        </div>
    </div>
  </div> <!-- /.row -->
  <!-- Main row -->

      

<?php $this->load->view("template/footer") ?>




<script type="text/javascript">
  
  var idpenjualan = "<?php echo($idpenjualan) ?>";

  $(document).ready(function() {

    $('.select2').select2();
    
    $("form").attr('autocomplete', 'off');
  }); //end (document).ready
  

</script>


</body>
</html>
