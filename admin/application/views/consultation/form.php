<?php
$this->load->view("template/header");
$this->load->view("template/topmenu");
$this->load->view("template/sidemenu");
?>


<div class="row" id="toni-breadcrumb">
    <div class="col-6">
        <h4 class="text-dark mt-2">Konsultasi</h4>
    </div>
    <div class="col-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="<?php echo (site_url()) ?>">Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo (site_url('consultation')) ?>">Konsultasi</a></li>
        <li class="breadcrumb-item active" id="lblactive">Balas Konsultasi</li>
      </ol>

    </div>
  </div>

  <div class="row" id="toni-content">
    <div class="col-md-12">
      <form action="<?php echo (site_url('consultation/simpan')) ?>" method="post" id="form" enctype="multipart/form-data">
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
                  </div>

                  <input type="hidden" name="idconsultation" id="idconsultation" value="<?php echo $rowconsultation->idconsultation ?>">


                  <div class="col-12">
                    <h3>Informasi Konsultasi Konsumen</h3>
                    <table class="table">
                      <tbody>
                        <tr>
                          <td style="width: 20%;">Tgl Konsultasi</td>
                          <td style="width: 5%;">:</td>
                          <td><?php echo tglindonesia($rowconsultation->tglinsert) ?> </td>
                        </tr>
                        <tr>
                          <td style="width: 20%;">Nama Konsumen</td>
                          <td style="width: 5%;">:</td>
                          <td><?php echo $rowconsultation->consulname ?> </td>
                        </tr>
                        <tr>
                          <td style="width: 20%;">Email Konsumen</td>
                          <td style="width: 5%;">:</td>
                          <td><?php echo $rowconsultation->consulemail ?> </td>
                        </tr>
                        <tr style="font-weight: bold;">
                          <td style="width: 20%;">Pesan</td>
                          <td style="width: 5%;">:</td>
                          <td><?php echo $rowconsultation->consulmessage ?> </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>



                  <div class="col-12">
                    <div class="form-group row required mt-5">
                      <label for="" class="col-md-12 col-form-label">Isi Balasan Email</label>
                      <div class="col-md-12">
                        <textarea name="consulreply" id="consulreply" class="form-control" rows="10" placeholder="Isi balasan email"></textarea>
                      </div>
                    </div>                    
                  </div>
              </div> <!-- ./card-body -->

              <div class="card-footer">
                 <button type="submit" class="btn btn-success float-right"><i class="fa fa-save"></i> Balas</button>
                <a href="<?php echo (site_url('consultation')) ?>" class="btn btn-default float-right mr-1 ml-1"><i class="fa fa-chevron-circle-left"></i> Kembali</a>
              </div>
            </div> <!-- /.card -->
          </div> <!-- /.col -->

          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <h3>Balasan Konsultasi</h3><hr>
                <div class="row mt-5">
                  <?php  
                    if (empty($rowconsultation->consulreply)) {
                      echo '
                        <div class="col-12 p-3">
                          Belum ada balasan...
                        </div>
                      ';
                    }else{
                      echo '
                        <div class="col-12 p-3">
                          '.$rowconsultation->consulreply.'
                        </div>
                      ';
                    }
                    $rsconsultation
                  ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div> <!-- /.row -->
  <!-- Main row -->


<?php $this->load->view("template/footer")?>



<script type="text/javascript">

  var idconsultation = "<?php echo ($idconsultation) ?>";

  $(document).ready(function() {

    $('.select2').select2();

    CKEDITOR.replace('consulreply' ,{
              filebrowserImageBrowseUrl : '<?php echo base_url('.../uploads/galery'); ?>',
              height : ['400px'],
            });

    //----------------------------------------------------------------- > validasi
    $("#form").bootstrapValidator({
      feedbackIcons: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
      },
      fields: {        
        consulreply: {
          validators:{
            notEmpty: {
                message: "consulreply tidak boleh kosong"
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
