<?php  
  $this->load->view("template/header");
  $this->load->view("template/topmenu");
  $this->load->view("template/sidemenu");
?>


<div class="row" id="toni-breadcrumb">
    <div class="col-6">
        <h4 class="text-dark mt-2">Blogs</h4>
    </div>  
    <div class="col-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="<?php echo(site_url()) ?>">Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo(site_url('Blogs')) ?>">Blogs</a></li>
        <li class="breadcrumb-item active" id="lblactive"></li>
      </ol>
      
    </div>
  </div>

  <div class="row" id="toni-content">
    <div class="col-md-12">
      <form action="<?php echo(site_url('Blogs/simpan')) ?>" method="post" id="form" enctype="multipart/form-data">                      
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

                  <input type="hidden" name="idblogs" id="idblogs">                      
                  <div class="form-group row required">
                    <label for="" class="col-md-3 col-form-label">Judul</label>
                    <div class="col-md-9">
                      <input type="text" name="judulblogs" id="judulblogs" class="form-control" placeholder="Judul">
                    </div>
                  </div>                      

                  <div class="form-group row required">
                    <label for="" class="col-md-3 col-form-label">Publish</label>
                    <div class="col-md-9">
                      <select name="ispublish" id="ispublish" class="form-control">
                        <option value="Ya">Ya</option>
                        <option value="Tidak">Tidak</option>
                      </select>
                    </div>
                  </div>       


                  <div class="form-group row required">
                    <label for="" class="col-md-12 col-form-label">Isi Blog</label>
                    <div class="col-md-12">
                      <textarea name="isiblogs" id="isiblogs" class="form-control" rows="10" placeholder="Isi blog"></textarea>
                    </div>
                  </div>

                  <div class="form-group row">
                      <label for="" class="col-md-3 col-form-label">Gambar Blog <span style="color: red; font-size: 12px; font-weight: bold;"><i> Max ukuran file 2MB</i></span></label>
                      <div class="col-md-12 mt-9 text-center">
                        <img src="<?php echo base_url('../images/uploadimages.jpg'); ?>" id="output1" class="img-thumbnail" style="width:40%;max-height:40%;">
                        <div class="form-group">
                            <span class="btn btn-primary btn-file btn-block;" style="width:40%;">
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


              </div> <!-- ./card-body -->

              <div class="card-footer">
                 <button type="submit" class="btn btn-success float-right"><i class="fa fa-save"></i> Simpan</button>
                <a href="<?php echo(site_url('Blogs')) ?>" class="btn btn-default float-right mr-1 ml-1"><i class="fa fa-chevron-circle-left"></i> Kembali</a>
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
  
  var idblogs = "<?php echo($idblogs) ?>";

  $(document).ready(function() {

    $('.select2').select2();

    //---------------------------------------------------------> JIKA EDIT DATA
    if ( idblogs != "" ) { 
          $.ajax({
              type        : 'POST', 
              url         : '<?php echo site_url("Blogs/get_edit_data") ?>', 
              data        : {idblogs: idblogs}, 
              dataType    : 'json', 
              encode      : true
          })      
          .done(function(result) {
            $("#idblogs").val(result.idblogs);
            $("#judulblogs").val(result.judulblogs);
            $("#isiblogs").val(result.isiblogs);
            $("#tglinsert").val(result.tglinsert);
            $("#tglupdate").val(result.tglupdate);
            $("#idpengguna").val(result.idpengguna);
            $("#ispublish").val(result.ispublish);
            $("#gambarblogs").val(result.gambarblogs);

            $('#file_lama').val(result.gambarblogs);

            if ( result.gambarblogs != '' && result.gambarblogs != null ) {
                $("#output1").attr("src","<?php echo(base_url('../uploads/blogs/')) ?>" + result.gambarblogs);              
            }else{
                $("#output1").attr("src","<?php echo(base_url('../images/uploadimages.jpg')) ?>");    
            }


            CKEDITOR.replace('isiblogs' ,{
                filebrowserImageBrowseUrl : '<?php echo base_url('.../uploads/galery'); ?>',
                height : ['400px'],
              });
            CKEDITOR.instances.isiblogs.setData( result.isiblogs );

          }); 


          $("#lbljudul").html("Edit Blogs");
          $("#lblactive").html("Edit");

    }else{

        CKEDITOR.replace('isiblogs' ,{
              filebrowserImageBrowseUrl : '<?php echo base_url('.../uploads/galery'); ?>',
              height : ['400px'],
            });

          $("#lbljudul").html("Tambah Blogs");
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
        judulblogs: {
          validators:{
            notEmpty: {
                message: "judulblogs tidak boleh kosong"
            },
          }
        },
        isiblogs: {
          validators:{
            notEmpty: {
                message: "isiblogs tidak boleh kosong"
            },
          }
        },
        tglinsert: {
          validators:{
            notEmpty: {
                message: "tglinsert tidak boleh kosong"
            },
          }
        },
        tglupdate: {
          validators:{
            notEmpty: {
                message: "tglupdate tidak boleh kosong"
            },
          }
        },
        idpengguna: {
          validators:{
            notEmpty: {
                message: "idpengguna tidak boleh kosong"
            },
          }
        },
        ispublish: {
          validators:{
            notEmpty: {
                message: "ispublish tidak boleh kosong"
            },
          }
        },
        gambarblogs: {
          validators:{
            notEmpty: {
                message: "gambarblogs tidak boleh kosong"
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
