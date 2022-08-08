<?php  
  $this->load->view("template/header");
  $this->load->view("template/topmenu");
  $this->load->view("template/sidemenu");
?>

  <div class="row" id="toni-breadcrumb">
    <div class="col-6">
        <h4 class="text-dark mt-2">Status Konfirmasi: <?php echo $rowpenjualan->statuskonfirmasi ?></h4>
    </div>  
    <div class="col-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="<?php echo(site_url()) ?>">Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo(site_url('penjualankonfirmasi')) ?>">Konfirmasi Penjualan</a></li>
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
                              <tr>
                                <td>Nama Bank</td>
                                <td>:</td>
                                <td id="lblketerangan"><?php echo $rowpenjualan->namabank ?> ( <?php echo $rowpenjualan->norekening ?> )</td>
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
                    <form action="<?php echo site_url('penjualankonfirmasi/simpan') ?>" method="post">
                      <input type="hidden" name="idpenjualan" id="idpenjualan" value="<?php echo $rowpenjualan->idpenjualan ?>">
                      <div class="row">
                        <div class="col-6">
                          <input type="submit" name="statuskonfirmasi" class="btn btn-success btn-block" value="Dikonfirmasi">
                        </div>
                        <div class="col-6">
                          <input type="submit" name="statuskonfirmasi" value="Ditolak" class="btn btn-danger btn-block">
                        </div>
                      </div>
                    </form>
                  </div>
              </div> <!-- ./card-body -->

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
  

  
  $('#simpan').click(function(){
    var idpenjualan       = $("#idpenjualan").val();
    var tglpenjualan       = $("#tglpenjualan").val();
    var idkonsumen       = $("#idkonsumen").val();
    var keterangan       = $("#keterangan").val();
    var metodepembayaran       = $("#metodepembayaran").val();
    var totalpenjualan       = $("#total").val();

    var negara       = $("#negara").val();
    var propinsi       = $("#propinsi").val();
    var kota       = $("#kota").val();
    var desa       = $("#desa").val();
    var alamatpengiriman       = $("#alamatpengiriman").val();
    var idjasapengiriman       = $("#idjasapengiriman").val();
    

      if (tglpenjualan=='') {
        alert("tglpenjualan tidak boleh kosong!!");
        return; 
      }

      if (idkonsumen=='') {
        alert("idkonsumen tidak boleh kosong!!");
        return; 
      }
    
      if (metodepembayaran=='') {
        alert("metodepembayaran tidak boleh kosong!!");
        return; 
      }
    
      if (totalpenjualan=='') {
        alert("totalpenjualan tidak boleh kosong!!");
        return; 
      }
    

      if (negara=='') {
        alert("negara tidak boleh kosong!!");
        return; 
      }

      if (propinsi=='') {
        alert("propinsi tidak boleh kosong!!");
        return; 
      }

      if (kota=='') {
        alert("kota tidak boleh kosong!!");
        return; 
      }

      if (desa=='') {
        alert("desa tidak boleh kosong!!");
        return; 
      }

      if (alamatpengiriman=='') {
        alert("alamatpengiriman tidak boleh kosong!!");
        return; 
      }


    if ( ! table.data().count() ) {
          alert("Detail Penjualan belum ada!!");
          return;
      }

      var isidatatable = table.data().toArray();

      var formData = {
              "idpenjualan"       : idpenjualan,
              "tglpenjualan"       : tglpenjualan,
              "idkonsumen"       : idkonsumen,
              "keterangan"       : keterangan,
              "metodepembayaran"       : metodepembayaran,
              "totalpenjualan"       : totalpenjualan,
              "negara"       : negara,
              "propinsi"       : propinsi,
              "kota"       : kota,
              "desa"       : desa,
              "alamatpengiriman"       : alamatpengiriman,
              "idjasapengiriman"       : idjasapengiriman,
              "isidatatable"    : isidatatable
          };

      //console.log(isidatatable);
      // console.log(formData);
      $.ajax({
                type        : 'POST', 
                url         : '<?php echo site_url("penjualankonfirmasi/simpan") ?>', 
                data        : formData, 
                dataType    : 'json', 
                encode      : true
            })
            .done(function(result){
                console.log(result);
                if (result.success) {
                    alert("Berhasil simpan data!");
                    window.location.href = "<?php echo(site_url('penjualankonfirmasi')) ?>";
                    
                }else{
                  // console.log(result.msg);
                  alert("Gagal simpan data!");
                }
            })
            .fail(function(){
                alert("Gagal script simpan data!");
            });

  })

</script>


</body>
</html>
