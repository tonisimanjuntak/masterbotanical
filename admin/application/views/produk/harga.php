<?php
$this->load->view("template/header");
$this->load->view("template/topmenu");
$this->load->view("template/sidemenu");
?>

  <div class="row" id="toni-breadcrumb">
    <div class="col-6">
        <h4 class="text-dark mt-2">Produk</h4>
    </div>
    <div class="col-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="<?php echo (site_url()) ?>">Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo (site_url('produk')) ?>">Produk</a></li>
        <li class="breadcrumb-item active">Harga</li>
      </ol>

    </div>
  </div>


  <div class="row" id="toni-content">
    <div class="col-md-12">
        <div class="row">
          <div class="col-md-12">
            <div class="card" id="cardcontent">
              <div class="card-header">
                <h5 class="card-title">Paket Harga Produk</h5>
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



                      <form action="<?php echo (site_url('produk/simpanharga')) ?>" method="post" id="form">
                            <div class="row">


                              <input type="hidden" name="idproduk" id="idproduk" value="<?php echo $idproduk ?>">
                              <input type="hidden" name="idprodukharga" id="idprodukharga" value="<?php echo $idprodukharga ?>">


                              <div class="col-md-2">
                                <div class="form-group">
                                  <label for="">Berat Produk</label>
                                  <input type="text" name="berat" id="berat" class="form-control berat">
                                </div>
                              </div>

                              <div class="col-md-2">
                                <div class="form-group">
                                  <label for="">Harga Normal</label>
                                  <input type="text" name="hargasebelumdiskon" id="hargasebelumdiskon" class="form-control rupiah">
                                </div>
                              </div>

                              <div class="col-md-2">
                                <div class="form-group">
                                  <label for="">Harga Diskon</label>
                                  <input type="text" name="harga" id="harga" class="form-control rupiah">
                                </div>
                              </div>


                              <div class="col-md-2">
                                <button class="btn btn-primary btn-block mt-4" type="submit">Tambahkan</button>
                              </div>

                            </div>
                          </form>


                          <div class="col-md-12 mt-5">

                            <div class="table-responsive">
                              <table id="table" class="display" style="width: 100%;">
                                  <thead>
                                      <tr>
                                          <th style="width: 5%; text-align: center;">No</th>
                                          <th style="text-align: center;">Berat (KG)</th>
                                          <th style="text-align: right;">Harga Normal</th>
                                          <th style="text-align: right;">Harga Diskon</th>
                                          <th style="text-align: center;">Aksi</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    <?php
$rsharga = $this->db->query("select * from produkharga where idproduk='" . $idproduk . "' order by berat");
if ($rsharga->num_rows() > 0) {
    $no = 1;
    foreach ($rsharga->result() as $row) {
        echo '
                                            <tr>
                                                <td style="width: 5%; text-align: center;">' . $no++ . '</th>
                                                <td style="text-align: center">' . $row->berat . '</th>
                                                <td style="text-align: right;">' . format_rupiah($row->hargasebelumdiskon) . '</th>
                                                <td style="text-align: right;">' . format_rupiah($row->harga) . '</th>
                                                <td style="text-align: center;">
                                                  <a href="' . site_url('produk/editharga/' . $this->encrypt->encode($row->idprodukharga)) . '" class="btn btn-sm btn-warning btn-circle"><i class="fa fa-edit"></i></a> |
                                                  <a href="' . site_url('produk/deleteharga/' . $this->encrypt->encode($row->idprodukharga)) . '" class="btn btn-sm btn-danger btn-circle" id="hapus"><i class="fa fa-trash"></i></a>
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
  var idprodukharga = "<?php echo ($idprodukharga) ?>";

  $(document).ready(function() {

    $('.select2').select2();

    table = $("#table").DataTable();


    //---------------------------------------------------------> JIKA EDIT DATA
    if ( idproduk != "" ) {
          $.ajax({
              type        : 'POST',
              url         : '<?php echo site_url("Produk/get_edit_data_harga") ?>',
              data        : {idprodukharga: idprodukharga},
              dataType    : 'json',
              encode      : true
          })
          .done(function(result) {
            $("#idproduk").val(result.idproduk);
            $("#idprodukharga").val(result.idprodukharga);
            $("#berat").val(result.berat);
            $("#harga").val(result.harga);
            $("#hargasebelumdiskon").val(result.hargasebelumdiskon);

          });


          $("#lblactive").html("Edit Harga");

    }



    //----------------------------------------------------------------- > validasi
    $('#form').bootstrapValidator({
      feedbackIcons: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
      },
      fields: {
        berat: {
          validators:{
            notEmpty: {
                message: "berat tidak boleh kosong"
            },
          }
        },
        harga: {
          validators:{
            notEmpty: {
                message: "harga diskon tidak boleh kosong"
            },
          }
        },
        hargasebelumdiskon: {
          validators:{
            notEmpty: {
                message: "harga normal tidak boleh kosong"
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
