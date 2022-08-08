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
                <h5 class="card-title">Detail Gambar Produk</h5>
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



                      <form action="<?php echo (site_url('produk/simpandetailgambar')) ?>" method="post" id="form" enctype="multipart/form-data">
                        <div class="row">


                          <input type="hidden" name="idproduk" id="idproduk" value="<?php echo $idproduk ?>">

                          <div class="col-md-12">
                            <div class="form-group row">
                              <label for="" class="col-form-label col-md-2">Gambar Produk</label>
                              <div class="col-md-6">
                                <input type="file" name="gambarproduk" id="gambarproduk" class="">
                              </div>
                              <div class="col-md-2">
                                <button class="btn btn-primary btn-block" type="submit">Tambahkan</button>
                              </div>
                            </div>
                          </div>

                        </div>
                      </form>


                          <div class="col-md-6 mt-5">

                            <div class="table-responsive">
                              <table id="table" class="display" style="width: 100%;">
                                  <thead>
                                      <tr>
                                          <th style="width: 5%; text-align: center;">No</th>
                                          <th style="width: 70%; text-align: center;">Gambar</th>
                                          <th style="text-align: right;">Nama File</th>
                                          <th style="text-align: center;">Aksi</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    <?php
$rsharga = $this->db->query("select * from produkimage where idproduk='" . $idproduk . "' order by idprodukimage");
if ($rsharga->num_rows() > 0) {
    $no = 1;
    foreach ($rsharga->result() as $row) {
        if (!empty($row->gambarproduk)) {
            $gambarproduk = base_url('../uploads/produkdetail/' . $row->gambarproduk);
        } else {
            $gambarproduk = base_url('../images/nofoto.png');
        }
        echo '
                                            <tr>
                                                <td style="width: 5%; text-align: center;">' . $no++ . '</th>
                                                <td style="text-align: center"><img src="' . $gambarproduk . '" alt="" style="width:80%;"></th>
                                                <td style="text-align: right;">' . $row->gambarproduk . '</th>
                                                <td style="text-align: center;">
                                                  <a href="' . site_url('produk/deletedetailgambar/' . $this->encrypt->encode($row->idprodukimage)) . '" class="btn btn-sm btn-danger btn-circle" id="hapus"><i class="fa fa-trash"></i></a>
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
        gambarproduk: {
          validators:{
            notEmpty: {
                message: "gambarproduk tidak boleh kosong"
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
