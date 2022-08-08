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
      <form action="<?php echo(site_url('company/simpan')) ?>" method="post" id="form" enctype="multipart/form-data">                      
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
                    
                    <div class="col-md-4">
                      <div class="card">
                        <div class="card-body">
                            
                            <div class="form-group row text center">
                                <label for="" class="col-md-12 col-form-label">Logo Usaha <span style="color: red; font-size: 12px; font-weight: bold;"><i> Max ukuran file 2MB</i></span></label>
                                <div class="col-md-12 mt-3 text-center">
                                  <?php  
                                    if (!empty($rowcompany->logo)) {
                                      $logo = base_url('../uploads/company/'.$rowcompany->logo);
                                    }else{
                                      $logo = base_url('../images/uploadimages.jpg');
                                    }
                                  ?>
                                  <img src="<?php echo $logo; ?>" id="output1" class="img-thumbnail" style="width:70%;max-height:70%;">
                                  <div class="form-group">
                                      <span class="btn btn-primary btn-file btn-block;" style="width:70%;">
                                        <span class="fileinput-new"><span class="fa fa-camera"></span> Upload Gambar</span>
                                        <input type="file" name="file" id="file" accept="image/*" onchange="loadFile1(event)">
                                        <input type="hidden" value="" name="file_lama" id="file_lama" class="form-control" value="<?php echo $rowcompany->logo ?>" />
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
                            
                            <input type="hidden" name="namacompany" id="namacompany" class="form-control" placeholder="nama usaha" value="<?php echo $rowcompany->namacompany ?>">
                                                  
                            <div class="form-group row required">
                              <label for="" class="col-md-3 col-form-label">Alamat Usaha</label>
                              <div class="col-md-9">
                                <input type="text" name="alamatcompany" id="alamatcompany" class="form-control" placeholder="alamat usaha" value="<?php echo $rowcompany->alamatcompany ?>">
                              </div>
                            </div>                      
                            <div class="form-group row required">
                              <label for="" class="col-md-3 col-form-label">Nomor Telp.</label>
                              <div class="col-md-9">
                                <input type="text" name="notelp" id="notelp" class="form-control" placeholder="+6281300000000" value="<?php echo $rowcompany->notelp ?>">
                              </div>
                            </div>                      
                            <div class="form-group row required">
                              <label for="" class="col-md-3 col-form-label">Nomor Fax</label>
                              <div class="col-md-9">
                                <input type="text" name="nofax" id="nofax" class="form-control" placeholder="+6265621000000" value="<?php echo $rowcompany->nofax ?>">
                              </div>
                            </div>                      


                            <h5 class="mt-5 mb-3">Sosial Media</h5><hr>
                            <div class="form-group row required">
                              <label for="" class="col-md-3 col-form-label">Url Facebook</label>
                              <div class="col-md-9">
                                <input type="text" name="facebookcompany" id="facebookcompany" class="form-control" placeholder="https://facebook.com" value="<?php echo($rowcompany->facebookcompany) ?>">
                              </div>
                            </div>                      
                            <div class="form-group row required">
                              <label for="" class="col-md-3 col-form-label">Url Tweeter</label>
                              <div class="col-md-9">
                                <input type="text" name="tweetercompany" id="tweetercompany" class="form-control" placeholder="https://tweeter.com" value="<?php echo $rowcompany->tweetercompany ?>">
                              </div>
                            </div>                      
                            <div class="form-group row required">
                              <label for="" class="col-md-3 col-form-label">Url Instagram</label>
                              <div class="col-md-9">
                                <input type="text" name="instagramcompany" id="instagramcompany" class="form-control" placeholder="https://instagram.com" value="<?php echo($rowcompany->instagramcompany) ?>">
                              </div>
                            </div>                      
                            <div class="form-group row required">
                              <label for="" class="col-md-3 col-form-label">Email</label>
                              <div class="col-md-9">
                                <input type="email" name="emailcompany" id="emailcompany" class="form-control" placeholder="contohemail@gmail.com" value="<?php echo($rowcompany->emailcompany) ?>">
                              </div>
                            </div>

                            <h5 class="mt-5 mb-3">Informasi Lainnya</h5><hr>
                            <div class="form-group row required">
                              <label for="" class="col-md-3 col-form-label">Simbol Mata Uang</label>
                              <div class="col-md-2">
                                <input type="text" name="matauang" id="matauang" class="form-control" placeholder="Rp." value="<?php echo($rowcompany->matauang) ?>">
                              </div>

                        </div>
                      </div>
                    </div>
                  </div>



                  
              </div> <!-- ./card-body -->

              <div class="card-footer">
                 <button type="submit" class="btn btn-success float-right"><i class="fa fa-save"></i> Simpan</button>
                <a href="<?php echo(site_url('company')) ?>" class="btn btn-default float-right mr-1 ml-1"><i class="fa fa-chevron-circle-left"></i> Kembali</a>
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
        alamatcompany: {
          validators:{
            notEmpty: {
                message: "alamat company tidak boleh kosong"
            },
          }
        },
        notelp: {
          validators:{
            notEmpty: {
                message: "no telp tidak boleh kosong"
            },
          }
        },
        logo: {
          validators:{
            notEmpty: {
                message: "logo tidak boleh kosong"
            },
          }
        },
        facebookcompany: {
          validators:{
            notEmpty: {
                message: "facebook tidak boleh kosong"
            },
          }
        },
        tweetercompany: {
          validators:{
            notEmpty: {
                message: "tweeter tidak boleh kosong"
            },
          }
        },
        instagramcompany: {
          validators:{
            notEmpty: {
                message: "instagram tidak boleh kosong"
            },
          }
        },
        emailcompany: {
          validators:{
            notEmpty: {
                message: "email usaha tidak boleh kosong"
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
