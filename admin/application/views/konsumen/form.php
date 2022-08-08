<?php  
  $this->load->view("template/header");
  $this->load->view("template/topmenu");
  $this->load->view("template/sidemenu");
?>


<div class="row" id="toni-breadcrumb">
    <div class="col-6">
        <h4 class="text-dark mt-2">Konsumen</h4>
    </div>  
    <div class="col-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="<?php echo(site_url()) ?>">Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo(site_url('konsumen')) ?>">Konsumen</a></li>
        <li class="breadcrumb-item active" id="lblactive"></li>
      </ol>
      
    </div>
  </div>

  <div class="row" id="toni-content">
    <div class="col-md-12">
      <form action="<?php echo(site_url('konsumen/simpan')) ?>" method="post" id="form" enctype="multipart/form-data">                      
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

                  <input type="hidden" name="idkonsumen" id="idkonsumen">                      

                  <div class="col-12">
                    <div class="row">
                      
                      <div class="col-md-4">
                        <div class="card">
                          <div class="card-body">
                              
                              <div class="form-group row text center">
                                <label for="" class="col-md-12 col-form-label">Foto Konsumen <span style="color: red; font-size: 12px; font-weight: bold;"><i> Max ukuran file 2MB</i></span></label>
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
                            <h5 class="text-gray mt-3 mb-3">Informasi Konsumen</h5>
                            <div class="form-group row required">
                              <label for="" class="col-md-3 col-form-label">Nama Konsumen</label>
                              <div class="col-md-9">
                                <input type="text" name="namakonsumen" id="namakonsumen" class="form-control" placeholder="nama konsumen">
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
                              <label for="" class="col-md-3 col-form-label">No Telp</label>
                              <div class="col-md-9">
                                <input type="text" name="notelp" id="notelp" class="form-control" placeholder="0210292999">
                              </div>
                            </div>

                            <div class="form-group row required">
                              <label for="" class="col-md-3 col-form-label">WhatsApp</label>
                              <div class="col-md-9">
                                <input type="text" name="nowa" id="nowa" class="form-control" placeholder="+6281210938899">
                              </div>
                            </div>


                            <h5 class="text-gray mt-3 mb-3">Data Pengiriman Barang</h5>                      
                            <div class="form-group row required">
                              <label for="" class="col-md-3 col-form-label">Negara</label>
                              <div class="col-md-9">
                                <input type="text" name="negara" id="negara" class="form-control" placeholder="Indonesia">
                              </div>
                            </div>
                            <div class="form-group row required">
                              <label for="" class="col-md-3 col-form-label">Provinsi</label>
                              <div class="col-md-9">
                                <input type="text" name="propinsi" id="propinsi" class="form-control" placeholder="Jawa Barat">
                              </div>
                            </div>
                            <div class="form-group row required">
                              <label for="" class="col-md-3 col-form-label">Kota</label>
                              <div class="col-md-9">
                                <input type="text" name="kota" id="kota" class="form-control" placeholder="Bandung">
                              </div>
                            </div>
                            <div class="form-group row required">
                              <label for="" class="col-md-3 col-form-label">Desa/ Kelurahan</label>
                              <div class="col-md-9">
                                <input type="text" name="desa" id="desa" class="form-control" placeholder="Cileduk">
                              </div>
                            </div>
                            <div class="form-group row required">
                              <label for="" class="col-md-3 col-form-label">Alamat</label>
                              <div class="col-md-9">
                                <textarea name="alamatpengiriman" id="alamatpengiriman" class="form-control" rows="3" placeholder="Jl. Patimura N0. 23 RTRW 02/03 Blok B23"></textarea>
                              </div>
                            </div>

                            <h5 class="text-gray mt-3">Informasi Login</h5>
                            <?php  
                              if (!empty($idkonsumen)) {
                                echo '
                                  <span class="text-danger">Kosongkan password jika tidak ingin ubah password</span>
                                ';
                              }
                            ?>

                            <div class="form-group mt-3 row required">
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
                <a href="<?php echo(site_url('konsumen')) ?>" class="btn btn-default float-right mr-1 ml-1"><i class="fa fa-chevron-circle-left"></i> Kembali</a>
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
  
  var idkonsumen = "<?php echo($idkonsumen) ?>";

  $(document).ready(function() {

    $('.select2').select2();

    //---------------------------------------------------------> JIKA EDIT DATA
    if ( idkonsumen != "" ) { 
          $.ajax({
              type        : 'POST', 
              url         : '<?php echo site_url("Konsumen/get_edit_data") ?>', 
              data        : {idkonsumen: idkonsumen}, 
              dataType    : 'json', 
              encode      : true
          })      
          .done(function(result) {
            $("#idkonsumen").val(result.idkonsumen);
            $("#namakonsumen").val(result.namakonsumen);
            $("#jk").val(result.jk);
            $("#email").val(result.email);
            $("#negara").val(result.negara);
            $("#propinsi").val(result.propinsi);
            $("#kota").val(result.kota);
            $("#desa").val(result.desa);
            $("#alamatpengiriman").val(result.alamatpengiriman);
            $("#notelp").val(result.notelp);
            $("#nowa").val(result.nowa);
            $("#username").val(result.username);

            $("#foto").val(result.foto);
            $('#file_lama').val(result.foto);

            if ( result.foto != '' && result.foto != null ) {
                $("#output1").attr("src","<?php echo(base_url('../uploads/konsumen/')) ?>" + result.foto);              
            }else{
                $("#output1").attr("src","<?php echo(base_url('../images/users1.png')) ?>");    
            }


          }); 


          $("#lbljudul").html("Edit Data Konsumen");
          $("#lblactive").html("Edit");

    }else{
          $("#lbljudul").html("Tambah Data Konsumen");
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
        namakonsumen: {
          validators:{
            notEmpty: {
                message: "nama konsumen tidak boleh kosong"
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
