<?php
$this->load->view("template/header");
$this->load->view("template/topmenu");
$this->load->view("template/sidemenu");
?>


<div class="row" id="toni-breadcrumb">
    <div class="col-6">
        <h4 class="text-dark mt-2">Frequently Asked Question</h4>
    </div>
    <div class="col-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="<?php echo (site_url()) ?>">Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo (site_url('faq')) ?>">Frequently Asked Question</a></li>
        <li class="breadcrumb-item active" id="lblactive"></li>
      </ol>

    </div>
  </div>

  <div class="row" id="toni-content">
    <div class="col-md-12">
      <form action="<?php echo (site_url('faq/simpan')) ?>" method="post" id="form" enctype="multipart/form-data">
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

                  <input type="hidden" name="idfaq" id="idfaq">
                  <input type="hidden" id="tglpublish" name="tglpublish">

                  <div class="form-group row required">
                    <label for="" class="col-md-3 col-form-label">Pertanyaan</label>
                    <div class="col-md-9">
                      <input type="text" name="pertanyaan" id="pertanyaan" class="form-control" placeholder="Pertanyaan">
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
                    <label for="" class="col-md-12 col-form-label">Jawaban</label>
                    <div class="col-md-12">
                      <textarea name="jawaban" id="jawaban" class="form-control" rows="10" placeholder="Jawaban"></textarea>
                    </div>
                  </div>


              </div> <!-- ./card-body -->

              <div class="card-footer">
                 <button type="submit" class="btn btn-success float-right"><i class="fa fa-save"></i> Simpan</button>
                <a href="<?php echo (site_url('faq')) ?>" class="btn btn-default float-right mr-1 ml-1"><i class="fa fa-chevron-circle-left"></i> Kembali</a>
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

  var idfaq = "<?php echo ($idfaq) ?>";

  $(document).ready(function() {

    $('.select2').select2();

    //---------------------------------------------------------> JIKA EDIT DATA
    if ( idfaq != "" ) {
          $.ajax({
              type        : 'POST',
              url         : '<?php echo site_url("faq/get_edit_data") ?>',
              data        : {idfaq: idfaq},
              dataType    : 'json',
              encode      : true
          })
          .done(function(result) {
            $("#idfaq").val(result.idfaq);
            $("#pertanyaan").val(result.pertanyaan);
            $("#jawaban").val(result.jawaban);
            $("#ispublish").val(result.ispublish);


            CKEDITOR.replace('jawaban' ,{
                filebrowserImageBrowseUrl : '<?php echo base_url('.../uploads/galery'); ?>',
                height : ['400px'],
              });
            CKEDITOR.instances.jawaban.setData( result.jawaban );

          });


          $("#lbljudul").html("Edit Frequently Asked Question");
          $("#lblactive").html("Edit");

    }else{

        CKEDITOR.replace('jawaban' ,{
              filebrowserImageBrowseUrl : '<?php echo base_url('.../uploads/galery'); ?>',
              height : ['400px'],
            });

          $("#lbljudul").html("Tambah Frequently Asked Question");
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
        pertanyaan: {
          validators:{
            notEmpty: {
                message: "pertanyaan tidak boleh kosong"
            },
          }
        },
        jawaban: {
          validators:{
            notEmpty: {
                message: "jawaban tidak boleh kosong"
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
