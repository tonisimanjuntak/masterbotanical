<?php
$this->load->view("template/header");
$this->load->view("template/topmenu");
$this->load->view("template/sidemenu");
?>


  <div class="row" id="toni-breadcrumb">
    <div class="col-6">
        <h4 class="text-dark mt-2">Laporan Penjualan</h4>
    </div>
    <div class="col-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="<?php echo (site_url()) ?>">Home</a></li>
        <li class="breadcrumb-item active">Laporan Penjualan</li>
      </ol>

    </div>
  </div>

  <div class="row" id="toni-content">
    <div class="col-md-12">
      <div class="card" id="cardcontent">
        <div class="card-body p-5" >


          <form action="<?php echo (site_url('lappenjualan/cetak')) ?>" method="post">
            <div class="row">
              <div class="col-md-3"></div>
              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-12" style="text-align: center;">
                    <h3>Pilih Periode Laporan</h3><br>
                  </div>
                  <div class="col-md-5">
                    <input type="date" id="tglawal" name="tglawal" class="form-control" value="<?php echo ($tglawal) ?>">
                  </div>
                  <div class="col-md-2 text-center">
                    <label for="" class="col-form-label">S/D</label>
                  </div>
                  <div class="col-md-5">
                    <input type="date" id="tglakhir" name="tglakhir" class="form-control" value="<?php echo ($tglakhir) ?>">
                  </div>
                  <div class="col-md-12 mt-4">
                    <div class="form-group row">
                      <label for="" class="col-md-4 col-form-label">Status Konfirmasi</label>
                      <div class="col-md-8">
                        <select name="statuskonfirmasi" id="statuskonfirmasi" class="form-control">
                          <option value="-">Semua status</option>
                          <option value="Menunggu">Menunggu</option>
                          <option value="Dikonfirmasi">Dikonfirmasi</option>
                          <option value="Ditolak">Ditolak</option>
                        </select>                        
                      </div>
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group row">
                      <label for="" class="col-md-4 col-form-label">Produk</label>
                      <div class="col-md-8">
                        <select name="idproduk" id="idproduk" class="form-control select2">
                          <option value="-">Semua produk</option>
                          <?php  
                            $rsproduk = $this->db->query("select * from produk order by namaproduk");
                            if ($rsproduk->num_rows()>0) {
                              foreach ($rsproduk->result() as $row) {
                                echo '
                                  <option value="'.$row->idproduk.'">'.$row->namaproduk.'</option>
                                ';
                              }
                            }
                          ?>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-12" id="divbatchnumber">
                    <div class="form-group row">
                      <label for="" class="col-md-4 col-form-label">Batch Number</label>
                      <div class="col-md-8">
                        <select name="idprodukbatchnumber" id="idprodukbatchnumber" class="form-control select2">
                          <option value="-">Semua batch number</option>
                        </select>                        
                      </div>
                    </div>
                  </div>

                  <div class="col-md-12 mt-3">
                    <span class="btn btn-danger float-right" id="cetakpdf"><i class="fa fa-file-pdf"></i> Cetak PDF</span>
                    <span class="btn btn-success float-right mr-2" id="cetakexcel"><i class="fa fa-file-excel"></i> Download Excel</span>
                  </div>
                </div>
              </div>
            </div>
          </form>

        </div> <!-- ./card-body -->
      </div> <!-- /.card -->
    </div> <!-- /.col -->
  </div> <!-- /.row -->
  <!-- Main row -->



<?php $this->load->view("template/footer")?>

<script>
  $(document).ready(function() {
    $('.select2').select2();
    $('#divbatchnumber').hide();

  });


  $('#idproduk').change(function() {
    var idproduk = $(this).val();

    $("#idprodukbatchnumber").empty();
    $("#idprodukbatchnumber").append( new Option('Pilih batch number...', '-') );

    if (idproduk!='-') {          
          // get batch number
          $('#divbatchnumber').show();
          $("#idprodukbatchnumber").css("width", "100%");

          $.ajax({
            url: '<?php echo site_url("Penjualan/get_batchnumber") ?>',
            type: 'GET',
            dataType: 'json',
            data: {'idproduk': idproduk},
          })
          .done(function(resultbatchnumber) {
            // console.log(resultbatchnumber);
            if (resultbatchnumber.length>0 ) {

              $.each(resultbatchnumber, function(index, val) {
                 $("#idprodukbatchnumber").append( new Option(resultbatchnumber[index]['nomorbatch']+' - Stok '+resultbatchnumber[index]['stok'] + ' Kg', resultbatchnumber[index]['idprodukbatchnumber']) );
              });
            }            

          })
          .fail(function() {
            console.log("error get batchnumber");
          });
          

        }else{
          $("#idprodukbatchnumber").css("width", "100%");
          $('#divbatchnumber').hide();
        }    
    
  });

  $('#cetakpdf').click(function(){
        cetak('pdf');
    });

  $('#cetakexcel').click(function(){
        cetak('excel');
    });

  function cetak(jeniscetakan)
  {
        var statuskonfirmasi       = $('#statuskonfirmasi').val();
        var idproduk       = $('#idproduk').val();
        var idprodukbatchnumber       = $('#idprodukbatchnumber').val();
        var tglawal       = $('#tglawal').val();
        var tglakhir      = $('#tglakhir').val();

        if (tglawal==='' || tglakhir==='') {
            bootbox.alert('Pilih Periode!');
            return;
        }

        if (jeniscetakan=='pdf') {
          window.open("<?php echo site_url('lappenjualan/cetak/pdf/') ?>" + statuskonfirmasi + "/" + idproduk + "/" + idprodukbatchnumber + "/"+ tglawal + "/" + tglakhir );          
        }else{
          window.open("<?php echo site_url('lappenjualan/cetak/excel/') ?>" + statuskonfirmasi + "/" + idproduk + "/" + idprodukbatchnumber + "/"+ tglawal + "/" + tglakhir );          
        }
  }
</script>

</body>
</html>



