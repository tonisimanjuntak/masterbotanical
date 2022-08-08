<?php
$this->load->view("template/header");
$this->load->view("template/topmenu");
$this->load->view("template/sidemenu");
?>

  <div class="row" id="toni-breadcrumb">
    <div class="col-6">
        <h4 class="text-dark mt-2">Packing</h4>
    </div>
    <div class="col-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="<?php echo (site_url()) ?>">Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo (site_url('packing')) ?>">Packing</a></li>
        <li class="breadcrumb-item active" id="lblactive"></li>
      </ol>

    </div>
  </div>


  <div class="row" id="toni-content">
    <div class="col-md-12">

      <form action="<?php echo (site_url('packing/simpan')) ?>" method="post" id="form" enctype="multipart/form-data">

        <div class="row">
          <div class="col-md-7">
            <div class="card">

              <div class="card-body">

                  <div class="col-md-12">
                  <?php
$pesan = $this->session->flashdata("pesan");
if (!empty($pesan)) {
    echo $pesan;
}
?>
                  </div>

                  <h4 class="text-info mb-4">Informasi Hasil Packing</h4><hr>

                  <input type="hidden" name="idpacking" id="idpacking" value="<?php echo $rowlaboratorium->idpacking ?>">
                  <input type="hidden" name="idlaboratorium" id="idlaboratorium" value="<?php echo $rowlaboratorium->idlaboratorium ?>">
                  <input type="hidden" name="sumberproduk" id="sumberproduk" value="<?php echo $rowlaboratorium->sumberproduk ?>">


                  <div class="form-group row required">
                    <label for="" class="col-md-4 col-form-label">Tanggal</label>
                    <div class="col-md-8">
                      <input type="date" name="tglpacking" id="tglpacking" class="form-control" value="<?php echo (!empty($rowlaboratorium->tglpacking)) ? date('Y-m-d', strtotime($rowlaboratorium->tglpacking)) : date('Y-m-d') ?>">
                    </div>
                  </div>

                  <div class="form-group row required">
                    <label for="" class="col-md-4 col-form-label">Keterangan</label>
                    <div class="col-md-8">
                      <textarea name="keterangan" id="keterangan" class="form-control" rows="3" placeholder="Masukkan keterangan"><?php echo $rowlaboratorium->keterangan ?></textarea>
                    </div>
                  </div>

                  <div class="col-12">
                    <h4>Nama Karyawan Yang Melakukan Packing</h3>
                  </div>

              </div> <!-- ./card-body -->

              <div class="card-footer">
                <button type="submit" class="btn btn-info float-right"><i class="fa fa-save"></i> Simpan</button>
                <a href="<?php echo (site_url('packing')) ?>" class="btn btn-default float-right mr-1 ml-1"><i class="fa fa-chevron-circle-left"></i> Kembali</a>
              </div>
            </div> <!-- /.card -->
          </div> <!-- /.col -->



          <div class="col-md-5">
            <div class="card">
              <div class="card-body">

                <h4 class="text-info mb-4">Informasi Laboratorium</h4><hr>

                <div class="row">
                  <div class="col-md-6 text-center">
                    <img src="<?php echo base_url('../uploads/produk/' . $rowlaboratorium->gambarproduk) ?>" alt="" style="width: 80%">
                  </div>
                  <div class="col-md-6">
                    <div class="form-group row">
                      <div class="col-12">
                        <h5><?php echo $rowlaboratorium->namaproduk ?></h5>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-12">
                        <h5>Jenis : <?php echo $rowlaboratorium->namajenis ?></h5>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 mt-4">

                    <table class="table">
                      <tbody>
                        <tr>
                          <td>Id Laboratorium</td>
                          <td>:</td>
                          <td><?php echo $rowlaboratorium->idlaboratorium ?> </td>
                        </tr>
                        <tr>
                          <td>Tgl Laboratorium</td>
                          <td>:</td>
                          <td><?php echo $rowlaboratorium->tgllaboratorium ?> </td>
                        </tr>
                        <tr>
                          <td>Berat Bruto</td>
                          <td>:</td>
                          <td><?php echo $rowlaboratorium->beratbruto ?> </td>
                        </tr>
                        <tr>
                          <td>Berat Netto</td>
                          <td>:</td>
                          <td><?php echo $rowlaboratorium->beratnetto ?> </td>
                        </tr>
                        <tr>
                          <td>Hasil Pemeriksaan Lab</td>
                          <td>:</td>
                          <td><?php echo $rowlaboratorium->statuspemeriksaan ?> </td>
                        </tr>
                        <tr>
                          <td>Dokumen Hasil Laboratorium</td>
                          <td>:</td>
                          <td>
                              <?php
if (!empty($rowlaboratorium->filehasillab)) {
    echo '
                                    <a href="' . base_url("../uploads/laboratorium/" . $rowlaboratorium->filehasillab) . '" target="_blank">' . $rowlaboratorium->filehasillab . '</a>';
} else {
    echo 'Tidak ada';
}
?>

                        </td>
                        </tr>
                      </tbody>
                    </table>

                  </div>
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

  var idpacking = "<?php echo ($idpacking) ?>";

  $(document).ready(function() {

    $('.select2').select2();

    //----------------------------------------------------------------- > validasi
    $('#form').bootstrapValidator({
      feedbackIcons: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
      },
      fields: {
        tglpacking: {
          validators:{
            notEmpty: {
                message: "tglpacking tidak boleh kosong"
            },
          }
        },
        keterangan: {
          validators:{
            notEmpty: {
                message: "keterangan tidak boleh kosong"
            },
          }
        },
        statuspemeriksaan: {
          validators:{
            notEmpty: {
                message: "status pemeriksaan tidak boleh kosong"
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




</script>


</body>
</html>
