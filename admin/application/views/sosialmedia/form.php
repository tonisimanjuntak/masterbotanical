<?php
$this->load->view("template/header");
$this->load->view("template/topmenu");
$this->load->view("template/sidemenu");
?>


<div class="row" id="toni-breadcrumb">
    <div class="col-6">
        <h4 class="text-dark mt-2">Sosial Media</h4>
    </div>
    <div class="col-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="<?php echo (site_url()) ?>">Home</a></li>
        <li class="breadcrumb-item active" id="lblactive">Sosial Media</li>
      </ol>

    </div>
  </div>

  <div class="row" id="toni-content">
    <div class="col-md-12">
      <form action="<?php echo (site_url('sosialmedia/simpan')) ?>" method="post" id="form" enctype="multipart/form-data">
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
                      <label for="" class="col-md-3 col-form-label">URL Facebook</label>
                      <div class="col-md-9">
                        <input type="text" name="urlfacebook" id="urlfacebook" class="form-control" placeholder="www.facebook.com/contoh" value="<?php echo $rowsosialmedia->urlfacebook ?>">
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="" class="col-md-3 col-form-label">URL Twitter</label>
                      <div class="col-md-9">
                        <input type="text" name="urltwitter" id="urltwitter" class="form-control" placeholder="www.twitter.com/contoh" value="<?php echo $rowsosialmedia->urltwitter ?>">
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="" class="col-md-3 col-form-label">URL Instagram</label>
                      <div class="col-md-9">
                        <input type="text" name="urlinstagram" id="urlinstagram" class="form-control" placeholder="www.instagram.com/contoh" value="<?php echo $rowsosialmedia->urlinstagram ?>">
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="" class="col-md-3 col-form-label">URL Youtube</label>
                      <div class="col-md-9">
                        <input type="text" name="urlyoutube" id="urlyoutube" class="form-control" placeholder="www.youtube.com/contoh" value="<?php echo $rowsosialmedia->urlyoutube ?>">
                      </div>
                    </div>


                    <div class="form-group row">
                      <label for="" class="col-md-3 col-form-label">URL LinkedIn</label>
                      <div class="col-md-9">
                        <input type="text" name="urllinkedin" id="urllinkedin" class="form-control" placeholder="www.linkedin.com/contoh" value="<?php echo $rowsosialmedia->urllinkedin ?>">
                      </div>
                    </div>


                    <div class="form-group row">
                      <label for="" class="col-md-3 col-form-label">URL Tiktok</label>
                      <div class="col-md-9">
                        <input type="text" name="urltiktok" id="urltiktok" class="form-control" placeholder="www.tiktok.com/contoh" value="<?php echo $rowsosialmedia->urltiktok ?>">
                      </div>
                    </div>


                    <div class="form-group row">
                      <label for="" class="col-md-3 col-form-label">Nomor Telp/ WA (1)</label>
                      <div class="col-md-9">
                        <input type="text" name="notelp" id="notelp" class="form-control" placeholder="+62 8123456789" value="<?php echo $rowsosialmedia->notelp ?>">
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="" class="col-md-3 col-form-label">Nomor Telp/ WA (2)</label>
                      <div class="col-md-9">
                        <input type="text" name="notelp2" id="notelp2" class="form-control" placeholder="+62 8123456789" value="<?php echo $rowsosialmedia->notelp2 ?>">
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="" class="col-md-3 col-form-label">Nomor Telp/ WA (3)</label>
                      <div class="col-md-9">
                        <input type="text" name="notelp3" id="notelp3" class="form-control" placeholder="+62 8123456789" value="<?php echo $rowsosialmedia->notelp3 ?>">
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="" class="col-md-3 col-form-label">Email</label>
                      <div class="col-md-9">
                        <input type="text" name="email" id="email" class="form-control" placeholder="contoh@masterbotanical.com" value="<?php echo $rowsosialmedia->email ?>">
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
