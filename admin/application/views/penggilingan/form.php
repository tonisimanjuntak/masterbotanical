<?php
$this->load->view("template/header");
$this->load->view("template/topmenu");
$this->load->view("template/sidemenu");
?>

  <div class="row" id="toni-breadcrumb">
    <div class="col-6">
        <h4 class="text-dark mt-2">Penggilingan Bahan</h4>
    </div>
    <div class="col-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="<?php echo (site_url()) ?>">Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo (site_url('penggilingan')) ?>">Penggilingan Bahan</a></li>
        <li class="breadcrumb-item active" id="lblactive"></li>
      </ol>

    </div>
  </div>


  <div class="row" id="toni-content">
    <div class="col-md-12">
      <form action="<?php echo (site_url('penggilingan/simpan')) ?>" method="post" id="form" enctype="multipart/form-data">

              <div class="row">
                <div class="col-md-12">
                  <div class="card" id="cardcontent">
                    <div class="card-header">
                      <h5 class="card-title" id="lbljudul"></h5>
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


                        <input type="hidden" name="idpenggilingan" id="idpenggilingan">
                        <input type="hidden" name="idbahankeluar" id="idbahankeluar">

                        <div class="row">
                          <div class="col-md-8">
                              

                              <div class="form-group row required">
                                <label for="" class="col-md-3 col-form-label">Tanggal</label>
                                <div class="col-md-3">
                                  <input type="date" name="tglpenggilingan" id="tglpenggilingan" class="form-control" value="<?php echo date('Y-m-d') ?>">
                                </div>
                              </div>

                              <div class="form-group row required">
                                <label for="" class="col-md-3 col-form-label">Nama Penggiling</label>
                                <div class="col-md-9">
                                  <input type="text" name="namapenggiling" id="namapenggiling" class="form-control" placeholder="Masukkan nama penggiling">
                                </div>
                              </div>

                              <div class="form-group row required">
                                <label for="" class="col-md-3 col-form-label">Alamat Gudang</label>
                                <div class="col-md-9">
                                  <textarea name="alamatgudang" id="alamatgudang" class="form-control" rows="2" placeholder="Alamat gudang"></textarea>
                                </div>
                              </div>

                              <div class="form-group row required">
                                <label for="" class="col-md-3 col-form-label">Pemilik Remahan</label>
                                <div class="col-md-9">
                                  <input type="text" name="pemilikremahan" id="pemilikremahan" class="form-control" placeholder="Masukkan nama pemilik remahan">
                                </div>
                              </div>

                              <div class="form-group row required">
                                <label for="" class="col-md-3 col-form-label">Keterangan</label>
                                <div class="col-md-9">
                                  <textarea name="keterangan" id="keterangan" class="form-control" rows="3" placeholder="Masukkan keterangan"></textarea>
                                </div>
                              </div>

                              
                              <div class="form-group row required">
                                <label for="" class="col-md-3 col-form-label">Diserahkan Oleh</label>
                                <div class="col-md-9">
                                  <input type="text" name="diserahkanoleh" id="diserahkanoleh" class="form-control" placeholder="Diserahkan oleh">
                                </div>
                              </div>

                              <div class="form-group row required">
                                <label for="" class="col-md-3 col-form-label">Diterima Oleh</label>
                                <div class="col-md-9">
                                  <input type="text" name="diterimaoleh" id="diterimaoleh" class="form-control" placeholder="Diterima oleh">
                                </div>
                              </div>

                              <div class="form-group row required">
                                <label for="" class="col-md-3 col-form-label">Disetujui Oleh</label>
                                <div class="col-md-9">
                                  <input type="text" name="disetujuioleh" id="disetujuioleh" class="form-control" placeholder="Disetujui oleh">
                                </div>
                              </div>


                          </div>

                          <div class="col-md-4">
                            <div class="card">
                              <div class="card-body">
                                <h3>Informasi Bahan Keluar</h3>
                                <table class="table">
                                  <thead>
                                    <tr>
                                      <th style="width: 30%;">No Nota</th>
                                      <th style="width: 10%;">:</th>
                                      <th style="width: 60%;"><?php echo $rowbahankeluar->idbahankeluar ?></th>
                                    </tr>
                                    <tr>
                                      <th style="width: 30%;">Tanggal</th>
                                      <th style="width: 10%;">:</th>
                                      <th style="width: 60%;"><?php echo date('Y-m-d H:i:s', strtotime($rowbahankeluar->tglbahankeluar))  ?></th>
                                    </tr>
                                    <tr>
                                      <th style="width: 30%;">No.Kend</th>
                                      <th style="width: 10%;">:</th>
                                      <th style="width: 60%;"><?php echo $rowbahankeluar->nomorkendaraan ?></th>
                                    </tr>
                                    <tr>
                                      <th style="width: 30%;">Dikirim</th>
                                      <th style="width: 10%;">:</th>
                                      <th style="width: 60%;"><?php echo $rowbahankeluar->dikirimoleh_keluar ?></th>
                                    </tr>
                                    <tr>
                                      <th style="width: 30%;">Diperiksa</th>
                                      <th style="width: 10%;">:</th>
                                      <th style="width: 60%;"><?php echo $rowbahankeluar->diperiksaoleh_keluar ?></th>
                                    </tr>
                                    <tr>
                                      <th style="width: 30%;">Diterima</th>
                                      <th style="width: 10%;">:</th>
                                      <th style="width: 60%;"><?php echo $rowbahankeluar->diterimaoleh_keluar ?></th>
                                    </tr>
                                    <tr>
                                      <th style="width: 30%;">Keterangan</th>
                                      <th style="width: 10%;">:</th>
                                      <th style="width: 60%;"><?php echo $rowbahankeluar->keterangan_keluar ?></th>
                                    </tr>
                                  </thead>
                                </table>
                              </div>
                            </div>  
                          </div>

                        </div>

                        



                        <div class="form-group row required" style="display: none;">
                          <label for="" class="col-md-2 col-form-label">TOtal Berat Bahan</label>
                          <div class="col-md-10">
                            <input type="text" name="totalberatbahan" id="totalberatbahan" class="form-control">
                          </div>
                        </div>



                        <div class="col-md-12">
                          <div class="card">
                            <div class="card-body">
                                <h3 class="text-muted text-center">Detail Hasil Penggilingan Bahan</h3>
                                <hr>
                                <div class="table-responsive">
                                  <table id="table" class="display" style="width: 100%;">
                                      <thead>
                                          <tr>
                                              <th style="width: 5%; text-align: center;">No</th>
                                              <th style="">Nama Bahan</th>
                                              <th style="text-align: center;">Berat Bahan Keluar</th>
                                              <th style="width: 15%; text-align: center;">Berat Bahan Hasil Penggilingan</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          <?php  
                                            $query            = "select * from v_bahankeluardetail
                                                                  WHERE v_bahankeluardetail.idbahankeluar='" . $rowbahankeluar->idbahankeluar . "'";
                                            $rsdetail = $this->db->query($query);
                                            if ($rsdetail->num_rows()>0) {
                                              $no = 1;
                                              foreach ($rsdetail->result() as $row) {
                                                if (!empty($row->beratbahanhasil) || $row->beratbahanhasil!=0) {
                                                  $beratbahanhasil = $row->beratbahanhasil;
                                                }else{
                                                  $beratbahanhasil = $row->beratbahankeluar;
                                                }

                                                echo '
                                                    <tr>
                                                        <th style="text-align: center;">'.$no++.'</th>
                                                        <th style="">'.$row->namabahan.'</th>
                                                        <th style="text-align: center;">'.$row->beratbahankeluar.'</th>
                                                        <th style="text-align: right;"><input type="text" class="form-control berat" name="beratbahanhasil'.$row->idbahan.'" value="'.$beratbahanhasil.'"></th>
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

                          <input type="hidden" id="total">
                        </div>


                    </div> <!-- ./card-body -->

                    <div class="card-footer">
                      <button type="submit" class="btn btn-info float-right" id="simpan"><i class="fa fa-save"></i> Simpan</button>
                      <a href="<?php echo (site_url('penggilingan')) ?>" class="btn btn-default float-right mr-1 ml-1"><i class="fa fa-chevron-circle-left"></i> Kembali</a>
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

  var idpenggilingan = "<?php echo ($rowbahankeluar->idpenggilingan) ?>";
  var idbahankeluar = "<?php echo ($rowbahankeluar->idbahankeluar) ?>";

  $(document).ready(function() {

    $('.select2').select2();


    $.ajax({
            type        : 'POST',
            url         : '<?php echo site_url("penggilingan/get_edit_data") ?>',
            data        : {idbahankeluar: idbahankeluar},
            dataType    : 'json',
            encode      : true
        })
        .done(function(result) {
          console.log(result);
          $('#idbahankeluar').val(result.idbahankeluar);
          $('#idpenggilingan').val(result.idpenggilingan);
          $('#tglpenggilingan').val(result.tglpenggilingan);
          $('#namapenggiling').val(result.namapenggiling);
          $('#alamatgudang').val(result.alamatgudang);
          $('#pemilikremahan').val(result.pemilikremahan);
          $('#keterangan').val(result.keterangan);
          $('#diserahkanoleh').val(result.diserahkanoleh);
          $('#diterimaoleh').val(result.diterimaoleh);
          $('#disetujuioleh').val(result.disetujuioleh);
        });

        $('#lbljudul').html('Penerimaan Hasil Penggilingan');
        $('#lblactive').html('Edit');

    table = $('#table').DataTable({
        "select": true,
            "processing": false,
            "ordering": false,
            "bPaginate": false,
            "searching": false,
            "bInfo" : false
        });



        



    //----------------------------------------------------------------- > validasi
    $('#form').bootstrapValidator({
      feedbackIcons: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
      },
      fields: {
        tglpenggilingan: {
          validators:{
            notEmpty: {
                message: "tanggal penggilingan tidak boleh kosong"
            },
          }
        },
        namapenggiling: {
          validators:{
            notEmpty: {
                message: "nama penggiling tidak boleh kosong"
            },
          }
        },
        alamatgudang: {
          validators:{
            notEmpty: {
                message: "alamat gudang tidak boleh kosong"
            },
          }
        },
        pemilikremahan: {
          validators:{
            notEmpty: {
                message: "nama pemilik remahan tidak boleh kosong"
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
        diserahkanoleh: {
          validators:{
            notEmpty: {
                message: "diserahkan oleh tidak boleh kosong"
            },
          }
        },
        diterimaoleh: {
          validators:{
            notEmpty: {
                message: "diterimaoleh oleh tidak boleh kosong"
            },
          }
        },
        disetujuioleh: {
          validators:{
            notEmpty: {
                message: "diserahkan oleh tidak boleh kosong"
            },
          }
        },
      }
    })
    .on('success.form.bv', function(e) {
      // e.preventDefault();
      $('#simpan').attr('disabled', false);
      return;
    });
  //------------------------------------------------------------------------> END VALIDASI DAN SIMPAN


    $("form").attr('autocomplete', 'off');
    // $('#tglterima').mask('00-00-0000', {placeholder:"hh-bb-tttt"});
    // $('#hargabelisatuan').mask('000,000,000,000', {reverse: true, placeholder:"000,000,000,000"});
  }); //end (document).ready


</script>


</body>
</html>
