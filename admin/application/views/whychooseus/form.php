<?php
$this->load->view("template/header");
$this->load->view("template/topmenu");
$this->load->view("template/sidemenu");
?>


<div class="row" id="toni-breadcrumb">
    <div class="col-6">
        <h4 class="text-dark mt-2">Why Choose Us?</h4>
    </div>
    <div class="col-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="<?php echo (site_url()) ?>">Home</a></li>
        <li class="breadcrumb-item active" id="lblactive">Why Choose Us?</li>
      </ol>

    </div>
  </div>

  <div class="row" id="toni-content">
    <div class="col-md-12">
      <form action="<?php echo (site_url('whychooseus/simpan')) ?>" method="post" id="form" enctype="multipart/form-data">
        <div class="row">
          <div class="col-md-12">
            <div class="card" id="cardcontent">
              <div class="card-body">

                  <div class="col-md-12">
                    <?php
$pesan = $this->session->flashdata("pesan");
if (!empty($pesan)) {
    echo $pesan;
}
?>

                  
                    <div class="form-group row">
                        <label for="" class="col-md-3 col-form-label">Gambar Sampul <span style="color: red; font-size: 12px; font-weight: bold;"><i> Max ukuran file 2MB</i></span></label>
                        <div class="col-md-9">
                          <div class="row">
                            <div class="col-12">
                              <input type="file" name="file" id="file" accept="image/*">
                            </div>
                            <div class="col-12 mt-3">
                              <img src="<?php echo base_url('../images/nofoto.png'); ?>" id="output1" class="img-thumbnail" style="max-height:120px;">
                              <input type="hidden" value="" name="file_lama" id="file_lama" class="form-control" />
                            </div>
                          </div>
                        </div>
                    </div>

                    <div class="form-group">
                      <label for="">Deskripsi <span class="text-info text-sm"> (max 255 Karakter)</span></label>
                      <textarea name="deskripsi" id="deskripsi" class="form-control" rows="10" placeholder="Deskripsi"></textarea>
                    </div>


                  </div>

                  

              </div> <!-- ./card-body -->

              <div class="card-footer">
                 <button type="submit" class="btn btn-success float-right"><i class="fa fa-save"></i> Simpan</button>
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


  $(document).ready(function() {



    $.ajax({
              type        : 'POST',
              url         : '<?php echo site_url("whychooseus/get_edit_data") ?>',
              dataType    : 'json',
              encode      : true
          })
          .done(function(result) {
            $('#file_lama').val(result.gambarsampul);

            if ( result.gambarsampul != '' && result.gambarsampul != null ) {
                $("#output1").attr("src","<?php echo (base_url('../uploads/whychooseus/')) ?>" + result.gambarsampul);
            }else{
                $("#output1").attr("src","<?php echo (base_url('../images/nofoto.png')) ?>");
            }


            CKEDITOR.replace('deskripsi' ,{
                filebrowserImageBrowseUrl : '<?php echo base_url('../uploads/gallery'); ?>',
                height : ['400px'],
              });
            CKEDITOR.instances.deskripsi.setData( result.deskripsi );

          });



    //----------------------------------------------------------------- > validasi
    $("#form").bootstrapValidator({
      feedbackIcons: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
      },
      fields: {
        deskripsi: {
          validators:{
            notEmpty: {
                message: "deskripsi tidak boleh kosong"
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
