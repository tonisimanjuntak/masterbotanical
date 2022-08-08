<?php  
  $this->load->view("template/header");
  $this->load->view("template/topmenu");
  $this->load->view("template/sidemenu");
?>


<div class="row" id="toni-breadcrumb">
    <div class="col-6">
        <h4 class="text-dark mt-2">Pengguna</h4>
    </div>  
    <div class="col-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="<?php echo(site_url()) ?>">Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo(site_url('pengguna')) ?>">Pengguna</a></li>
        <li class="breadcrumb-item active" id="lblactive"></li>
      </ol>
      
    </div>
  </div>

  <div class="row" id="toni-content">
    <div class="col-md-12">
      <form action="<?php echo(site_url('pengguna/simpan')) ?>" method="post" id="form" enctype="multipart/form-data">                      
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

                  <input type="hidden" name="idpengguna" id="idpengguna">                      

                  <div class="col-12">
                    <div class="row">
                      
                      <div class="col-md-4">
                        <div class="card">
                          <div class="card-body">
                              
                              <div class="form-group row text center">
                                <label for="" class="col-md-12 col-form-label">Foto Pengguna <span style="color: red; font-size: 12px; font-weight: bold;"><i> Max ukuran file 2MB</i></span></label>
                                <div class="col-md-12 mt-3 text-center">
                                  <img src="<?php echo base_url('../images/users1.png'); ?>" id="output1" class="img-thumbnail" style="width:70%;max-height:70%;">
                                  <div class="form-group">
                                      <span class="btn btn-primary btn-file btn-block;" style="width:70%;">
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

                          </div>
                        </div>
                      </div>

                      <div class="col-md-8">                        
                        <div class="card">
                          <div class="card-body">
                            <div class="form-group row required">
                              <label for="" class="col-md-3 col-form-label">Nama Pengguna</label>
                              <div class="col-md-9">
                                <input type="text" name="namapengguna" id="namapengguna" class="form-control" placeholder="Masukkan namapengguna">
                              </div>
                            </div>                      
                            <div class="form-group row required">
                              <label for="" class="col-md-3 col-form-label">Jenis Kelamin</label>
                              <div class="col-md-9">
                                <select name="jk" id="jk" class="form-control">
                                  <option value="">Pilih jenis kelamin...</option>
                                  <option value="Laki-laki">Laki-laki</option>
                                  <option value="Perempuan">Perempuan</option>
                                </select>
                              </div>
                            </div>                      
                            <div class="form-group row required">
                              <label for="" class="col-md-3 col-form-label">Email</label>
                              <div class="col-md-9">
                                <input type="email" name="email" id="email" class="form-control" placeholder="emailcontoh@gmail.com">
                              </div>
                            </div>                      
                            <div class="form-group row required">
                              <label for="" class="col-md-3 col-form-label">Username</label>
                              <div class="col-md-9">
                                <input type="text" name="username" id="username" class="form-control" placeholder="username">
                              </div>
                            </div>                      
                            <div class="form-group row required">
                              <label for="" class="col-md-3 col-form-label">Password</label>
                              <div class="col-md-9">
                                <input type="password" name="password" id="password" class="form-control" placeholder="**************">
                              </div>
                            </div>
                            <div class="form-group row required">
                              <label for="" class="col-md-3 col-form-label">Ulangi Password</label>
                              <div class="col-md-9">
                                <input type="password" name="password2" id="password2" class="form-control" placeholder="**************">
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
                <a href="<?php echo(site_url('pengguna')) ?>" class="btn btn-default float-right mr-1 ml-1"><i class="fa fa-chevron-circle-left"></i> Kembali</a>
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
  
  var idpengguna = "<?php echo($idpengguna) ?>";

  $(document).ready(function() {

    $('.select2').select2();

    //---------------------------------------------------------> JIKA EDIT DATA
    if ( idpengguna != "" ) { 
          $.ajax({
              type        : 'POST', 
              url         : '<?php echo site_url("Pengguna/get_edit_data") ?>', 
              data        : {idpengguna: idpengguna}, 
              dataType    : 'json', 
              encode      : true
          })      
          .done(function(result) {
            $("#idpengguna").val(result.idpengguna);
            $("#namapengguna").val(result.namapengguna);
            $("#jk").val(result.jk);
            $("#email").val(result.email);
            $("#username").val(result.username);

            $("#foto").val(result.foto);
            $('#file_lama').val(result.foto);

            if ( result.foto != '' && result.foto != null ) {
                $("#output1").attr("src","<?php echo(base_url('../uploads/pengguna/')) ?>" + result.foto);              
            }else{
                $("#output1").attr("src","<?php echo(base_url('../images/users1.png')) ?>");    
            }


          }); 


          $("#lbljudul").html("Edit Data Pengguna");
          $("#lblactive").html("Edit");

    }else{
          $("#lbljudul").html("Tambah Data Pengguna");
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
        namapengguna: {
          validators:{
            notEmpty: {
                message: "nama pengguna tidak boleh kosong"
            },
          }
        },
        jk: {
          validators:{
            notEmpty: {
                message: "jenis kelamin tidak boleh kosong"
            },
          }
        },
        email: {
          validators:{
            notEmpty: {
                message: "email tidak boleh kosong"
            },
          }
        },
        username: {
          validators:{
            notEmpty: {
                message: "username tidak boleh kosong"
            },
          }
        },
        password: {
          validators:{
            notEmpty: {
                message: "password tidak boleh kosong"
            },
          }
        },
        password2: {
          validators:{
            notEmpty: {
                message: "ulangi password tidak boleh kosong"
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
