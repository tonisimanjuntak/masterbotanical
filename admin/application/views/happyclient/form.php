<?php
$this->load->view("template/header");
$this->load->view("template/topmenu");
$this->load->view("template/sidemenu");
?>


<div class="row" id="toni-breadcrumb">
    <div class="col-6">
        <h4 class="text-dark mt-2">Happy Client Review</h4>
    </div>
    <div class="col-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="<?php echo (site_url()) ?>">Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo (site_url('happyclient')) ?>">Happy Client Review</a></li>
        <li class="breadcrumb-item active" id="lblactive"></li>
      </ol>

    </div>
  </div>

  <div class="row" id="toni-content">
    <div class="col-md-12">
      <form action="<?php echo (site_url('happyclient/simpan')) ?>" method="post" id="form" enctype="multipart/form-data">
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

                  <input type="hidden" name="idhappyclient" id="idhappyclient">
                  <input type="hidden" id="tglpublish" name="tglpublish">

                  <div class="form-group row required">
                    <label for="" class="col-md-3 col-form-label">Nama Client</label>
                    <div class="col-md-9">
                      <input type="text" name="namaclient" id="namaclient" class="form-control" placeholder="Nama Client">
                    </div>
                  </div>

                  <div class="form-group row required">
                    <label for="" class="col-md-3 col-form-label">Pekerjaan Client</label>
                    <div class="col-md-9">
                      <input type="text" name="pekerjaan" id="pekerjaan" class="form-control" placeholder="Pekerjaan">
                    </div>
                  </div>


                  <div class="form-group row required">
                    <label for="" class="col-md-3 col-form-label">Statement Client</label>
                    <div class="col-md-9">
                      <textarea name="statement" id="statement" class="form-control" rows="3" placeholder="Statement Client"></textarea>
                    </div>
                  </div>

                  <div class="form-group row text center">
                      <label for="" class="col-md-12 col-form-label">Foto Client <span style="color: red; font-size: 12px; font-weight: bold;"><i> Max ukuran file 2MB</i></span></label>
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
                <a href="<?php echo (site_url('happyclient')) ?>" class="btn btn-default float-right mr-1 ml-1"><i class="fa fa-chevron-circle-left"></i> Kembali</a>
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

  var idhappyclient = "<?php echo ($idhappyclient) ?>";

  $(document).ready(function() {

    $('.select2').select2();

    //---------------------------------------------------------> JIKA EDIT DATA
    if ( idhappyclient != "" ) {
          $.ajax({
              type        : 'POST',
              url         : '<?php echo site_url("happyclient/get_edit_data") ?>',
              data        : {idhappyclient: idhappyclient},
              dataType    : 'json',
              encode      : true
          })
          .done(function(result) {
            $("#idhappyclient").val(result.idhappyclient);
            $("#namaclient").val(result.namaclient);
            $("#pekerjaan").val(result.pekerjaan);
            $("#statement").val(result.statement);
            $("#fotoclient").val(result.fotoclient);

            $('#file_lama').val(result.fotoclient);

            if ( result.fotoclient != '' && result.fotoclient != null ) {
                $("#output1").attr("src","<?php echo (base_url('../uploads/happyclient/')) ?>" + result.fotoclient);
            }else{
                $("#output1").attr("src","<?php echo (base_url('../images/nofoto.png')) ?>");
            }

          });


          $("#lbljudul").html("Edit Happy Client Review");
          $("#lblactive").html("Edit");

    }else{

          $("#lbljudul").html("Tambah Happy Client Review");
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
        namaclient: {
          validators:{
            notEmpty: {
                message: "namaclient tidak boleh kosong"
            },
          }
        },
        pekerjaan: {
          validators:{
            notEmpty: {
                message: "pekerjaan tidak boleh kosong"
            },
          }
        },
        statement: {
          validators:{
            notEmpty: {
                message: "statement tidak boleh kosong"
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
