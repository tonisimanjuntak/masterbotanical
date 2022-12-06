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
        <div class="row">
          <div class="col-md-12">
            <div class="card" id="cardcontent">
              <div class="card-body">


                <form action="<?php echo (site_url('video/simpan')) ?>" method="post" id="form" enctype="multipart/form-data">
                  <div class="row">
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
                        <label for="" class="col-md-3 col-form-label">Gambar Sampul</label>
                        <div class="col-md-9">
                              <input type="file" name="file" id="file" accept="image/*" onchange="loadFile1(event)">
                              <input type="hidden"  name="file_lama" id="file_lama" class="form-control" />
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="" class="col-md-3 col-form-label">URL Video</label>
                        <div class="col-md-9">
                          <input type="text" name="urlvideo" id="urlvideo" class="form-control" placeholder="https://www.youtube.com/watch?v=sEskE9KeJJw">
                        </div>
                      </div>

                    </div>

                    <div class="col-12">
                     <button type="submit" class="btn btn-success float-right"><i class="fa fa-save"></i> Simpan</button>
                    </div>                  
                  </div>
                </form>

                <div class="row mt-5">
                  <div class="col-12">
                    <div class="table-responsive">
                      <table class="table table-bordered table-striped table-condesed" id="table">
                        <thead>
                           <tr class="bg-success" style="">
                            <th style="width: 5%; text-align: center;">NO</th>
                            <th style="width: 15%; text-align: center;">GAMBAR SAMPUL</th>
                            <th style="text-align: center;">URL VIDEO</th>
                            <th style="text-align: center; width: 15%;">AKSI</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php 
                            $rsVideo = $this->db->query("
                                select * from utilvideo order by idutilvideo
                              ");
                            if ($rsVideo->num_rows()>0) {
                              $no=1;
                              $sampulvideo = base_url('images/nofoto.png');
                              if (!empty($row->sampulvideo)) {
                                $sampulvideo = base_url('../uploads/video/'.$row->sampulvideo);
                              }
                              foreach ($rsVideo->result() as $row) {
                                echo '
                                  <tr style="">
                                    <td style="width: 5%; text-align: center;">'.$no++.'</td>
                                    <td style="width: 15%; text-align: center;"><img src="'.$sampulvideo.'" alt="" style="width: 80%;"></td>
                                    <td style="text-align: center;"><a href="'.$row->urlvideo.'" target="_blank">'.$row->urlvideo.'</a></td>
                                    <td style="text-align: center; width: 15%;"><a href="'.site_url('video/hapus/'.$this->encrypt->encode($row->idutilvideo)).'" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a></td>
                                  </tr>
                                ';
                              }
                            }
                          ?>
                        </tbody>
                      </table>
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


<?php $this->load->view("template/footer")?>



<script type="text/javascript">

  // console.log(fontAwesomeIcon);

  $(document).ready(function() {
    $('.select2').select2();
    table = $("#table").DataTable();

    //----------------------------------------------------------------- > validasi
    $("#form").bootstrapValidator({
      feedbackIcons: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
      },
      fields: {
        urlvideo: {
          validators:{
            notEmpty: {
                message: "urlvideo tidak boleh kosong"
            },
          }
        },
      }
    });

    $("form").attr('autocomplete', 'off');
  }); //end (document).ready


</script>

</body>
</html>
