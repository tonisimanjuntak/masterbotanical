<?php
$this->load->view("template/header");
$this->load->view("template/topmenu");
$this->load->view("template/sidemenu");
?>


<div class="row" id="toni-breadcrumb">
    <div class="col-6">
        <h4 class="text-dark mt-2">Setting Video</h4>
    </div>
    <div class="col-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="<?php echo (site_url()) ?>">Home</a></li>
        <li class="breadcrumb-item active" id="lblactive">Setting Video</li>
      </ol>

    </div>
  </div>

  <div class="row" id="toni-content">
    <div class="col-md-12">
      <form action="<?php echo (site_url('video/simpan')) ?>" method="post" id="form" enctype="multipart/form-data">
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

                  <div class="col-md-12">
                    
                    <div class="form-group row">
                      <label for="" class="col-md-3 col-form-label">URL Video</label>
                      <div class="col-md-9">
                        <input type="text" name="urlvideo" id="urlvideo" class="form-control" placeholder="https://www.youtube.com/watch?v=sEskE9KeJJw" value="<?php echo $rowvideo->urlvideo ?>">
                      </div>
                    </div>


                    <div class="form-group row text center">
                        <label for="" class="col-md-12 col-form-label">Sampul Video <span style="color: red; font-size: 12px; font-weight: bold;"><i> Max ukuran file 2MB</i></span></label>
                        <div class="col-md-12 mt-3 text-center">
                          <?php    
                              $sampulvideo = '';
                              if (empty($rowvideo->sampulvideo)) {
                                $sampulvideo = base_url('../images/nofoto.png');
                              }else{
                                $sampulvideo = base_url('../uploads/video/'.$rowvideo->sampulvideo);
                              }
                          ?>
                          <img src="<?php echo $sampulvideo ?>" id="output1" class="img-thumbnail" style="width:30%;max-height:30%;">
                          <div class="form-group">
                              <span class="btn btn-primary btn-file btn-block;" style="width:30%;">
                                <span class="fileinput-new"><span class="fa fa-camera"></span> Upload Foto</span>
                                <input type="file" name="file" id="file" accept="image/*" onchange="loadFile1(event)">
                                <input type="hidden"  name="file_lama" id="file_lama" class="form-control" value="<?php   echo $rowvideo->sampulvideo ?>" />
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

  // console.log(fontAwesomeIcon);

  $(document).ready(function() {

    $('.select2').select2();


    $("form").attr('autocomplete', 'off');
    //$("#tanggal").mask("00-00-0000", {placeholder:"hh-bb-tttt"});
    //$("#jumlah").mask("000,000,000,000", {reverse: true});
  }); //end (document).ready


</script>

</body>
</html>
