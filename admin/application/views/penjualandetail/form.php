<?php  
  $this->load->view("template/header");
  $this->load->view("template/topmenu");
  $this->load->view("template/sidemenu");
?>


<div class="row" id="toni-breadcrumb">
    <div class="col-6">
        <h4 class="text-dark mt-2">Penjualandetail</h4>
    </div>  
    <div class="col-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="<?php echo(site_url()) ?>">Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo(site_url('Penjualandetail')) ?>">Penjualandetail</a></li>
        <li class="breadcrumb-item active" id="lblactive"></li>
      </ol>
      
    </div>
  </div>

  <div class="row" id="toni-content">
    <div class="col-md-12">
      <form action="<?php echo(site_url('Penjualandetail/simpan')) ?>" method="post" id="form">                      
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

                  <input type="hidden" name="idpenjualandetail" id="idpenjualandetail">                      
                  <div class="form-group row required">
                    <label for="" class="col-md-3 col-form-label">idpenjualan</label>
                    <div class="col-md-9">
                      <input type="text" name="idpenjualan" id="idpenjualan" class="form-control" placeholder="Masukkan idpenjualan">
                    </div>
                  </div>                      
                  <div class="form-group row required">
                    <label for="" class="col-md-3 col-form-label">idproduk</label>
                    <div class="col-md-9">
                      <input type="text" name="idproduk" id="idproduk" class="form-control" placeholder="Masukkan idproduk">
                    </div>
                  </div>                      
                  <div class="form-group row required">
                    <label for="" class="col-md-3 col-form-label">beratproduk</label>
                    <div class="col-md-9">
                      <input type="text" name="beratproduk" id="beratproduk" class="form-control" placeholder="Masukkan beratproduk">
                    </div>
                  </div>                      
                  <div class="form-group row required">
                    <label for="" class="col-md-3 col-form-label">hargaproduk</label>
                    <div class="col-md-9">
                      <input type="text" name="hargaproduk" id="hargaproduk" class="form-control" placeholder="Masukkan hargaproduk">
                    </div>
                  </div>
              </div> <!-- ./card-body -->

              <div class="card-footer">
                 <button type="submit" class="btn btn-success float-right"><i class="fa fa-save"></i> Simpan</button>
                <a href="<?php echo(site_url('Penjualandetail')) ?>" class="btn btn-default float-right mr-1 ml-1"><i class="fa fa-chevron-circle-left"></i> Kembali</a>
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
  
  var idpenjualandetail = "<?php echo($idpenjualandetail) ?>";

  $(document).ready(function() {

    $('.select2').select2();

    //---------------------------------------------------------> JIKA EDIT DATA
    if ( idpenjualandetail != "" ) { 
          $.ajax({
              type        : 'POST', 
              url         : '<?php echo site_url("Penjualandetail/get_edit_data") ?>', 
              data        : {idpenjualandetail: idpenjualandetail}, 
              dataType    : 'json', 
              encode      : true
          })      
          .done(function(result) {
            $("#idpenjualandetail").val(result.idpenjualandetail);
            $("#idpenjualan").val(result.idpenjualan);
            $("#idproduk").val(result.idproduk);
            $("#beratproduk").val(result.beratproduk);
            $("#hargaproduk").val(result.hargaproduk);
          }); 


          $("#lbljudul").html("Edit Data Penjualandetail");
          $("#lblactive").html("Edit");

    }else{
          $("#lbljudul").html("Tambah Data Penjualandetail");
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
        idpenjualan: {
          validators:{
            notEmpty: {
                message: "idpenjualan tidak boleh kosong"
            },
          }
        },
        idproduk: {
          validators:{
            notEmpty: {
                message: "idproduk tidak boleh kosong"
            },
          }
        },
        beratproduk: {
          validators:{
            notEmpty: {
                message: "beratproduk tidak boleh kosong"
            },
          }
        },
        hargaproduk: {
          validators:{
            notEmpty: {
                message: "hargaproduk tidak boleh kosong"
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
