<?php
$this->load->view("template/header");
$this->load->view("template/topmenu");
$this->load->view("template/sidemenu");
?>


<div class="row" id="toni-breadcrumb">
    <div class="col-6">
        <h4 class="text-dark mt-2">Supplier</h4>
    </div>
    <div class="col-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="<?php echo (site_url()) ?>">Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo (site_url('supplier')) ?>">Supplier</a></li>
        <li class="breadcrumb-item active" id="lblactive"></li>
      </ol>

    </div>
  </div>

  <div class="row" id="toni-content">
    <div class="col-md-12">
      <form action="<?php echo (site_url('supplier/simpan')) ?>" method="post" id="form">
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

                  <input type="hidden" name="idsupplier" id="idsupplier">
                  <div class="form-group row required">
                    <label for="" class="col-md-3 col-form-label">Nama Supplier</label>
                    <div class="col-md-9">
                      <input type="text" name="namasupplier" id="namasupplier" class="form-control" placeholder="nama supplier">
                    </div>
                  </div>

                  <div class="form-group row required">
                    <label for="" class="col-md-3 col-form-label">Alamat Supplier</label>
                    <div class="col-md-9">
                      <textarea name="alamatsupplier" id="alamatsupplier" class="form-control" rows="3" placeholder="Alamat"></textarea>
                    </div>
                  </div>

                  <div class="form-group row required">
                    <label for="" class="col-md-3 col-form-label">Nomor Telp.</label>
                    <div class="col-md-9">
                      <input type="text" name="notelp" id="notelp" class="form-control" placeholder="0812xxxxxxxx">
                    </div>
                  </div>


                  <div class="form-group row required">
                    <label for="" class="col-md-3 col-form-label">Email</label>
                    <div class="col-md-9">
                      <input type="email" name="email" id="email" class="form-control" placeholder="contoh@gmail.com">
                    </div>
                  </div>

                  <div class="form-group row required">
                    <label for="" class="col-md-3 col-form-label">Status Aktif</label>
                    <div class="col-md-9">
                      <select name="statusaktif" id="statusaktif" class="form-control">
                        <option value="Aktif">Aktif</option>
                        <option value="Tidak Aktif">Tidak Aktif</option>
                      </select>
                    </div>
                  </div>

              </div> <!-- ./card-body -->

              <div class="card-footer">
                 <button type="submit" class="btn btn-success float-right"><i class="fa fa-save"></i> Simpan</button>
                <a href="<?php echo (site_url('supplier')) ?>" class="btn btn-default float-right mr-1 ml-1"><i class="fa fa-chevron-circle-left"></i> Kembali</a>
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

  var idsupplier = "<?php echo ($idsupplier) ?>";

  $(document).ready(function() {

    $('.select2').select2();

    //---------------------------------------------------------> JIKA EDIT DATA
    if ( idsupplier != "" ) {
          $.ajax({
              type        : 'POST',
              url         : '<?php echo site_url("supplier/get_edit_data") ?>',
              data        : {idsupplier: idsupplier},
              dataType    : 'json',
              encode      : true
          })
          .done(function(result) {
            $("#idsupplier").val(result.idsupplier);
            $("#namasupplier").val(result.namasupplier);
            $("#alamatsupplier").val(result.alamatsupplier);
            $("#notelp").val(result.notelp);
            $("#email").val(result.email);
            $("#statusaktif").val(result.statusaktif);
          });


          $("#lbljudul").html("Edit Data Supplier");
          $("#lblactive").html("Edit");

    }else{
          $("#lbljudul").html("Tambah Data Supplier");
          $("#lblactive").html("Tambah");
    }

    //----------------------------------------------------------------- > validasi
    $("#form").bootstrapValidator({
      feedbackIcons: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
      },
      fields: {
        namasupplier: {
          validators:{
            notEmpty: {
                message: "nama supplier tidak boleh kosong"
            },
          }
        },
      }
    });
  //------------------------------------------------------------------------> END VALIDASI DAN SIMPAN


    $("form").attr('autocomplete', 'off');
    //$("#tanggal").mask("00-00-0000", {placeholder:"hh-bb-tttt"});
    //$("#jumlah").mask("000,000,000,000", {reverse: true});
  }); //end (document).ready


</script>

</body>
</html>
