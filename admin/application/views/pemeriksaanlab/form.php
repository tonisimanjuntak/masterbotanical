<?php
$this->load->view("template/header");
$this->load->view("template/topmenu");
$this->load->view("template/sidemenu");
?>

  <div class="row" id="toni-breadcrumb">
    <div class="col-6">
        <h4 class="text-dark mt-2">Pemeriksaan Laboratorium</h4>
    </div>
    <div class="col-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="<?php echo (site_url()) ?>">Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo (site_url('pemeriksaanlab')) ?>">Pemeriksaan Laboratorium</a></li>
        <li class="breadcrumb-item active" id="lblactive"></li>
      </ol>

    </div>
  </div>


  <div class="row" id="toni-content">
    <div class="col-md-12">

      <form action="<?php echo (site_url('pemeriksaanlab/simpan')) ?>" method="post" id="form" enctype="multipart/form-data">

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

                  <h4 class="text-info mb-4">Informasi Hasil Pemeriksaan Laboratorium</h4><hr>

                  <input type="hidden" name="idlaboratorium" id="idlaboratorium" value="<?php echo $rowproduksi->idlaboratorium ?>">
                  <input type="hidden" name="idproduksi" id="idproduksi" value="<?php echo $rowproduksi->idproduksi ?>">
                  <input type="hidden" name="sumberproduk" id="sumberproduk" value="<?php echo $rowproduksi->sumberproduk ?>">


                  <div class="form-group row required">
                    <label for="" class="col-md-4 col-form-label">Tanggal</label>
                    <div class="col-md-8">
                      <input type="date" name="tgllaboratorium" id="tgllaboratorium" class="form-control" value="<?php echo (!empty($rowproduksi->tgllaboratorium)) ? date('Y-m-d', strtotime($rowproduksi->tgllaboratorium)) : date('Y-m-d') ?>">
                    </div>
                  </div>

                  <div class="form-group row required">
                    <label for="" class="col-md-4 col-form-label">Status Test Laboratorium</label>
                    <div class="col-md-8">
                      <select name="statuspemeriksaan" id="statuspemeriksaan" class="form-control">
                        <option value="Belum Diperiksa" <?php echo ($rowproduksi->statuspemeriksaan=='Belum Diperiksa') ? 'selected="selected"' : '' ?> >Belum Diperiksa</option>
                        <option value="Lulus Test Lab" <?php echo ($rowproduksi->statuspemeriksaan=='Lulus Test Lab') ? 'selected="selected"' : '' ?> >Lulus Test Lab</option>
                        <option value="Gagal Test Lab" <?php echo ($rowproduksi->statuspemeriksaan=='Gagal Test Lab') ? 'selected="selected"' : '' ?>>Gagal Test Lab</option>
                      </select>
                    </div>
                  </div>


                  <div class="form-group row required">
                    <label for="" class="col-md-4 col-form-label">Keterangan</label>
                    <div class="col-md-8">
                      <textarea name="keterangan" id="keterangan" class="form-control" rows="3" placeholder="Masukkan keterangan"><?php echo $rowproduksi->keterangan ?></textarea>
                    </div>
                  </div>
                  
                  <div class="form-group row">
                      <label for="" class="col-md-4 col-form-label">Upload Hasil Lab <br><span style="color: red; font-size: 12px; font-weight: bold;"><i> Max ukuran file 2MB</i></span></label>
                      <div class="col-md-8">
                        <input type="file" name="file" id="file">
                        <input type="hidden" name="file_lama" id="file_lama" class="form-control" value="<?php echo $rowproduksi->filehasillab ?>" ><br>
                        <a href="<?php echo base_url('../uploads/laboratorium/'.$rowproduksi->filehasillab) ?>" target="_blank"><?php echo $rowproduksi->filehasillab ?></a>
                      </div>
                  </div>

              </div> <!-- ./card-body -->

              <div class="card-footer">
                <button type="submit" class="btn btn-info float-right"><i class="fa fa-save"></i> Simpan</button>
                <a href="<?php echo (site_url('pemeriksaanlab')) ?>" class="btn btn-default float-right mr-1 ml-1"><i class="fa fa-chevron-circle-left"></i> Kembali</a>
              </div>
            </div> <!-- /.card -->
          </div> <!-- /.col -->



          <div class="col-md-5">
            <div class="card">
              <div class="card-body">
                
                <h4 class="text-info mb-4">Informasi Produksi</h4><hr>

                <div class="row">
                  <div class="col-md-6 text-center">
                    <img src="<?php echo base_url('../uploads/produk/'.$rowproduksi->gambarproduk) ?>" alt="" style="width: 80%">
                  </div>
                  <div class="col-md-6">
                    <div class="form-group row">
                      <div class="col-12">
                        <h5><?php echo $rowproduksi->namaproduk ?></h5>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-12">
                        <h5>Jenis : <?php echo $rowproduksi->namajenis ?></h5>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 mt-4">
                    
                    <table class="table">
                      <tbody>
                        <tr>
                          <td>Id Produksi</td>
                          <td>:</td>
                          <td><?php echo $rowproduksi->idproduksi ?> </td>
                        </tr>
                        <tr>
                          <td>Tgl Produksi</td>
                          <td>:</td>
                          <td><?php echo $rowproduksi->tglproduksi ?> </td>
                        </tr>
                        <tr>
                          <td>Berat Bruto</td>
                          <td>:</td>
                          <td><?php echo $rowproduksi->beratbruto ?> </td>
                        </tr>
                        <tr>
                          <td>Berat Netto</td>
                          <td>:</td>
                          <td><?php echo $rowproduksi->beratnetto ?> </td>
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

  var idlaboratorium = "<?php echo ($idlaboratorium) ?>";

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
        tgllaboratorium: {
          validators:{
            notEmpty: {
                message: "tgllaboratorium tidak boleh kosong"
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
