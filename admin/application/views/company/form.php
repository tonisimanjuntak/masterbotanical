<?php  
  $this->load->view("template/header");
  $this->load->view("template/topmenu");
  $this->load->view("template/sidemenu");
?>


<div class="row" id="toni-breadcrumb">
    <div class="col-6">
        <h4 class="text-dark mt-2">Informasi Usaha</h4>
    </div>  
    <div class="col-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="<?php echo(site_url()) ?>">Home</a></li>
        <li class="breadcrumb-item active">Informasi Usaha</li>
      </ol>
      
    </div>
  </div>

  <div class="row" id="toni-content">
    <div class="col-md-12">
      

        <div class="row">
          <div class="col-md-12">
            <div class="card" id="cardcontent">
              <div class="card-body">

                  <div class="col-md-12">
                    <?php 
                      $pesan = $this->session->flashdata("pesan");
                      if (!empty($pesan)) {
                        echo $pesan;

                        echo '<div>
                                  <div class="alert alert-warning">
                                      Silahkan Logout dan Login kembali untuk memuat kembali session yang tersimpan
                                  </div>
                              </div>';
                      }
                    ?>
                  </div> 

                  <div class="row">
                    
                    

                    <div class="col-md-12">
                      <form action="<?php echo(site_url('company/simpan')) ?>" method="post" id="form" enctype="multipart/form-data">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                  <div class="col-12">
                                    <h5>Pengaturan Aplikasi</h5><hr>                                
                                  </div>
                                  <div class="col-md-8">                                
                                    <div class="form-group row required">
                                      <label for="" class="col-md-3 col-form-label">Nama Usaha</label>
                                      <div class="col-md-9">
                                        <input type="text" name="namacompany" id="namacompany" class="form-control" placeholder="Nama usaha" value="<?php echo $rowcompany->namacompany ?>">
                                      </div>
                                    </div>
                                    <div class="form-group row required">
                                      <label for="" class="col-md-3 col-form-label">Alamat Usaha</label>
                                      <div class="col-md-9">
                                        <textarea name="alamatcompany" id="alamatcompany" class="form-control" rows="3" placeholder="Alamat usaha"><?php echo $rowcompany->alamatcompany ?></textarea>
                                      </div>
                                    </div>                      

                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group row required">
                                      <label for="" class="col-md-3 col-form-label">Simbol Mata Uang</label>
                                      <div class="col-md-2">
                                        <input type="text" name="matauang" id="matauang" class="form-control" placeholder="Rp." value="<?php echo($rowcompany->matauang) ?>">
                                      </div>

                                    </div>                                
                                  </div>
                                  <div class="col-12">
                                    <button type="submit" class="btn btn-success float-right"><i class="fa fa-save"></i> Simpan</button>
                                    <a href="<?php echo(site_url('company')) ?>" class="btn btn-default float-right mr-1 ml-1"><i class="fa fa-chevron-circle-left"></i> Kembali</a>
                                  </div>
                                </div>         

                          </div>
                        </div> <!-- card -->
                      </form>

                    </div>

                    <div class="col-12">
                      <div class="card">
                        <div class="card-body">
                          <div class="row">
                            <div class="col-12 mb-3">
                              <h5>PENGATURAN GAMBAR/ IMAGE <span style="color: red; font-size: 12px; font-weight: bold;"><i> Max ukuran file 2MB</i></span></h5>

                            </div>

                            <div class="col-md-2">
                              <form action="<?php echo site_url('company/simpanLogoUsaha') ?>" method="POST" id="formLogoUsaha" enctype="multipart/form-data">
                                <div class="card">
                                  <div class="card-body" style="height: 300px;">                                    
                                      <div class="form-group row text center">
                                          <div class="col-12">
                                            <h5 class="text-center">Logo Usaha</h5>
                                          </div>
                                          <div class="col-md-12 mt-3 text-center">
                                            <?php  
                                              if (!empty($rowsetting->logousaha)) {
                                                $logo = base_url('../uploads/pengaturan/'.$rowsetting->logousaha);
                                              }else{
                                                $logo = base_url('../images/uploadimages.jpg');
                                              }
                                            ?>
                                            <img src="<?php echo $logo; ?>" class="img-thumbnail" style="width:90%;height:150px;">
                                            <div class="form-group">
                                                <span class="btn btn-primary btn-file btn-block;" style="width:90%;">
                                                  <span class="fileinput-new"><span class="fa fa-camera"></span> Upload Gambar</span>
                                                  <input type="file" name="fileLogoUsaha" id="fileLogoUsaha" accept="image/*" onchange="this.form.submit()">
                                                  <input type="hidden" value="" name="fileLogoUsaha_old" id="fileLogoUsaha_old" class="form-control" value="<?php echo $rowsetting->logousaha ?>" />
                                                </span>
                                            </div>
                                          </div>
                                      </div>
                                  </div>
                                </div>                              
                              </form>
                            </div>

                            <div class="col-md-2">
                              <form action="<?php echo site_url('company/simpanLogoTab') ?>" method="POST" id="formLogoTab" enctype="multipart/form-data">
                                <div class="card">
                                  <div class="card-body" style="height: 300px;">                                    
                                      <div class="form-group row text center">
                                          <div class="col-12">
                                            <h5 class="text-center">Logo Tab</h5>
                                          </div>
                                          <div class="col-md-12 mt-3 text-center">
                                            <?php  
                                              if (!empty($rowsetting->logotab)) {
                                                $logo = base_url('../uploads/pengaturan/'.$rowsetting->logotab);
                                              }else{
                                                $logo = base_url('../images/uploadimages.jpg');
                                              }
                                            ?>
                                            <img src="<?php echo $logo; ?>" class="img-thumbnail" style="width:90%;height:150px;">
                                            <div class="form-group">
                                                <span class="btn btn-primary btn-file btn-block;" style="width:90%;">
                                                  <span class="fileinput-new"><span class="fa fa-camera"></span> Upload Gambar</span>
                                                  <input type="file" name="fileLogoTab" id="fileLogoTab" accept="image/*" onchange="this.form.submit()">
                                                  <input type="hidden" value="" name="fileLogoTab_old" id="fileLogoTab_old" class="form-control" value="<?php echo $rowsetting->logotab ?>" />
                                                </span>
                                            </div>
                                          </div>
                                      </div>
                                  </div>
                                </div>                              
                              </form>
                            </div>


                            <div class="col-md-2">
                              <form action="<?php echo site_url('company/simpanLogoFreecon') ?>" method="POST" id="formLogoFreecon" enctype="multipart/form-data">
                                <div class="card">
                                  <div class="card-body" style="height: 300px;">                                    
                                      <div class="form-group row text center">
                                          <div class="col-12">
                                            <h5 class="text-center">Free Consultation</h5>
                                          </div>
                                          <div class="col-md-12 mt-3 text-center">
                                            <?php  
                                              if (!empty($rowsetting->logofreeconsultation)) {
                                                $logo = base_url('../uploads/pengaturan/'.$rowsetting->logofreeconsultation);
                                              }else{
                                                $logo = base_url('../images/uploadimages.jpg');
                                              }
                                            ?>
                                            <img src="<?php echo $logo; ?>" class="img-thumbnail" style="width:90%;height:150px;">
                                            <div class="form-group">
                                                <span class="btn btn-primary btn-file btn-block;" style="width:90%;">
                                                  <span class="fileinput-new"><span class="fa fa-camera"></span> Upload Gambar</span>
                                                  <input type="file" name="fileLogoFreecon" id="fileLogoFreecon" accept="image/*" onchange="this.form.submit()">
                                                  <input type="hidden" value="" name="fileLogoFreecon_old" id="fileLogoFreecon_old" class="form-control" value="<?php echo $rowsetting->logofreeconsultation ?>" />
                                                </span>
                                            </div>
                                          </div>
                                      </div>
                                  </div>
                                </div>                              
                              </form>
                            </div>

                          </div>
                        </div>
                      </div>
                    </div>



                  
              </div> <!-- ./card-body -->

            </div> <!-- /.card -->
          </div> <!-- /.col -->
        </div>
    </div>
  </div> <!-- /.row -->
  <!-- Main row -->



<?php $this->load->view("template/footer") ?>



<script type="text/javascript">
  

  $(document).ready(function() {

    $('.select2').select2();

    //----------------------------------------------------------------- > validasi
    $("#form").bootstrapValidator({
      feedbackIcons: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
      },
      fields: {
        namacompany: {
          validators:{
            notEmpty: {
                message: "nama usaha tidak boleh kosong"
            },
          }
        },        
        matauang: {
          validators:{
            notEmpty: {
                message: "mata uang tidak boleh kosong"
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
