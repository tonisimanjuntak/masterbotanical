<?php
$this->load->view("template/header");
$this->load->view("template/topmenu");
$this->load->view("template/sidemenu");
?>


<div class="row" id="toni-breadcrumb">
    <div class="col-6">
        <h4 class="text-dark mt-2">Bank Transfer</h4>
    </div>
    <div class="col-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="<?php echo (site_url()) ?>">Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo (site_url('bank')) ?>">Bank Transfer</a></li>
        <li class="breadcrumb-item active" id="lblactive"></li>
      </ol>

    </div>
  </div>

  <div class="row" id="toni-content">
    <div class="col-md-12">
      <form action="<?php echo (site_url('bank/simpan')) ?>" method="post" id="form" enctype="multipart/form-data">
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

                  <input type="hidden" name="idbank" id="idbank">

                  <div class="col-12">
                    <div class="row">

                      <div class="col-md-4">
                        <div class="card">
                          <div class="card-body">

                              <div class="form-group row text center">
                                <label for="" class="col-md-12 col-form-label">Logo Bank <span style="color: red; font-size: 12px; font-weight: bold;"><i> Max ukuran file 2MB</i></span></label>
                                <div class="col-md-12 mt-3 text-center">
                                  <img src="<?php echo base_url('../images/nofoto.png'); ?>" id="output1" class="img-thumbnail" style="width:70%;max-height:70%;">
                                  <div class="form-group">
                                      <span class="btn btn-primary btn-file btn-block;" style="width:70%;">
                                        <span class="fileinput-new"><span class="fa fa-camera"></span> Upload Logo Bank</span>
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

                          </div>
                        </div>
                      </div>

                      <div class="col-md-8">
                        <div class="card">
                          <div class="card-body">
                            <div class="form-group row required">
                              <label for="" class="col-md-3 col-form-label">Nama Bank</label>
                              <div class="col-md-9">
                                <input type="text" name="namabank" id="namabank" class="form-control" placeholder="Masukkan namabank">
                              </div>
                            </div>

                            <div class="form-group row required">
                              <label for="" class="col-md-3 col-form-label">Negara</label>
                              <div class="col-md-9">
                                <input type="text" name="negara" id="negara" class="form-control" placeholder="Masukkan negara">
                              </div>
                            </div>
                            <div class="form-group row required">
                              <label for="" class="col-md-3 col-form-label">Cabang</label>
                              <div class="col-md-9">
                                <input type="text" name="cabang" id="cabang" class="form-control" placeholder="Masukkan cabang">
                              </div>
                            </div>
                            <div class="form-group row required">
                              <label for="" class="col-md-3 col-form-label">No Rekening</label>
                              <div class="col-md-9">
                                <input type="text" name="norekening" id="norekening" class="form-control" placeholder="Masukkan nomor rekening">
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

                          </div>
                        </div>
                      </div>



                    </div>
                  </div>



              </div> <!-- ./card-body -->

              <div class="card-footer">
                 <button type="submit" class="btn btn-success float-right"><i class="fa fa-save"></i> Simpan</button>
                <a href="<?php echo (site_url('bank')) ?>" class="btn btn-default float-right mr-1 ml-1"><i class="fa fa-chevron-circle-left"></i> Kembali</a>
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

  var idbank = "<?php echo ($idbank) ?>";

  $(document).ready(function() {

    $('.select2').select2();

    //---------------------------------------------------------> JIKA EDIT DATA
    if ( idbank != "" ) {
          $.ajax({
              type        : 'POST',
              url         : '<?php echo site_url("bank/get_edit_data") ?>',
              data        : {idbank: idbank},
              dataType    : 'json',
              encode      : true
          })
          .done(function(result) {
            $("#idbank").val(result.idbank);
            $("#namabank").val(result.namabank);
            $("#negara").val(result.negara);
            $("#cabang").val(result.cabang);
            $("#norekening").val(result.norekening);

            $("#logobank").val(result.logobank);
            $('#file_lama').val(result.logobank);

            if ( result.logobank != '' && result.logobank != null ) {
                $("#output1").attr("src","<?php echo (base_url('../uploads/bank/')) ?>" + result.logobank);
            }else{
                $("#output1").attr("src","<?php echo (base_url('../images/nofoto.png')) ?>");
            }


          });


          $("#lbljudul").html("Edit Data Bank");
          $("#lblactive").html("Edit");

    }else{
          $("#lbljudul").html("Tambah Data Bank");
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
        namabank: {
          validators:{
            notEmpty: {
                message: "nama pengguna tidak boleh kosong"
            },
          }
        },
        negara: {
          validators:{
            notEmpty: {
                message: "negara tidak boleh kosong"
            },
          }
        },
        cabang: {
          validators:{
            notEmpty: {
                message: "cabang tidak boleh kosong"
            },
          }
        },
        norekening: {
          validators:{
            notEmpty: {
                message: "nomor rekening tidak boleh kosong"
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
