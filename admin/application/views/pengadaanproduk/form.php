<?php
$this->load->view("template/header");
$this->load->view("template/topmenu");
$this->load->view("template/sidemenu");
?>

  <div class="row" id="toni-breadcrumb">
    <div class="col-6">
        <h4 class="text-dark mt-2">Pengadaan Produk</h4>
    </div>
    <div class="col-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="<?php echo (site_url()) ?>">Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo (site_url('pengadaanproduk')) ?>">Pengadaan Produk</a></li>
        <li class="breadcrumb-item active" id="lblactive"></li>
      </ol>

    </div>
  </div>


  <div class="row" id="toni-content">
    <div class="col-md-12">

      <form action="<?php echo (site_url('pengadaanproduk/simpan')) ?>" method="post" id="form">

        <div class="row">
          <div class="col-md-12">
            <div class="card" id="cardcontent">
              <div class="card-header">
                <h5 class="card-title" id="lbljudul"></h5>
              </div>
              <div class="card-body">

                  <div class="col-md-12">
                    <?php
$pesan = $this->session->flashdata("pesan");
if (!empty($pesan)) {
    echo $pesan;
}
?>
                  </div>


                  <input type="hidden" name="idpengadaanproduk" id="idpengadaanproduk">

                  <div class="form-group row required">
                    <label for="" class="col-md-2 col-form-label">Tanggal</label>
                    <div class="col-md-4">
                      <input type="date" name="tglpengadaanproduk" id="tglpengadaanproduk" class="form-control" value="<?php echo date('Y-m-d') ?>">
                    </div>
                  </div>

                  <div class="form-group row required">
                    <label for="" class="col-md-2 col-form-label">Keterangan</label>
                    <div class="col-md-10">
                      <textarea name="keterangan" id="keterangan" class="form-control" rows="3" placeholder="Masukkan keterangan"></textarea>
                    </div>
                  </div>

                      <div class="form-group row">
                        <label for="" class="col-md-2 col-form-label">Nama Produk</label>
                        <div class="col-md-10">
                          <select name="idproduk" id="idproduk" class="form-control select2">
                            <option value="">---Pilih nama produk---</option>
                            <?php
$rsproduk = $this->db->query("select * from produk order by namaproduk ");
if ($rsproduk->num_rows() > 0) {
foreach ($rsproduk->result() as $row) {
echo '<option value="' . $row->idproduk . '">' . $row->namaproduk . '</option>';
}
}

?>
                          </select>
                        </div>
                      </div>


                      <div class="form-group row">
                        <label for="" class="col-md-2 col-form-label">Berat Bruto</label>
                        <div class="col-md-4">
                          <input type="text" name="beratbruto" id="beratbruto" class="form-control berat">
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="" class="col-md-2 col-form-label">Berat Netto</label>
                        <div class="col-md-4">
                          <input type="text" name="beratnetto" id="beratnetto" class="form-control berat">
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="" class="col-md-2 col-form-label">Harga Beli</label>
                        <div class="col-md-4">
                          <input type="text" name="hargabeli" id="hargabeli" class="form-control rupiah">
                        </div>
                      </div>



                      
                  
              </div> <!-- ./card-body -->

              <div class="card-footer">
                <button class="btn btn-info float-right" id="simpan"><i class="fa fa-save"></i> Simpan</button>
                <a href="<?php echo (site_url('pengadaanproduk')) ?>" class="btn btn-default float-right mr-1 ml-1"><i class="fa fa-chevron-circle-left"></i> Kembali</a>
              </div>
            </div> <!-- /.card -->
          </div> <!-- /.col -->
        </div>

      </form>

    </div>
  </div> <!-- /.row -->
  <!-- Main row -->



<?php $this->load->view("template/footer")?>




<script type="text/javascript">

  var idpengadaanproduk = "<?php echo ($idpengadaanproduk) ?>";

  $(document).ready(function() {

    $('.select2').select2();

    //---------------------------------------------------------> JIKA EDIT DATA
    if ( idpengadaanproduk != "" ) {
          $.ajax({
              type        : 'POST',
              url         : '<?php echo site_url("Pengadaanproduk/get_edit_data") ?>',
              data        : {idpengadaanproduk: idpengadaanproduk},
              dataType    : 'json',
              encode      : true
          })
          .done(function(result) {
            console.log(result);
            $('#idpengadaanproduk').val(result.idpengadaanproduk);
            $('#tglpengadaanproduk').val(result.tglpengadaanproduk);
            $('#keterangan').val(result.keterangan);
            $('#idproduk').val(result.idproduk).trigger("change");
            $('#beratbruto').val(result.beratbruto);
            $('#beratnetto').val(result.beratnetto);
            $('#hargabeli').val(result.hargabeli);
          });

          $('#lbljudul').html('Edit Data Pengadaan Produk');
          $('#lblactive').html('Edit');

    }else{
          $('#lbljudul').html('Tambah Data Pengadaan Produk');
          $('#lblactive').html('Tambah');
    }

    //----------------------------------------------------------------- > validasi
    $('#form').bootstrapValidator({
      feedbackIcons: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
      },
      fields: {
        tglpengadaanproduk: {
          validators:{
            notEmpty: {
                message: "tglpengadaanproduk tidak boleh kosong"
            },
          }
        },
        keterangan: {
          validators:{
            notEmpty: {
                message: "keterangan tidak boleh kosong"
            },
          }
        },
        idproduk: {
          validators:{
            notEmpty: {
                message: "nama produk tidak boleh kosong"
            },
          }
        },
        beratbruto: {
          validators:{
            notEmpty: {
                message: "berat bruto tidak boleh kosong"
            },
          }
        },
        beratnetto: {
          validators:{
            notEmpty: {
                message: "berat netto tidak boleh kosong"
            },
          }
        },
        hargabeli: {
          validators:{
            notEmpty: {
                message: "harga beli tidak boleh kosong"
            },
          }
        },
      }
    });
  //------------------------------------------------------------------------> END VALIDASI DAN SIMPAN

    $("form").attr('autocomplete', 'off');
    // $('#tglterima').mask('00-00-0000', {placeholder:"hh-bb-tttt"});
    // $('#hargabelisatuan').mask('000,000,000,000', {reverse: true, placeholder:"000,000,000,000"});
  }); //end (document).ready

  


</script>


</body>
</html>
