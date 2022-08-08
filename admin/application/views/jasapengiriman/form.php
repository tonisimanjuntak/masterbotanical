<?php  
  $this->load->view("template/header");
  $this->load->view("template/topmenu");
  $this->load->view("template/sidemenu");
?>


<div class="row" id="toni-breadcrumb">
    <div class="col-6">
        <h4 class="text-dark mt-2">Jasa Pengiriman</h4>
    </div>  
    <div class="col-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="<?php echo(site_url()) ?>">Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo(site_url('jasapengiriman')) ?>">Jasa Pengiriman</a></li>
        <li class="breadcrumb-item active" id="lblactive"></li>
      </ol>
      
    </div>
  </div>

  <div class="row" id="toni-content">
    <div class="col-md-12">
      <form action="<?php echo(site_url('jasapengiriman/simpan')) ?>" method="post" id="form" enctype="multipart/form-data">                      
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

                  <input type="hidden" name="idjasapengiriman" id="idjasapengiriman">                      
                  <div class="form-group row required">
                    <label for="" class="col-md-3 col-form-label">Nama Jasa Pengiriman</label>
                    <div class="col-md-9">
                      <input type="text" name="namajasapengiriman" id="namajasapengiriman" class="form-control" placeholder="Pos Indonesia">
                    </div>
                  </div>                      
                  <div class="form-group row required">
                    <label for="" class="col-md-3 col-form-label">No Telp Jasa Pengiriman</label>
                    <div class="col-md-9">
                      <input type="text" name="notelpjasapengiriman" id="notelpjasapengiriman" class="form-control" placeholder="+628142527778">
                    </div>
                  </div>                      
                  <div class="form-group row required">
                    <label for="" class="col-md-3 col-form-label">Url Tracking Jasa Pengiriman</label>
                    <div class="col-md-9">
                      <input type="text" name="urltrackshipping" id="urltrackshipping" class="form-control" placeholder="www.tracking.contoh.com">
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
                  <div class="form-group row">
                      <label for="" class="col-md-3 col-form-label">Logo Jasa Pengiriman <span style="color: red; font-size: 12px; font-weight: bold;"><i> Max ukuran file 2MB</i></span></label>
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
                <a href="<?php echo(site_url('jasapengiriman')) ?>" class="btn btn-default float-right mr-1 ml-1"><i class="fa fa-chevron-circle-left"></i> Kembali</a>
              </div>
            </div> <!-- /.card -->
          </div> <!-- /.col -->
        </div>
      </form>
    </div>
  </div> <!-- /.row -->
  <!-- Main row -->



<?php $this->load->view("template/footer") ?>



<script type="text/javascript">
  
  var idjasapengiriman = "<?php echo($idjasapengiriman) ?>";

  $(document).ready(function() {

    $('.select2').select2();

    //---------------------------------------------------------> JIKA EDIT DATA
    if ( idjasapengiriman != "" ) { 
          $.ajax({
              type        : 'POST', 
              url         : '<?php echo site_url("Jasapengiriman/get_edit_data") ?>', 
              data        : {idjasapengiriman: idjasapengiriman}, 
              dataType    : 'json', 
              encode      : true
          })      
          .done(function(result) {
            $("#idjasapengiriman").val(result.idjasapengiriman);
            $("#namajasapengiriman").val(result.namajasapengiriman);
            $("#notelpjasapengiriman").val(result.notelpjasapengiriman);
            $("#urltrackshipping").val(result.urltrackshipping);
            $("#logojasapengiriman").val(result.logojasapengiriman);
            $("#statusaktif").val(result.statusaktif);


            $('#file_lama').val(result.logojasapengiriman);

            if ( result.logojasapengiriman != '' && result.logojasapengiriman != null ) {
                $("#output1").attr("src","<?php echo(base_url('../uploads/jasapengiriman/')) ?>" + result.logojasapengiriman);              
            }else{
                $("#output1").attr("src","<?php echo(base_url('../images/uploadimages.jpg')) ?>");    
            }
          }); 


          $("#lbljudul").html("Edit Data Jasa Pengiriman");
          $("#lblactive").html("Edit");

    }else{
          $("#lbljudul").html("Tambah Data Jasa Pengiriman");
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
        namajasapengiriman: {
          validators:{
            notEmpty: {
                message: "namajasapengiriman tidak boleh kosong"
            },
          }
        },
        notelpjasapengiriman: {
          validators:{
            notEmpty: {
                message: "notelpjasapengiriman tidak boleh kosong"
            },
          }
        },
        urltrackshipping: {
          validators:{
            notEmpty: {
                message: "urltrackshipping tidak boleh kosong"
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
