<?php
$this->load->view("template/header");
$this->load->view("template/topmenu");
$this->load->view("template/sidemenu");
?>


<div class="row" id="toni-breadcrumb">
    <div class="col-6">
        <h4 class="text-dark mt-2">Pages</h4>
    </div>
    <div class="col-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="<?php echo (site_url()) ?>">Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo (site_url('pages')) ?>">Pages</a></li>
        <li class="breadcrumb-item active" id="lblactive"></li>
      </ol>

    </div>
  </div>

  <div class="row" id="toni-content">
    <div class="col-md-12">
      <form action="<?php echo (site_url('pages/simpan')) ?>" method="post" id="form" enctype="multipart/form-data">
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

                  <input type="hidden" name="idpage" id="idpage">
                  <input type="hidden" id="tglpublish" name="tglpublish">

                  <div class="form-group row required">
                    <label for="" class="col-md-3 col-form-label">Judul</label>
                    <div class="col-md-9 row">
                      <div class="col-md-12">
                        <input type="text" name="judulpage" id="judulpage" class="form-control" placeholder="Judul">
                      </div>
                      <div class="col-md-12">
                            <label for="">Link Url: <a href="" id="judulpageseo" target="_blank"></a></label>
                      </div>
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
                    <label for="" class="col-md-12 col-form-label">Isi Pages</label>
                    <div class="col-md-12">
                      <textarea name="isipage" id="isipage" class="form-control" rows="10" placeholder="Isi page"></textarea>
                    </div>
                  </div>

                  <div class="form-group row text center">
                      <label for="" class="col-md-12 col-form-label">Gambar Sampul <span style="color: red; font-size: 12px; font-weight: bold;"><i> Max ukuran file 2MB</i></span></label>
                      <div class="col-md-12 mt-3 text-center">
                        <img src="<?php echo base_url('../images/nofoto.png'); ?>" id="output1" class="img-thumbnail" style="width:30%;max-height:30%;">
                        <div class="form-group">
                            <span class="btn btn-primary btn-file btn-block;" style="width:30%;">
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
                <a href="<?php echo (site_url('pages')) ?>" class="btn btn-default float-right mr-1 ml-1"><i class="fa fa-chevron-circle-left"></i> Kembali</a>
              </div>
            </div> <!-- /.card -->
          </div> <!-- /.col -->
        </div>
      </form>
    </div>
  </div> <!-- /.row -->
  <!-- Main row -->


<?php $this->load->view("template/footer")?>



<script type="text/javascript">

  var idpage = "<?php echo ($idpage) ?>";

  $(document).ready(function() {

    $('.select2').select2();

    //---------------------------------------------------------> JIKA EDIT DATA
    if ( idpage != "" ) {
          $.ajax({
              type        : 'POST',
              url         : '<?php echo site_url("Pages/get_edit_data") ?>',
              data        : {idpage: idpage},
              dataType    : 'json',
              encode      : true
          })
          .done(function(result) {
            $("#idpage").val(result.idpage);
            $("#judulpage").val(result.judulpage);
            $("#judulpageseo").html(result.judulpageseo);
            $("#isipage").val(result.isipage);
            $("#gambarsampul").val(result.gambarsampul);
            $("#ispublish").val(result.ispublish);
            $("#tglpublish").val(result.tglpublish);

            $('#file_lama').val(result.gambarsampul);

            if ( result.gambarsampul != '' && result.gambarsampul != null ) {
                $("#output1").attr("src","<?php echo (base_url('../uploads/pages/')) ?>" + result.gambarsampul);
            }else{
                $("#output1").attr("src","<?php echo (base_url('../images/nofoto.png')) ?>");
            }


            CKEDITOR.replace('isipage' ,{
                filebrowserImageBrowseUrl : '<?php echo base_url('uploads/gallery'); ?>',
                height : ['400px'],
              });
            CKEDITOR.instances.isipage.setData( result.isipage );

          });


          $("#lbljudul").html("Edit Pages");
          $("#lblactive").html("Edit");

    }else{

        CKEDITOR.replace('isipage' ,{
              filebrowserImageBrowseUrl : '<?php echo base_url('uploads/gallery'); ?>',
              height : ['400px'],
            });

          $("#lbljudul").html("Tambah Pages");
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
        judulpage: {
          validators:{
            notEmpty: {
                message: "judulpage tidak boleh kosong"
            },
          }
        },
        isipage: {
          validators:{
            notEmpty: {
                message: "isipage tidak boleh kosong"
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
