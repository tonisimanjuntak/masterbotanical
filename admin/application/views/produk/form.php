<?php
$this->load->view("template/header");
$this->load->view("template/topmenu");
$this->load->view("template/sidemenu");
?>


<div class="row" id="toni-breadcrumb">
    <div class="col-6">
        <h4 class="text-dark mt-2">Produk</h4>
    </div>
    <div class="col-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="<?php echo (site_url()) ?>">Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo (site_url('Produk')) ?>">Produk</a></li>
        <li class="breadcrumb-item active" id="lblactive"></li>
      </ol>

    </div>
  </div>

  <div class="row" id="toni-content">
    <div class="col-md-12">
      <form action="<?php echo (site_url('Produk/simpan')) ?>" method="post" id="form" enctype="multipart/form-data">
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

                  <input type="hidden" name="idproduk" id="idproduk">
                  <div class="form-group row required">
                    <label for="" class="col-md-3 col-form-label">Nama Produk</label>
                    <div class="col-md-9">
                      <input type="text" name="namaproduk" id="namaproduk" class="form-control" placeholder="Masukkan namaproduk">
                    </div>
                  </div>
                  <div class="form-group row required">
                    <label for="" class="col-md-3 col-form-label">Jenis Produk</label>
                    <div class="col-md-9">
                      <select name="idjenis" id="idjenis" class="form-control select2">
                        <option value="">Pilih jenis produk...</option>
                        <?php
$rsjenis = $this->db->query("select * from jenis order by namajenis asc");
if ($rsjenis->num_rows() > 0) {
    foreach ($rsjenis->result() as $row) {
        echo '
                                <option value="' . $row->idjenis . '">' . $row->namajenis . '</option>
                              ';
    }
}
?>
                      </select>
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
                  <div class="form-group row required">
                    <label for="" class="col-md-3 col-form-label">Deskripsi Produk</label>
                    <div class="col-md-9">
                      <textarea name="deskripsiproduk" id="deskripsiproduk" class="form-control" rows="3" placeholder="deskripsi produk"></textarea>
                    </div>
                  </div>

                  <div class="form-group row text center">
                        <label for="" class="col-md-3 col-form-label">Gambar Sampul Produk <span style="color: red; font-size: 12px; font-weight: bold;"><i> Max ukuran file 2MB</i></span></label>
                        <div class="col-md-9">
                          <img src="<?php echo base_url('../images/uploadimages.jpg'); ?>" id="output1" class="img-thumbnail" style="width:40%;max-height:40%;">
                          <div class="form-group">
                              <span class="btn btn-primary btn-file btn-block;" style="width:40%;">
                                <span class="fileinput-new"><span class="fa fa-camera"></span> Upload Gambar</span>
                                <input type="file" name="file" id="file" accept="image/*" onchange="loadFile1(event)">
                                <input type="hidden" value="" name="file_lama" id="file_lama" class="form-control" />
                              </span>
                          </div>
                          <script type="text/javascript">
                              var loadFile1 = function(event) {
                                  var output1 = document.getElementById('output1');
                                  output1.src = URL.createObjectURL(event.target.files[0]);
                              };
                          </script>
                        </div>
                    </div>

              </div> <!-- ./card-body -->

              <div class="card-footer">
                 <button type="submit" class="btn btn-success float-right"><i class="fa fa-save"></i> Simpan</button>
                <a href="<?php echo (site_url('Produk')) ?>" class="btn btn-default float-right mr-1 ml-1"><i class="fa fa-chevron-circle-left"></i> Kembali</a>
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

  var idproduk = "<?php echo ($idproduk) ?>";

  $(document).ready(function() {

    $('.select2').select2();

    //---------------------------------------------------------> JIKA EDIT DATA
    if ( idproduk != "" ) {
          $.ajax({
              type        : 'POST',
              url         : '<?php echo site_url("Produk/get_edit_data") ?>',
              data        : {idproduk: idproduk},
              dataType    : 'json',
              encode      : true
          })
          .done(function(result) {
            $("#idproduk").val(result.idproduk);
            $("#namaproduk").val(result.namaproduk);
            $("#idjenis").val(result.idjenis).trigger('change');
            $("#statusaktif").val(result.statusaktif);
            $("#deskripsiproduk").val(result.deskripsiproduk);

            $('#file_lama').val(result.gambarproduk);

            if ( result.gambarproduk != '' && result.gambarproduk != null ) {
                $("#output1").attr("src","<?php echo (base_url('../uploads/produk/')) ?>" + result.gambarproduk);
            }else{
                $("#output1").attr("src","<?php echo (base_url('../images/uploadimages.jpg')) ?>");
            }

          });


          $("#lbljudul").html("Edit Data Produk");
          $("#lblactive").html("Edit");

    }else{
          $("#lbljudul").html("Tambah Data Produk");
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
        namaproduk: {
          validators:{
            notEmpty: {
                message: "namaproduk tidak boleh kosong"
            },
          }
        },
        idjenis: {
          validators:{
            notEmpty: {
                message: "idjenis tidak boleh kosong"
            },
          }
        },
        statusaktif: {
          validators:{
            notEmpty: {
                message: "statusaktif tidak boleh kosong"
            },
          }
        },
        deskripsiproduk: {
          validators:{
            notEmpty: {
                message: "deskripsiproduk tidak boleh kosong"
            },
          }
        },      }
    });
  //------------------------------------------------------------------------> END VALIDASI DAN SIMPAN


    $("form").attr('autocomplete', 'off');
    //$("#tanggal").mask("00-00-0000", {placeholder:"hh-bb-tttt"});
    //$("#jumlah").mask("000,000,000,000", {reverse: true});
  }); //end (document).ready


</script>

</body>
</html>
