<?php
$this->load->view("template/header");
$this->load->view("template/topmenu");
$this->load->view("template/sidemenu");
?>

  <div class="row" id="toni-breadcrumb">
    <div class="col-6">
        <h4 class="text-dark mt-2">Batchnumber Produk</h4>
    </div>
    <div class="col-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="<?php echo (site_url()) ?>">Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo (site_url('batchnumber')) ?>">Batchnumber Produk</a></li>
        <li class="breadcrumb-item active" id="breadcrumbaactive">Tambah</li>
      </ol>

    </div>
  </div>


  <div class="row" id="toni-content">
    <div class="col-md-12">
        <div class="row">
          <div class="col-md-12">
            <div class="card" id="cardcontent">
              <div class="card-header">
                <h5 class="card-title" id="titlecard">Tambah Batchnumber Produk</h5>
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




                  <!-- <div class="col-12">
                    
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                      <strong>Perhatian!</strong> Jika tidak ada diskon, maka harga diskon sama dengan harga normal!
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>

                  </div> -->

                  <div class="col-md-12">



                      <form action="<?php echo (site_url('batchnumber/simpanbatchnumber')) ?>" method="post" id="form" enctype="multipart/form-data">


                              <input type="hidden" name="idproduk" id="idproduk" value="<?php echo $idproduk ?>">
                              <input type="hidden" name="idprodukbatchnumber" id="idprodukbatchnumber" value="<?php echo $idprodukbatchnumber ?>">


                              <div class="form-group row">
                                <label for="" class="col-md-3 col-form-label">Nomor Batch</label>
                                <div class="col-md-6">
                                  <input type="text" name="nomorbatch" id="nomorbatch" class="form-control" placeholder="Nomor batch">       
                                </div>
                              </div>

                              <div class="form-group row">
                                <label for="" class="col-md-3 col-form-label">Deskripsi</label>
                                <div class="col-md-9">
                                  <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3" placeholder="Deskripsi batchnumber"></textarea>
                                </div>
                              </div>

                              <div class="form-group row">
                                <label for="" class="col-md-3 col-form-label">Upload File Batchnumber</label>
                                <div class="col-md-9">
                                  <div class="row">
                                    <div class="col-12">
                                      <input type="file" name="filebatch" id="filebatch" accept="image/*, application/pdf">
                                      <input type="hidden" name="filebatch_lama" id="filebatch_lama">
                                    </div>
                                    <div class="col-12">
                                      <a href="" target="_blank" name="filelink" id="filelink"></a>
                                    </div>
                                  </div>
                                </div>
                              </div>


                              
                              <div class="form-group row">
                                <div class="col-md-12">
                                  <button class="btn btn-primary float-right" type="submit"><i class="fa fa-save"></i> Simpan</button>
                                </div>
                              </div>

                          </form>


                          <div class="col-md-12 mt-5">
                            <h3 class="text-muted text-center">LIST DATA BATCH NUMBER</h3>
                            <div class="table-responsive">
                              <table id="table" class="display" style="width: 100%;">
                                  <thead>
                                      <tr>
                                          <th style="width: 5%; text-align: center;">No</th>
                                          <th style="text-align: center;">Nomor Batch</th>
                                          <th style="text-align: left;">Deskripsi</th>
                                          <th style="text-align: left;">File Batch</th>
                                          <th style="text-align: center;">Stok</th>
                                          <th style="text-align: center;">Aksi</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    <?php
$rsbatchnumber = $this->db->query("select * from produkbatchnumber where idproduk='" . $idproduk . "' order by nomorbatch asc");
if ($rsbatchnumber->num_rows() > 0) {
    $no = 1;
    foreach ($rsbatchnumber->result() as $row) {
        echo '
                                            <tr>
                                                <td style="width: 5%; text-align: center;">' . $no++ . '</th>
                                                <td style="text-align: center">' . $row->nomorbatch . '</th>
                                                <td style="text-align: left">' . $row->deskripsi . '</th>
                                                <td style="text-align: left">' . $row->filebatch . '</th>
                                                <td style="text-align: center">' . $row->stok . '</th>
                                                <td style="text-align: center;">
                                                  <a href="' . site_url('batchnumber/editbatchnumber/' . $this->encrypt->encode($row->idprodukbatchnumber)) . '" class="btn btn-sm btn-warning btn-circle"><i class="fa fa-edit"></i></a> |
                                                  <a href="' . site_url('batchnumber/deletebatchnumber/' . $this->encrypt->encode($row->idprodukbatchnumber)) . '" class="btn btn-sm btn-danger btn-circle" id="hapus"><i class="fa fa-trash"></i></a>
                                                </th>
                                            </tr>

                                          ';
    }
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
  var idprodukbatchnumber = "<?php echo ($idprodukbatchnumber) ?>";

  $(document).ready(function() {

    $('.select2').select2();

    table = $("#table").DataTable();


    //---------------------------------------------------------> JIKA EDIT DATA
    if ( idproduk != "" ) {
          $.ajax({
              type        : 'POST',
              url         : '<?php echo site_url("batchnumber/get_edit_data_batchnumber") ?>',
              data        : {idprodukbatchnumber: idprodukbatchnumber},
              dataType    : 'json',
              encode      : true
          })
          .done(function(result) {
            console.log(result);
            $("#idproduk").val(result.idproduk);
            $("#idprodukbatchnumber").val(result.idprodukbatchnumber);
            $("#nomorbatch").val(result.nomorbatch);
            $("#deskripsi").val(result.deskripsi);
            $("#filebatch_lama").val(result.filebatch);
            $('#filelink').html(result.filebatch);
            $('#filelink').attr('href', result.filelink);
          });

          $('#breadcrumbaactive').html('Edit');
          $('#titlecard').html('Edit Batchnumber Produk');
    }



    //----------------------------------------------------------------- > validasi
    $('#form').bootstrapValidator({
      feedbackIcons: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
      },
      fields: {
        nomorbatch: {
          validators:{
            notEmpty: {
                message: "nomor batch tidak boleh kosong"
            },
          }
        },
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
