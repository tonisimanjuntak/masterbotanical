<?php  
  $this->load->view("template/header");
  $this->load->view("template/topmenu");
  $this->load->view("template/sidemenu");
?>


<div class="row" id="toni-breadcrumb">
    <div class="col-6">
        <h4 class="text-dark mt-2">Produkbahan</h4>
    </div>  
    <div class="col-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="<?php echo(site_url()) ?>">Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo(site_url('Produkbahan')) ?>">Produkbahan</a></li>
        <li class="breadcrumb-item active" id="lblactive"></li>
      </ol>
      
    </div>
  </div>

  <div class="row" id="toni-content">
    <div class="col-md-12">
      <form action="<?php echo(site_url('Produkbahan/simpan')) ?>" method="post" id="form">                      
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

                  <input type="hidden" name="idprodukbahan" id="idprodukbahan">                      
                  <div class="form-group row required">
                    <label for="" class="col-md-3 col-form-label">idproduk</label>
                    <div class="col-md-9">
                      <input type="text" name="idproduk" id="idproduk" class="form-control" placeholder="Masukkan idproduk">
                    </div>
                  </div>                      
                  <div class="form-group row required">
                    <label for="" class="col-md-3 col-form-label">idbahan</label>
                    <div class="col-md-9">
                      <input type="text" name="idbahan" id="idbahan" class="form-control" placeholder="Masukkan idbahan">
                    </div>
                  </div>                      
                  <div class="form-group row required">
                    <label for="" class="col-md-3 col-form-label">beratpenggunaan</label>
                    <div class="col-md-9">
                      <input type="text" name="beratpenggunaan" id="beratpenggunaan" class="form-control" placeholder="Masukkan beratpenggunaan">
                    </div>
                  </div>
              </div> <!-- ./card-body -->

              <div class="card-footer">
                 <button type="submit" class="btn btn-success float-right"><i class="fa fa-save"></i> Simpan</button>
                <a href="<?php echo(site_url('Produkbahan')) ?>" class="btn btn-default float-right mr-1 ml-1"><i class="fa fa-chevron-circle-left"></i> Kembali</a>
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
  
  var idprodukbahan = "<?php echo($idprodukbahan) ?>";

  $(document).ready(function() {

    $('.select2').select2();

    //---------------------------------------------------------> JIKA EDIT DATA
    if ( idprodukbahan != "" ) { 
          $.ajax({
              type        : 'POST', 
              url         : '<?php echo site_url("Produkbahan/get_edit_data") ?>', 
              data        : {idprodukbahan: idprodukbahan}, 
              dataType    : 'json', 
              encode      : true
          })      
          .done(function(result) {
            $("#idprodukbahan").val(result.idprodukbahan);
            $("#idproduk").val(result.idproduk);
            $("#idbahan").val(result.idbahan);
            $("#beratpenggunaan").val(result.beratpenggunaan);
          }); 


          $("#lbljudul").html("Edit Data Produkbahan");
          $("#lblactive").html("Edit");

    }else{
          $("#lbljudul").html("Tambah Data Produkbahan");
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
        idproduk: {
          validators:{
            notEmpty: {
                message: "idproduk tidak boleh kosong"
            },
          }
        },
        idbahan: {
          validators:{
            notEmpty: {
                message: "idbahan tidak boleh kosong"
            },
          }
        },
        beratpenggunaan: {
          validators:{
            notEmpty: {
                message: "beratpenggunaan tidak boleh kosong"
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
