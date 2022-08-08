<?php
$this->load->view("template/header");
$this->load->view("template/topmenu");
$this->load->view("template/sidemenu");
?>


<div class="row" id="toni-breadcrumb">
    <div class="col-6">
        <h4 class="text-dark mt-2">Slider</h4>
    </div>
    <div class="col-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="<?php echo (site_url()) ?>">Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo (site_url('slider')) ?>">Slider</a></li>
        <li class="breadcrumb-item active" id="lblactive"></li>
      </ol>

    </div>
  </div>

  <div class="row" id="toni-content">
    <div class="col-md-12">
      <form action="<?php echo (site_url('slider/simpan')) ?>" method="post" id="form" enctype="multipart/form-data">
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

                  <input type="hidden" name="idslider" id="idslider">
                  <input type="hidden" id="tglpublish" name="tglpublish">

                  <div class="form-group row required">
                    <label for="" class="col-md-3 col-form-label">Judul</label>
                    <div class="col-md-9">
                      <input type="text" name="judul" id="judul" class="form-control" placeholder="Judul">
                    </div>
                  </div>


                  <div class="form-group row required">
                    <label for="" class="col-md-3 col-form-label">Catatan Kecil</label>
                    <div class="col-md-9">
                      <textarea name="catatan" id="catatan" class="form-control" rows="2" placeholder="Catatan kecil"></textarea>
                    </div>
                  </div>

                  <div class="form-group row text center">
                      <label for="" class="col-md-12 col-form-label">Gambar Slider <span style="color: red; font-size: 12px; font-weight: bold;"><i> Max ukuran file 2MB</i></span></label>
                      <div class="col-md-12 mt-3 text-center">
                        <img src="<?php echo base_url('../images/nofoto.png'); ?>" id="output1" class="img-thumbnail" style="width:30%;max-height:30%;">
                        <div class="form-group">
                            <span class="btn btn-primary btn-file btn-block;" style="width:30%;">
                              <span class="fileinput-new"><span class="fa fa-camera"></span> Upload Foto</span>
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
                <a href="<?php echo (site_url('slider')) ?>" class="btn btn-default float-right mr-1 ml-1"><i class="fa fa-chevron-circle-left"></i> Kembali</a>
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

  var idslider = "<?php echo ($idslider) ?>";

  $(document).ready(function() {

    $('.select2').select2();

    //---------------------------------------------------------> JIKA EDIT DATA
    if ( idslider != "" ) {
          $.ajax({
              type        : 'POST',
              url         : '<?php echo site_url("slider/get_edit_data") ?>',
              data        : {idslider: idslider},
              dataType    : 'json',
              encode      : true
          })
          .done(function(result) {
            $("#idslider").val(result.idslider);
            $("#judul").val(result.judul);
            $("#catatan").val(result.catatan);
            $("#gambarslider").val(result.gambarslider);

            $('#file_lama').val(result.gambarslider);

            if ( result.gambarslider != '' && result.gambarslider != null ) {
                $("#output1").attr("src","<?php echo (base_url('../uploads/slider/')) ?>" + result.gambarslider);
            }else{
                $("#output1").attr("src","<?php echo (base_url('../images/nofoto.png')) ?>");
            }



          });


          $("#lbljudul").html("Edit Slider");
          $("#lblactive").html("Edit");

    }else{



          $("#lbljudul").html("Tambah Slider");
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
        judul: {
          validators:{
            notEmpty: {
                message: "judul tidak boleh kosong"
            },
          }
        },
        catatan: {
          validators:{
            notEmpty: {
                message: "catatan tidak boleh kosong"
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
