<?php
$this->load->view("template/header");
$this->load->view("template/topmenu");
$this->load->view("template/sidemenu");
?>

  <div class="row" id="toni-breadcrumb">
    <div class="col-6">
        <h4 class="text-dark mt-2">Gallery</h4>
    </div>
    <div class="col-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="<?php echo (site_url()) ?>">Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo (site_url('gallery')) ?>">Gallery</a></li>
        <li class="breadcrumb-item active">Detail Gambar</li>
      </ol>

    </div>
  </div>


  <div class="row" id="toni-content">
    <div class="col-md-12">
        <div class="row">
          <div class="col-md-12">
            <div class="card" id="cardcontent">
              <div class="card-header">
                <h5 class="card-title">Detail Gambar Gallery</h5>
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






                  <div class="col-md-12">



                      <form action="<?php echo (site_url('gallery/simpan')) ?>" method="post" id="form" enctype="multipart/form-data">
                        <div class="row">

                          <div class="col-md-12">
                            <div class="form-group row">
                              <label for="" class="col-form-label col-md-3">Judul Gambar</label>
                              <div class="col-md-9">
                                <input type="text" name="judulgambar" id="judulgambar" class="form-control" placeholder="Judul gambar">
                              </div>
                            </div>
                          </div>

                          <div class="col-md-12">
                            <div class="form-group row">
                              <label for="" class="col-form-label col-md-3">Upload Gambar Gallery</label>
                              <div class="col-md-9">
                                <input type="file" name="filegallery" id="filegallery" class="" accept="image/*">
                              </div>
                            </div>
                          </div>

                          <div class="col-12">
                                <button class="btn btn-primary float-right" type="submit"><i class="fa fa-save"></i> Simpan</button>                            
                          </div>

                        </div>
                      </form>


                          <div class="col-md-12 mt-5">

                            <div class="table-responsive">
                              <table id="table" class="display" style="width: 100%;">
                                  <thead>
                                      <tr>
                                          <th style="width: 5%; text-align: center;">No</th>
                                          <th style="text-align: center;">Gambar</th>
                                          <th style="width: 70%; text-align: left;">Judul Gambar</th>
                                          <th style="text-align: center;">Aksi</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    <?php
$rsgallery = $this->db->query("select * from gallery order by idgallery");
if ($rsgallery->num_rows() > 0) {
    $no = 1;
    foreach ($rsgallery->result() as $row) {
        $filegallery = base_url('../uploads/gallery/' . $row->filegallery);

        echo '
                                            <tr>
                                                <td style="width: 5%; text-align: center;">' . $no++ . '</td>
                                                <td style="text-align: center"><img src="' . $filegallery . '" alt="" style="width:80%;"></td>
                                                <td style="text-align: left;">' . $row->judulgambar . '</td>
                                                <td style="text-align: center;">
                                                  <a href="' . site_url('gallery/delete/' . $this->encrypt->encode($row->idgallery)) . '" class="btn btn-sm btn-danger btn-circle" id="hapus"><i class="fa fa-trash"></i></a>
                                                </td>
                                            </tr>

                                          ';
    }
}else{
    echo '
                                            <tr>
                                                <td style="width: 5%; text-align: center;" colspan="4">Belum ada gallery</td>                                                
                                            </tr>

                                          ';
}
?>
                                  </tbody>
                              </table>
                            </div>

                            <input type="hidden" id="total">
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

  var idproduk = "<?php echo ($idproduk) ?>";

  $(document).ready(function() {

    $('.select2').select2();

    table = $("#table").DataTable();




    //----------------------------------------------------------------- > validasi
    $('#form').bootstrapValidator({
      feedbackIcons: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
      },
      fields: {
        judulgambar: {
          validators:{
            notEmpty: {
                message: "judul gambar tidak boleh kosong"
            },
          }
        },
      }
    });
  //------------------------------------------------------------------------> END VALIDASI DAN SIMPAN


    $("form").attr('autocomplete', 'off');
    // $('#tglterima').mask('00-00-0000', {placeholder:"hh-bb-tttt"});
    // $('#hargabelisatuan').mask('000,000,000,000', {reverse: true, placeholder:"000,000,000,000"});
  }); //end (document).ready



    $(document).on("click", "#hapus", function(e) {
        var link = $(this).attr("href");
        e.preventDefault();
        bootbox.confirm("Anda yakin ingin menghapus data ini ?", function(result) {
          if (result) {
            document.location.href = link;
          }
        });
      });


</script>


</body>
</html>
