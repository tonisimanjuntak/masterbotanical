<?php  
  $this->load->view("template/header");
  $this->load->view("template/topmenu");
  $this->load->view("template/sidemenu");
?>


<div class="row" id="toni-breadcrumb">
    <div class="col-6">
        <h4 class="text-dark mt-2">Rekening Akun 2</h4>
    </div>  
    <div class="col-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="<?php echo(site_url()) ?>">Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo(site_url('akun2')) ?>">Rekening Akun 2</a></li>
        <li class="breadcrumb-item active" id="lblactive"></li>
      </ol>
      
    </div>
  </div>

  <div class="row" id="toni-content">
    <div class="col-md-12">
      <form action="<?php echo(site_url('akun2/simpan')) ?>" method="post" id="form">                      
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
                    <div class="col-md-9">
                      <select name="kdakun1" id="kdakun1" class="form-control select2">
                        <option value="">Pilih nama akun 1...</option>
                        <?php  
                          $rsakun1 = $this->db->query("select * from akun1 order by kdakun1");
                          if ($rsakun1->num_rows()>0) {
                            foreach ($rsakun1->result() as $row) {
                              echo '
                                <option value='.$row->kdakun1.'>'.$row->namaakun1.'</option>
                              ';
                            }
                          }
                        ?>
                      </select>
                    </div>
                  </div>                      
                  <div class="form-group row required">
                    <label for="" class="col-md-3 col-form-label">Kode Rekening Akun 2</label>
                    <div class="col-md-2">
                      <input type="text" name="kdakun2" id="kdakun2" class="form-control" placeholder="Contoh : 11">
                    </div>
                  </div>                      
                  <div class="form-group row required">
                    <label for="" class="col-md-3 col-form-label">Nama Rekening Akun 2</label>
                    <div class="col-md-9">
                      <input type="text" name="namaakun2" id="namaakun2" class="form-control" placeholder="Nama rekening akun 2">
                    </div>
                  </div>                      
              </div> <!-- ./card-body -->   

              <div class="card-footer">
                 <button type="submit" class="btn btn-success float-right"><i class="fa fa-save"></i> Simpan</button>
                <a href="<?php echo(site_url('akun2')) ?>" class="btn btn-default float-right mr-1 ml-1"><i class="fa fa-chevron-circle-left"></i> Kembali</a>
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
  
  var kdakun2 = "<?php echo($kdakun2) ?>";

  $(document).ready(function() {

    $('.select2').select2();

    //---------------------------------------------------------> JIKA EDIT DATA
    if ( kdakun2 != "" ) { 
          $.ajax({
              type        : 'POST', 
              url         : '<?php echo site_url("akun2/get_edit_data") ?>', 
              data        : {kdakun2: kdakun2}, 
              dataType    : 'json', 
              encode      : true
          })      
          .done(function(result) {
            $("#kdakun1").val(result.kdakun1).trigger('change');
            $("#kdakun2").val(result.kdakun2);
            $("#namaakun2").val(result.namaakun2);


            $("#kdakun1").attr("disabled", true);
            $("#kdakun2").attr("readonly", true);
          }); 


          $("#lbljudul").html("Edit Data Rekening Akun 2");
          $("#lblactive").html("Edit");

    }else{
          $("#lbljudul").html("Tambah Data Rekening Akun 2");
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
        namaakun2: {
          validators:{
            notEmpty: {
                message: "nama akun tidak boleh kosong"
            },
          }
        },
        kdakun1: {
          validators:{
            notEmpty: {
                message: "kode akun1 tidak boleh kosong"
            },
          }
        },
        kdakun2: {
          validators:{
            notEmpty: {
                message: "kode akun2 tidak boleh kosong"
            },
            stringLength: {
                min: 2,
                max: 2,
                message: 'Panjang karakter harus 2 karakter'
            },
          }
        },
      }
    });
  //------------------------------------------------------------------------> END VALIDASI DAN SIMPAN


    $("form").attr('autocomplete', 'off');
    $("#kdakun2").mask("00", {reverse: true});

    //$("#tanggal").mask("00-00-0000", {placeholder:"hh-bb-tttt"});
    //$("#jumlah").mask("000,000,000,000", {reverse: true});
  }); //end (document).ready
  

  $('#kdakun1').change(function() {
    kdakun1 = $(this).val();
    $('#kdakun2').val(kdakun1);
    $('#kdakun2').focus();
  });

</script>

</body>
</html>
