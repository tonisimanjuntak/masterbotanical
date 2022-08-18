<?php  
  $this->load->view("template/header");
  $this->load->view("template/topmenu");
  $this->load->view("template/sidemenu");
?>


<div class="row" id="toni-breadcrumb">
    <div class="col-6">
        <h4 class="text-dark mt-2">Rekening Akun 1</h4>
    </div>  
    <div class="col-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="<?php echo(site_url()) ?>">Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo(site_url('akun1')) ?>">Rekening Akun 1</a></li>
        <li class="breadcrumb-item active" id="lblactive"></li>
      </ol>
      
    </div>
  </div>

  <div class="row" id="toni-content">
    <div class="col-md-12">
      <form action="<?php echo(site_url('akun1/simpan')) ?>" method="post" id="form">                      
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

                  <input type="hidden" name="ltambah" value="<?php echo $ltambah ?>">
                  <div class="form-group row required">
                    <label for="" class="col-md-3 col-form-label">Kode Rekening Akun 1</label>
                    <div class="col-md-2">
                      <input type="text" name="kdakun1" id="kdakun1" class="form-control" placeholder="Contoh : 1">
                    </div>
                  </div>                      
                  <div class="form-group row required">
                    <label for="" class="col-md-3 col-form-label">Nama Rekening Akun 1</label>
                    <div class="col-md-9">
                      <input type="text" name="namaakun1" id="namaakun1" class="form-control" placeholder="Nama rekening akun 1">
                    </div>
                  </div>                      
              </div> <!-- ./card-body -->   

              <div class="card-footer">
                 <button type="submit" class="btn btn-success float-right"><i class="fa fa-save"></i> Simpan</button>
                <a href="<?php echo(site_url('akun1')) ?>" class="btn btn-default float-right mr-1 ml-1"><i class="fa fa-chevron-circle-left"></i> Kembali</a>
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
  
  var kdakun1 = "<?php echo($kdakun1) ?>";

  $(document).ready(function() {

    $('.select2').select2();

    //---------------------------------------------------------> JIKA EDIT DATA
    if ( kdakun1 != "" ) { 
          $.ajax({
              type        : 'POST', 
              url         : '<?php echo site_url("akun1/get_edit_data") ?>', 
              data        : {kdakun1: kdakun1}, 
              dataType    : 'json', 
              encode      : true
          })      
          .done(function(result) {
            $("#kdakun1").val(result.kdakun1);
            $("#namaakun1").val(result.namaakun1);
          }); 


          $("#lbljudul").html("Edit Data Rekening Akun 1");
          $("#lblactive").html("Edit");

    }else{
          $("#lbljudul").html("Tambah Data Rekening Akun 1");
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
        namaakun1: {
          validators:{
            notEmpty: {
                message: "nama akun tidak boleh kosong"
            },
          }
        },
        kdakun1: {
          validators:{
            notEmpty: {
                message: "kode akun tidak boleh kosong"
            },
            stringLength: {
                min: 1,
                max: 1,
                message: 'Panjang karakter harus 1 karakter'
            },
          }
        },
      }
    });
  //------------------------------------------------------------------------> END VALIDASI DAN SIMPAN


    $("form").attr('autocomplete', 'off');
    //$("#tanggal").mask("00-00-0000", {placeholder:"hh-bb-tttt"});
    $("#kdakun1").mask("0", {reverse: true});
  }); //end (document).ready
  

</script>

</body>
</html>
