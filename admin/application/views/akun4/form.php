<?php  
  $this->load->view("template/header");
  $this->load->view("template/topmenu");
  $this->load->view("template/sidemenu");
?>


<div class="row" id="toni-breadcrumb">
    <div class="col-6">
        <h4 class="text-dark mt-2">Rekening Akun 4</h4>
    </div>  
    <div class="col-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="<?php echo(site_url()) ?>">Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo(site_url('akun4')) ?>">Rekening Akun 4</a></li>
        <li class="breadcrumb-item active" id="lblactive"></li>
      </ol>
      
    </div>
  </div>

  <div class="row" id="toni-content">
    <div class="col-md-12">
      <form action="<?php echo(site_url('akun4/simpan')) ?>" method="post" id="form">                      
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
                    <label for="" class="col-md-3 col-form-label">Kode Rekening Akun 3</label>
                    <div class="col-md-9">
                      <select name="kdakun3" id="kdakun3" class="form-control select2">
                        <option value="">Pilih nama akun 3...</option>
                        <?php  
                          $rsakun3 = $this->db->query("select * from akun3 order by kdakun3");
                          if ($rsakun3->num_rows()>0) {
                            foreach ($rsakun3->result() as $row) {
                              echo '
                                <option value='.$row->kdakun3.'>'.$row->namaakun3.'</option>
                              ';
                            }
                          }
                        ?>
                      </select>
                    </div>
                  </div>                      
                  <div class="form-group row required">
                    <label for="" class="col-md-3 col-form-label">Kode Rekening Akun 4</label>
                    <div class="col-md-2">
                      <input type="text" name="kdakun4" id="kdakun4" class="form-control" placeholder="Contoh : 11">
                    </div>
                  </div>                      
                  <div class="form-group row required">
                    <label for="" class="col-md-3 col-form-label">Nama Rekening Akun 4</label>
                    <div class="col-md-9">
                      <input type="text" name="namaakun4" id="namaakun4" class="form-control" placeholder="Nama rekening akun 4">
                    </div>
                  </div>                      
              </div> <!-- ./card-body -->   

              <div class="card-footer">
                 <button type="submit" class="btn btn-success float-right"><i class="fa fa-save"></i> Simpan</button>
                <a href="<?php echo(site_url('akun4')) ?>" class="btn btn-default float-right mr-1 ml-1"><i class="fa fa-chevron-circle-left"></i> Kembali</a>
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
  
  var kdakun4 = "<?php echo($kdakun4) ?>";

  $(document).ready(function() {

    $('.select2').select2();

    //---------------------------------------------------------> JIKA EDIT DATA
    if ( kdakun4 != "" ) { 
          $.ajax({
              type        : 'POST', 
              url         : '<?php echo site_url("akun4/get_edit_data") ?>', 
              data        : {kdakun4: kdakun4}, 
              dataType    : 'json', 
              encode      : true
          })      
          .done(function(result) {
            $("#kdakun3").val(result.kdakun3).trigger('change');
            $("#kdakun4").val(result.kdakun4);
            $("#namaakun4").val(result.namaakun4);


            $("#kdakun3").attr("disabled", true);
            $("#kdakun4").attr("readonly", true);
          }); 


          $("#lbljudul").html("Edit Data Rekening Akun 4");
          $("#lblactive").html("Edit");

    }else{
          $("#lbljudul").html("Tambah Data Rekening Akun 4");
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
        namaakun4: {
          validators:{
            notEmpty: {
                message: "nama akun tidak boleh kosong"
            },
          }
        },
        kdakun3: {
          validators:{
            notEmpty: {
                message: "kode akun3 tidak boleh kosong"
            },
          }
        },
        kdakun4: {
          validators:{
            notEmpty: {
                message: "kode akun4 tidak boleh kosong"
            },
            stringLength: {
                min: 6,
                max: 6,
                message: 'Panjang karakter harus 6 karakter'
            },
          }
        },
      }
    });
  //------------------------------------------------------------------------> END VALIDASI DAN SIMPAN


    $("form").attr('autocomplete', 'off');
    $("#kdakun4").mask("000000", {reverse: true});

    //$("#tanggal").mask("00-00-0000", {placeholder:"hh-bb-tttt"});
    //$("#jumlah").mask("000,000,000,000", {reverse: true});
  }); //end (document).ready
  

  $('#kdakun3').change(function() {
    kdakun3 = $(this).val();
    $('#kdakun4').val(kdakun3);
    $('#kdakun4').focus();
  });

</script>

</body>
</html>
