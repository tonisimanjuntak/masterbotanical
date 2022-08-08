<?php  
  $this->load->view("template/header");
  $this->load->view("template/topmenu");
  $this->load->view("template/sidemenu");
?>


<div class="row" id="toni-breadcrumb">
    <div class="col-6">
        <h4 class="text-dark mt-2">Produkharga</h4>
    </div>  
    <div class="col-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="<?php echo(site_url()) ?>">Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo(site_url('Produkharga')) ?>">Produkharga</a></li>
        <li class="breadcrumb-item active" id="lblactive"></li>
      </ol>
      
    </div>
  </div>

  <div class="row" id="toni-content">
    <div class="col-md-12">
      <form action="<?php echo(site_url('Produkharga/simpan')) ?>" method="post" id="form">                      
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

                  <input type="hidden" name="idprodukharga" id="idprodukharga">                      
                  <div class="form-group row required">
                    <label for="" class="col-md-3 col-form-label">idproduk</label>
                    <div class="col-md-9">
                      <input type="text" name="idproduk" id="idproduk" class="form-control" placeholder="Masukkan idproduk">
                    </div>
                  </div>                      
                  <div class="form-group row required">
                    <label for="" class="col-md-3 col-form-label">harga</label>
                    <div class="col-md-9">
                      <input type="text" name="harga" id="harga" class="form-control" placeholder="Masukkan harga">
                    </div>
                  </div>                      
                  <div class="form-group row required">
                    <label for="" class="col-md-3 col-form-label">berat</label>
                    <div class="col-md-9">
                      <input type="text" name="berat" id="berat" class="form-control" placeholder="Masukkan berat">
                    </div>
                  </div>
              </div> <!-- ./card-body -->

              <div class="card-footer">
                 <button type="submit" class="btn btn-success float-right"><i class="fa fa-save"></i> Simpan</button>
                <a href="<?php echo(site_url('Produkharga')) ?>" class="btn btn-default float-right mr-1 ml-1"><i class="fa fa-chevron-circle-left"></i> Kembali</a>
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
  
  var idprodukharga = "<?php echo($idprodukharga) ?>";

  $(document).ready(function() {

    $('.select2').select2();

    //---------------------------------------------------------> JIKA EDIT DATA
    if ( idprodukharga != "" ) { 
          $.ajax({
              type        : 'POST', 
              url         : '<?php echo site_url("Produkharga/get_edit_data") ?>', 
              data        : {idprodukharga: idprodukharga}, 
              dataType    : 'json', 
              encode      : true
          })      
          .done(function(result) {
            $("#idprodukharga").val(result.idprodukharga);
            $("#idproduk").val(result.idproduk);
            $("#harga").val(result.harga);
            $("#berat").val(result.berat);
          }); 


          $("#lbljudul").html("Edit Data Produkharga");
          $("#lblactive").html("Edit");

    }else{
          $("#lbljudul").html("Tambah Data Produkharga");
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
        harga: {
          validators:{
            notEmpty: {
                message: "harga tidak boleh kosong"
            },
          }
        },
        berat: {
          validators:{
            notEmpty: {
                message: "berat tidak boleh kosong"
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
